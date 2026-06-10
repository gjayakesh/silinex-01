<?php
/**
 * Silinex CMS — Versions helpers
 */

function list_versions(PDO $pdo): array {
    return $pdo->query("SELECT * FROM versions ORDER BY created_at DESC")->fetchAll();
}

function get_version(PDO $pdo, string $versionNumber): ?array {
    $stmt = $pdo->prepare("SELECT * FROM versions WHERE version_number = ?");
    $stmt->execute([$versionNumber]);
    return $stmt->fetch() ?: null;
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

function generate_version_number(PDO $pdo): string {
    $latest = $pdo->query(
        "SELECT version_number FROM versions ORDER BY created_at DESC LIMIT 1"
    )->fetchColumn();

    if (!$latest) return '1.0';

    [$major, $minor] = array_map('intval', explode('.', $latest) + [1 => '0']);
    $minor++;
    if ($minor >= 100) { $major++; $minor = 0; }
    return $major . '.' . str_pad($minor, 2, '0', STR_PAD_LEFT);
}
