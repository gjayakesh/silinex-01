<?php
require_once __DIR__ . '/../includes/auth.php'; require_auth();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

$sectionId = (int)($_GET['id'] ?? 0);
if (!$sectionId) { header('Location: /cms/pages/pages-list.php'); exit; }

$sec = $pdo->prepare("SELECT s.*, p.title AS page_title FROM sections s JOIN pages p ON p.id = s.page_id WHERE s.id = ?");
$sec->execute([$sectionId]);
$sec = $sec->fetch();
if (!$sec) { http_response_code(404); die('Section not found.'); }

$sectionTypes = ['hero','services','stats','about','testimonial','faq','cta-banner','custom-html'];
$bgThemes     = ['white','light-blue','dark-navy'];
$statusOpts   = ['draft','published'];
$error = ''; $saved = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request.';
    } else {
        $type    = in_array($_POST['section_type'] ?? '', $sectionTypes) ? $_POST['section_type'] : $sec['section_type'];
        $title   = trim($_POST['title']   ?? '');
        $content = trim($_POST['content'] ?? '');
        $bg      = in_array($_POST['bg_theme'] ?? '', $bgThemes) ? $_POST['bg_theme'] : $sec['bg_theme'];
        $status  = in_array($_POST['status'] ?? '', $statusOpts) ? $_POST['status'] : $sec['status'];

        $pdo->prepare("UPDATE sections SET section_type=?, title=?, content=?, bg_theme=?, status=?, updated_at=CURRENT_TIMESTAMP WHERE id=?")
            ->execute([$type, $title, $content, $bg, $status, $sectionId]);
        $saved = 'Section saved.';
        $sec = array_merge($sec, compact('type','title','content','bg','status') + ['section_type'=>$type, 'bg_theme'=>$bg]);
    }
}

$pageTitle = 'Edit Section';
$activeNav = 'pages';
include __DIR__ . '/../includes/layout-header.php';
?>
<div class="breadcrumb">
  <a href="/cms/pages/pages-list.php">Pages</a>
  <span class="breadcrumb-sep">›</span>
  <a href="/cms/pages/page-edit.php?id=<?= $sec['page_id'] ?>"><?= htmlspecialchars($sec['page_title']) ?></a>
  <span class="breadcrumb-sep">›</span>
  <span>Edit Section</span>
</div>
<?php if ($saved):  ?><div class="alert alert-success">✅ <?= htmlspecialchars($saved) ?></div><?php endif; ?>
<?php if ($error):  ?><div class="alert alert-error">❌ <?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="card" style="max-width:740px;">
  <form method="POST">
    <?= csrf_field() ?>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-md);">
      <div class="form-group">
        <label>Section Type</label>
        <select name="section_type">
          <?php foreach ($sectionTypes as $t): ?>
          <option value="<?= $t ?>" <?= $sec['section_type']===$t?'selected':'' ?>><?= ucwords(str_replace('-',' ',$t)) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Status</label>
        <select name="status">
          <?php foreach ($statusOpts as $s): ?>
          <option value="<?= $s ?>" <?= $sec['status']===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label>Title (optional)</label>
      <input type="text" name="title" value="<?= htmlspecialchars($sec['title'] ?? '') ?>">
    </div>
    <div class="form-group">
      <label>Content / HTML</label>
      <textarea name="content" rows="12"><?= htmlspecialchars($sec['content'] ?? '') ?></textarea>
    </div>
    <div class="form-group">
      <label>Background Theme</label>
      <select name="bg_theme">
        <?php foreach ($bgThemes as $t): ?>
        <option value="<?= $t ?>" <?= $sec['bg_theme']===$t?'selected':'' ?>><?= ucfirst($t) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div style="display:flex;gap:10px;">
      <button type="submit" class="btn-primary">Save Section</button>
      <a href="/cms/pages/page-edit.php?id=<?= $sec['page_id'] ?>" class="btn-secondary">Back to Page</a>
    </div>
  </form>
</div>
<?php include __DIR__ . '/../includes/layout-footer.php'; ?>
