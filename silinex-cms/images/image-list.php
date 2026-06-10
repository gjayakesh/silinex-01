<?php
require_once __DIR__ . '/../includes/auth.php'; require_auth();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

$uploadDir = __DIR__ . '/../uploads/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$error = ''; $success = '';

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request.';
    } else {
        $file = $_FILES['image'];
        $allowed = ['image/jpeg','image/png','image/webp','image/gif','image/svg+xml'];
        if (!in_array($file['type'], $allowed)) {
            $error = 'Only JPEG, PNG, WebP, GIF and SVG files are allowed.';
        } elseif ($file['size'] > 5 * 1024 * 1024) {
            $error = 'File too large (max 5MB).';
        } else {
            $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = bin2hex(random_bytes(8)) . '_' . time() . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                $alt = trim($_POST['alt_text'] ?? '');
                $user = current_user();
                $pdo->prepare("INSERT INTO images (filename, alt_text, file_size, mime_type, uploaded_by) VALUES (?,?,?,?,?)")
                    ->execute([$filename, $alt, $file['size'], $file['type'], $user['id'] ?? null]);
                $success = 'Image uploaded successfully.';
            } else {
                $error = 'Upload failed. Check folder permissions.';
            }
        }
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $imgId = (int)$_GET['delete'];
    $img = $pdo->prepare("SELECT filename FROM images WHERE id = ?");
    $img->execute([$imgId]);
    $img = $img->fetch();
    if ($img) {
        @unlink($uploadDir . $img['filename']);
        $pdo->prepare("DELETE FROM images WHERE id = ?")->execute([$imgId]);
    }
    header('Location: /cms/images/image-list.php?deleted=1');
    exit;
}

$images = $pdo->query("SELECT * FROM images ORDER BY created_at DESC")->fetchAll();
$pageTitle = 'Image Library';
$activeNav = 'images';
include __DIR__ . '/../includes/layout-header.php';
?>
<?php if (isset($_GET['deleted'])): ?><div class="alert alert-success">Image deleted.</div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success">✅ <?= htmlspecialchars($success) ?></div><?php endif; ?>
<?php if ($error):   ?><div class="alert alert-error">❌ <?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="page-header">
  <h2>Image Library</h2>
</div>

<div class="card" style="margin-bottom:var(--space-lg);max-width:500px;">
  <h3 style="margin-bottom:var(--space-md);">Upload Image</h3>
  <form method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="form-group">
      <label>Image File (JPEG, PNG, WebP, GIF, SVG — max 5MB)</label>
      <input type="file" name="image" accept="image/*" required>
    </div>
    <div class="form-group">
      <label>Alt Text</label>
      <input type="text" name="alt_text" placeholder="Descriptive text for accessibility">
    </div>
    <button type="submit" class="btn-primary">Upload</button>
  </form>
</div>

<?php if ($images): ?>
<div class="image-grid">
  <?php foreach ($images as $img): ?>
  <div class="image-card">
    <img src="/cms/uploads/<?= htmlspecialchars($img['filename']) ?>"
         alt="<?= htmlspecialchars($img['alt_text'] ?? '') ?>">
    <div class="image-card-meta">
      <div style="word-break:break-all;"><?= htmlspecialchars($img['filename']) ?></div>
      <div style="margin-top:4px;display:flex;gap:6px;align-items:center;">
        <button onclick="copyUrl('/cms/uploads/<?= htmlspecialchars($img['filename']) ?>')"
                class="btn-secondary btn-sm">Copy URL</button>
        <a href="?delete=<?= $img['id'] ?>"
           data-confirm="Delete this image?"
           class="btn-danger btn-sm">Del</a>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<?php else: ?>
<p class="caption">No images uploaded yet.</p>
<?php endif; ?>

<script>
function copyUrl(url) {
  navigator.clipboard.writeText(window.location.origin + url)
    .then(() => alert('URL copied to clipboard!'));
}
</script>
<?php include __DIR__ . '/../includes/layout-footer.php'; ?>
