<?php
/**
 * Version creation workflow for major and minor website versions.
 */
require_once __DIR__ . '/../includes/auth.php'; require_editor_or_admin();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/versions.php';

$versions = list_versions($pdo);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request.';
    } else {
        try {
            $newId = create_version_from_base(
                $pdo,
                $_POST['version_type'] ?? 'minor',
                (int)($_POST['base_version_id'] ?? 0),
                $_POST['description'] ?? '',
                (int)current_user()['id']
            );
            header('Location: /cms/versions/version-edit.php?id=' . $newId . '&created=1');
            exit;
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }
}

$pageTitle = 'Create Version';
$activeNav = 'versions';
include __DIR__ . '/../includes/layout-header.php';
?>

<div class="breadcrumb">
  <a href="/cms/versions/version-list.php">Versions</a>
  <span class="breadcrumb-sep">›</span>
  <span>Create</span>
</div>

<?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="card version-form-card">
  <form method="POST">
    <?= csrf_field() ?>
    <div class="form-group">
      <label>Version Type</label>
      <label class="radio-row"><input type="radio" name="version_type" value="major"> Major</label>
      <label class="radio-row"><input type="radio" name="version_type" value="minor" checked> Minor</label>
    </div>
    <div class="form-group">
      <label>Base Version</label>
      <select name="base_version_id" class="form-select" required>
        <?php foreach ($versions as $version): ?>
        <option value="<?= (int)$version['id'] ?>">
          <?= htmlspecialchars(format_version_number($version['version_number'])) ?> - <?= htmlspecialchars($version['description']) ?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Version Name</label>
      <input type="text" class="form-input" value="Auto generated after creation" disabled>
    </div>
    <div class="form-group">
      <label>Change Description</label>
      <textarea name="description" rows="5" required placeholder="Updated Hero Banner"></textarea>
    </div>
    <button type="submit" class="btn-primary">Create Version</button>
  </form>
</div>

<?php include __DIR__ . '/../includes/layout-footer.php'; ?>
