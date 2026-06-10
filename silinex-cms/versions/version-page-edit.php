<?php
/**
 * Version snapshot page review.
 * Editors change website content from Pages > Edit, then create/publish versions.
 */
require_once __DIR__ . '/../includes/auth.php'; require_editor_or_admin();
require_once __DIR__ . '/../includes/db.php';

$contentId = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("
    SELECT vc.*, v.version_number, v.id AS version_id
    FROM version_content vc
    JOIN versions v ON v.id = vc.version_id
    WHERE vc.id = ?
");
$stmt->execute([$contentId]);
$row = $stmt->fetch();
if (!$row) { http_response_code(404); die('Version page not found.'); }

$payload = json_decode($row['page_content'] ?? '{}', true) ?: [];
$metadata = json_decode($row['page_metadata'] ?? '{}', true) ?: [];
$page = $payload['page'] ?? [];
$sections = $payload['sections'] ?? [];

$livePageId = null;
if (!empty($page['slug'])) {
    $liveStmt = $pdo->prepare("SELECT id FROM pages WHERE slug = ?");
    $liveStmt->execute([$page['slug']]);
    $livePageId = $liveStmt->fetchColumn() ?: null;
}

function snapshot_preview_text(array $section): string {
    $content = json_decode($section['content'] ?? '{}', true) ?: [];
    $type = $section['section_type'] ?? '';

    if (in_array($type, ['services', 'stats', 'testimonial', 'faq'], true)) {
        $count = count($content['items'] ?? []);
        return $count . ' editable item' . ($count === 1 ? '' : 's') . ' in the CMS page editor';
    }

    foreach (['heading', 'subheading', 'body', 'html'] as $key) {
        if (!empty($content[$key])) {
            return substr(strip_tags((string)$content[$key]), 0, 140);
        }
    }

    return 'Content is managed from the section editor.';
}

$pageTitle = 'Version Page Snapshot';
$activeNav = 'versions';
include __DIR__ . '/../includes/layout-header.php';
?>

<div class="breadcrumb">
  <a href="/cms/versions/version-list.php">Versions</a>
  <span class="breadcrumb-sep">&gt;</span>
  <a href="/cms/versions/version-edit.php?id=<?= (int)$row['version_id'] ?>">Version <?= htmlspecialchars(format_version_number($row['version_number'])) ?></a>
  <span class="breadcrumb-sep">&gt;</span>
  <span><?= htmlspecialchars($page['title'] ?? 'Page') ?></span>
</div>

<div class="page-header">
  <div>
    <h2><?= htmlspecialchars($page['title'] ?? 'Page Snapshot') ?></h2>
    <p class="caption">Version <?= htmlspecialchars(format_version_number($row['version_number'])) ?> snapshot. Edit live content from Pages, then create a new version when ready.</p>
  </div>
  <div style="display:flex;gap:8px;flex-wrap:wrap;">
    <?php if ($livePageId): ?>
      <a href="/cms/pages/page-edit.php?id=<?= (int)$livePageId ?>" class="btn-primary">Edit CMS Page</a>
    <?php endif; ?>
    <a href="/cms/preview/preview.php?version=<?= urlencode($row['version_number']) ?>&page=<?= urlencode($page['slug'] ?? 'home') ?>" target="_blank" class="btn-secondary">Preview Snapshot</a>
  </div>
</div>

<div class="alert alert-info">Editors no longer need to edit version JSON. Use the page and section editors to change text, cards, FAQs, images, navigation, and new sections.</div>

<div style="display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:var(--space-lg);align-items:start;">
  <div class="card">
    <h3 style="margin-bottom:var(--space-md);">Sections in This Snapshot</h3>
    <?php foreach ($sections as $section): ?>
      <div class="version-page-row">
        <div>
          <strong><?= htmlspecialchars($section['title'] ?: ucfirst(str_replace('-', ' ', $section['section_type'] ?? 'Section'))) ?></strong>
          <div class="caption">
            <?= htmlspecialchars(ucfirst(str_replace('-', ' ', $section['section_type'] ?? 'Section'))) ?>
            · <?= htmlspecialchars($section['bg_theme'] ?? 'white') ?>
            · <?= htmlspecialchars($section['status'] ?? 'draft') ?>
          </div>
          <p class="caption"><?= htmlspecialchars(snapshot_preview_text($section)) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
    <?php if (!$sections): ?>
      <p class="caption">This snapshot has no sections.</p>
    <?php endif; ?>
  </div>

  <aside>
    <div class="card" style="margin-bottom:var(--space-md);">
      <h3 style="margin-bottom:var(--space-md);">Page Details</h3>
      <div class="version-meta">
        <div><strong>Slug:</strong> /<?= htmlspecialchars($page['slug'] ?? '') ?></div>
        <div><strong>Status:</strong> <?= htmlspecialchars($page['status'] ?? 'draft') ?></div>
        <div><strong>Meta title:</strong> <?= htmlspecialchars($page['meta_title'] ?? '') ?></div>
      </div>
    </div>

    <?php if (is_admin()): ?>
    <details class="card">
      <summary style="cursor:pointer;font-weight:700;color:var(--color-dark-navy);">Advanced snapshot data</summary>
      <div class="form-group" style="margin-top:var(--space-md);">
        <label>Sections JSON</label>
        <textarea readonly rows="12" class="form-textarea code-textarea"><?= htmlspecialchars(json_encode($sections, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></textarea>
      </div>
      <div class="form-group">
        <label>Navigation JSON</label>
        <textarea readonly rows="8" class="form-textarea code-textarea"><?= htmlspecialchars(json_encode($metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></textarea>
      </div>
    </details>
    <?php endif; ?>
  </aside>
</div>

<?php include __DIR__ . '/../includes/layout-footer.php'; ?>
