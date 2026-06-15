<?php
/**
 * Edit a page from the live site.
 * Accessible to editors and admins.
 */
require_once __DIR__ . '/includes/auth.php';
require_editor_or_admin();
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/csrf.php';

$pageId = (int)($_GET['id'] ?? 0);
if ($pageId <= 0) {
    header('Location: /cms/pages/pages-list.php');
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postedToken = $_POST['csrf_token'] ?? '';
    if (!csrf_verify($postedToken)) {
        $error = 'Invalid CSRF token. Please try again.';
    } else {
        $title   = trim($_POST['title']   ?? '');
        $slug    = trim($_POST['slug']    ?? '');
        $content = $_POST['content']      ?? '';

        if ($title === '' || $slug === '') {
            $error = 'Title and slug are required.';
        } else {
            $stmt = $pdo->prepare(
                'UPDATE pages SET title = ?, slug = ?, content = ?, updated_at = datetime("now") WHERE id = ?'
            );
            $stmt->execute([$title, $slug, $content, $pageId]);
            header('Location: /cms/pages/pages-list.php?updated=' . $pageId);
            exit;
        }
    }
}

$stmt = $pdo->prepare('SELECT * FROM pages WHERE id = ?');
$stmt->execute([$pageId]);
$page = $stmt->fetch();
if (!$page) {
    die('Page not found.');
}

// Ensure content is always a string (column may be NULL)
$pageContent = $page['content'] ?? '';

$pageTitle = 'Edit Page';
$activeNav = 'pages';
include __DIR__ . '/includes/layout-header.php';
?>

<div class="page-header">
    <div>
        <h2>Edit Page: <?= htmlspecialchars($page['title']) ?></h2>
        <p class="caption">Update the title, slug, and page content.</p>
    </div>
    <a href="/cms/pages/pages-list.php" class="btn-secondary btn-sm">← Back to Pages</a>
</div>

<?php if ($error): ?>
<div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
    <form method="POST" id="edit-page-form">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="title">Page Title</label>
            <input type="text" name="title" id="title"
                   value="<?= htmlspecialchars($page['title']) ?>" required>
        </div>

        <div class="form-group">
            <label for="slug">URL Slug</label>
            <input type="text" name="slug" id="slug"
                   value="<?= htmlspecialchars($page['slug']) ?>" required>
            <small class="caption">e.g. <code>about-us</code> → silinexglobal.com/about-us</small>
        </div>

        <div class="form-group">
            <label for="content">Page Content (HTML)</label>
            <textarea name="content" id="content" rows="14"><?= htmlspecialchars($pageContent) ?></textarea>
        </div>

        <div style="display:flex;gap:10px;margin-top:16px;">
            <button type="submit" class="btn-primary">Save Changes</button>
            <a href="/cms/pages/pages-list.php" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<!-- TinyMCE (community self-hosted build — no API key needed) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"
        integrity="sha512-CqoklGYonGlLGQHaGJuXaZzTi7XN8mHp8eRz3rCxVgcKuFkA9pXqJ5QoGlqXEm2VGnFwwBLuU+E5G4+nBfVw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  tinymce.init({
    selector: '#content',
    height: 420,
    menubar: false,
    promotion: false,
    branding: false,
    plugins: 'lists link table code fullscreen',
    toolbar:
      'undo redo | styles | bold italic underline | ' +
      'alignleft aligncenter alignright | ' +
      'bullist numlist outdent indent | link | code fullscreen',
    setup: function (editor) {
      // Sync TinyMCE content back to the textarea before form submit
      editor.on('change', function () { editor.save(); });
    }
  });
</script>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
