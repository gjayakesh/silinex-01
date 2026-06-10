<?php
/**
 * Silinex CMS — Versions helpers
 */

function list_versions(PDO $pdo): array {
    return $pdo->query("
        SELECT v.*, u.name AS creator_name 
        FROM versions v 
        LEFT JOIN users u ON u.id = v.created_by 
        ORDER BY v.created_at DESC
    ")->fetchAll();
}

function get_version(PDO $pdo, string $versionNumber): ?array {
    $stmt = $pdo->prepare("SELECT * FROM versions WHERE version_number = ?");
    $stmt->execute([$versionNumber]);
    return $stmt->fetch() ?: null;
}

function get_version_by_id(PDO $pdo, int $versionId): ?array {
    $stmt = $pdo->prepare("
        SELECT v.*, u.name AS creator_name 
        FROM versions v 
        LEFT JOIN users u ON u.id = v.created_by 
        WHERE v.id = ?
    ");
    $stmt->execute([$versionId]);
    return $stmt->fetch() ?: null;
}

function get_version_pages(PDO $pdo, int $versionId): array {
    $stmt = $pdo->prepare("SELECT * FROM version_content WHERE version_id = ?");
    $stmt->execute([$versionId]);
    $rows = $stmt->fetchAll();
    $pages = [];
    foreach ($rows as $row) {
        $payload = json_decode($row['page_content'], true) ?: [];
        $pages[] = [
            'content_id' => $row['id'],
            'page'       => $payload['page'] ?? [],
            'sections'   => $payload['sections'] ?? [],
        ];
    }
    return $pages;
}

function create_version_snapshot(PDO $pdo): array {
    $pages = $pdo->query("SELECT * FROM pages ORDER BY nav_order ASC, id ASC")->fetchAll();
    $snapshot = ['pages' => [], 'navbar' => []];

    foreach ($pages as $page) {
        $sections = $pdo->prepare("SELECT * FROM sections WHERE page_id = ? ORDER BY section_order ASC");
        $sections->execute([$page['id']]);
        $snapshot['pages'][$page['slug']] = [
            'page'     => $page,
            'sections' => $sections->fetchAll(),
        ];
    }

    $snapshot['navbar'] = $pdo->query(
        "SELECT * FROM navbar_items ORDER BY nav_order ASC"
    )->fetchAll();

    return $snapshot;
}

function generate_next_version_number(PDO $pdo, string $type): string {
    $latest = $pdo->query(
        "SELECT version_number FROM versions ORDER BY created_at DESC LIMIT 1"
    )->fetchColumn();

    if (!$latest) return '1.0';

    [$major, $minor] = array_map('intval', explode('.', $latest) + [1 => '0']);
    if ($type === 'major') {
        $major++;
        $minor = 0;
    } else {
        $minor++;
        if ($minor >= 100) {
            $major++;
            $minor = 0;
        }
    }
    return $major . '.' . $minor;
}

function create_version_from_base(PDO $pdo, string $versionType, int $baseVersionId, string $description, int $userId): int {
    $versionNumber = generate_next_version_number($pdo, $versionType);
    
    $snapshot = null;
    if ($baseVersionId > 0) {
        $base = get_version_by_id($pdo, $baseVersionId);
        if ($base) {
            $snapshot = json_decode($base['snapshot_json'], true);
        }
    }
    
    if (!$snapshot) {
        $snapshot = create_version_snapshot($pdo);
    }
    
    $snapshotJson = json_encode($snapshot);
    
    $stmt = $pdo->prepare("INSERT INTO versions (version_number, label, snapshot_json, status, created_by, description, version_type) VALUES (?, ?, ?, 'Draft', ?, ?, ?)");
    $stmt->execute([
        $versionNumber,
        'Version ' . $versionNumber,
        $snapshotJson,
        $userId,
        $description,
        $versionType
    ]);
    
    $versionId = (int)$pdo->lastInsertId();
    
    // Insert into version_content for each page in the snapshot
    if (!empty($snapshot['pages'])) {
        foreach ($snapshot['pages'] as $slug => $pageData) {
            $pageContent = json_encode($pageData);
            $pageMetadata = json_encode($snapshot['navbar'] ?? []);
            $stmtContent = $pdo->prepare("INSERT INTO version_content (version_id, page_content, page_metadata) VALUES (?, ?, ?)");
            $stmtContent->execute([$versionId, $pageContent, $pageMetadata]);
        }
    }
    
    // Log audit
    $stmtAudit = $pdo->prepare("INSERT INTO version_audit_log (version_id, user_id, action, details) VALUES (?, ?, 'create', ?)");
    $stmtAudit->execute([
        $versionId,
        $userId,
        "Created version from base ID: " . $baseVersionId
    ]);
    
    return $versionId;
}

function publish_version(PDO $pdo, int $versionId, int $userId): void {
    $version = get_version_by_id($pdo, $versionId);
    if (!$version) throw new Exception("Version not found.");

    $pdo->beginTransaction();
    try {
        // Archive previously published versions
        $pdo->prepare("UPDATE versions SET status = 'Archived' WHERE status = 'Published'")->execute();

        // Publish this version
        $pdo->prepare("UPDATE versions SET status = 'Published' WHERE id = ?")->execute([$versionId]);

        // Restore snapshot to active tables
        $snapshot = json_decode($version['snapshot_json'], true);
        if ($snapshot) {
            // Clear current active tables
            $pdo->exec("DELETE FROM pages");
            $pdo->exec("DELETE FROM sections");
            $pdo->exec("DELETE FROM navbar_items");

            // Restore pages & sections
            if (!empty($snapshot['pages'])) {
                foreach ($snapshot['pages'] as $slug => $pageData) {
                    $page = $pageData['page'];
                    $stmtPage = $pdo->prepare("INSERT INTO pages (id, title, slug, meta_title, meta_desc, status, in_navbar, nav_order, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmtPage->execute([
                        $page['id'] ?? null,
                        $page['title'] ?? '',
                        $page['slug'] ?? $slug,
                        $page['meta_title'] ?? null,
                        $page['meta_desc'] ?? null,
                        $page['status'] ?? 'draft',
                        $page['in_navbar'] ?? 1,
                        $page['nav_order'] ?? 0,
                        $page['created_at'] ?? date('Y-m-d H:i:s'),
                        $page['updated_at'] ?? date('Y-m-d H:i:s')
                    ]);

                    $newPageId = $pdo->lastInsertId() ?: ($page['id'] ?? null);

                    if (!empty($pageData['sections'])) {
                        foreach ($pageData['sections'] as $sec) {
                            $stmtSec = $pdo->prepare("INSERT INTO sections (id, page_id, section_type, title, content, settings_json, bg_theme, section_order, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $stmtSec->execute([
                                $sec['id'] ?? null,
                                $newPageId,
                                $sec['section_type'] ?? 'custom-html',
                                $sec['title'] ?? null,
                                $sec['content'] ?? null,
                                $sec['settings_json'] ?? null,
                                $sec['bg_theme'] ?? 'white',
                                $sec['section_order'] ?? 0,
                                $sec['status'] ?? 'draft',
                                $sec['created_at'] ?? date('Y-m-d H:i:s'),
                                $sec['updated_at'] ?? date('Y-m-d H:i:s')
                            ]);
                        }
                    }
                }
            }

            // Restore navbar_items
            if (!empty($snapshot['navbar'])) {
                foreach ($snapshot['navbar'] as $item) {
                    $stmtNav = $pdo->prepare("INSERT INTO navbar_items (id, label, href, parent_id, nav_order, is_visible, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmtNav->execute([
                        $item['id'] ?? null,
                        $item['label'] ?? '',
                        $item['href'] ?? '',
                        $item['parent_id'] ?? null,
                        $item['nav_order'] ?? 0,
                        $item['is_visible'] ?? 1,
                        $item['created_at'] ?? date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        // Add audit log
        $stmtAudit = $pdo->prepare("INSERT INTO version_audit_log (version_id, user_id, action, details) VALUES (?, ?, 'publish', ?)");
        $stmtAudit->execute([
            $versionId,
            $userId,
            "Published version: " . $version['version_number']
        ]);

        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function delete_version(PDO $pdo, int $versionId, int $userId): void {
    $version = get_version_by_id($pdo, $versionId);
    if (!$version) throw new Exception("Version not found.");
    if ($version['status'] === 'Published') {
        throw new Exception("Cannot delete a published version.");
    }

    $pdo->prepare("DELETE FROM versions WHERE id = ?")->execute([$versionId]);
}

function load_version_site_snapshot(PDO $pdo, ?string $versionNumber): ?array {
    if (!$versionNumber) return null;
    $v = get_version($pdo, $versionNumber);
    if (!$v) return null;
    return json_decode($v['snapshot_json'], true);
}

function format_version_number(string $versionNumber): string {
    if (strpos($versionNumber, '.') === false) {
        return $versionNumber;
    }

    [$major, $minor] = explode('.', $versionNumber, 2) + ['', '0'];
    $minor = rtrim($minor, '0');
    if ($minor === '') {
        $minor = '0';
    }

    return $major . '.' . $minor;
}
