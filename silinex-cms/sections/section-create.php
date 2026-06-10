<?php
require_once __DIR__ . '/../includes/auth.php'; require_auth();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

$pageId = (int)($_GET['page_id'] ?? 0);
if (!$pageId) { header('Location: /cms/pages/pages-list.php'); exit; }

$page = $pdo->prepare("SELECT * FROM pages WHERE id = ?");
$page->execute([$pageId]);
$page = $page->fetch();
if (!$page) { http_response_code(404); die('Page not found.'); }

$sectionTypes = ['hero','services','stats','about','testimonial','faq','cta-banner','custom-html'];
$bgThemes     = ['white','light','dark','blue'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request.';
    } else {
        $type    = in_array($_POST['section_type'] ?? '', $sectionTypes) ? $_POST['section_type'] : 'custom-html';
        $title   = trim($_POST['title']   ?? '');
        $content = trim($_POST['content'] ?? '');
        $bg      = in_array($_POST['bg_theme'] ?? '', $bgThemes) ? $_POST['bg_theme'] : 'white';
        $maxOrder = $pdo->prepare("SELECT MAX(section_order) FROM sections WHERE page_id = ?");
        $maxOrder->execute([$pageId]);
        $order = ((int)$maxOrder->fetchColumn()) + 1;

        $pdo->prepare("INSERT INTO sections (page_id, section_type, title, content, bg_theme, section_order, status) VALUES (?,?,?,?,?,?,'draft')")
            ->execute([$pageId, $type, $title, $content, $bg, $order]);

        header('Location: /cms/pages/page-edit.php?id=' . $pageId . '&created=1');
        exit;
    }
}

$pageTitle = 'Add Section — ' . $page['title'];
$activeNav = 'pages';
include __DIR__ . '/../includes/layout-header.php';
?>
<div class="breadcrumb">
  <a href="/cms/pages/pages-list.php">Pages</a>
  <span class="breadcrumb-sep">›</span>
  <a href="/cms/pages/page-edit.php?id=<?= $pageId ?>"><?= htmlspecialchars($page['title']) ?></a>
  <span class="breadcrumb-sep">›</span>
  <span>Add Section</span>
</div>

<?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="card" style="max-width:680px;">
  <h2 style="margin-bottom:var(--space-lg);">Add Section</h2>
  <form method="POST">
    <?= csrf_field() ?>
    <div class="form-group">
      <label>Section Type</label>
      <select name="section_type">
        <?php foreach ($sectionTypes as $t): ?>
        <option value="<?= $t ?>"><?= ucwords(str_replace('-', ' ', $t)) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Title (optional)</label>
      <input type="text" name="title" placeholder="Section heading">
    </div>
    <div class="form-group">
      <label>Content / HTML</label>
      <textarea name="content" rows="8" placeholder="HTML content for this section"></textarea>
    </div>
    <div class="form-group">
      <label>Background Theme</label>
      <select name="bg_theme">
        <?php foreach ($bgThemes as $t): ?>
        <option value="<?= $t ?>"><?= ucfirst($t) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div style="display:flex;gap:10px;">
      <button type="submit" class="btn-primary">Add Section</button>
      <a href="/cms/pages/page-edit.php?id=<?= $pageId ?>" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>
<?php include __DIR__ . '/../includes/layout-footer.php'; ?>
