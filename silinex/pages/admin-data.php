<?php
session_start();
$page_title = 'Stored Website Data | Silinex Global Services';
$page_desc  = 'Private admin page for viewing contact messages and newsletter subscribers.';
$page_robots = 'noindex, nofollow';

require_once __DIR__ . '/../includes/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'login';

    if ($action === 'logout') {
        unset($_SESSION['admin_data_logged_in']);
        header('Location: /admin-data');
        exit;
    }

    if (hash_equals(ADMIN_DATA_PASSWORD, (string) ($_POST['password'] ?? ''))) {
        $_SESSION['admin_data_logged_in'] = true;
        header('Location: /admin-data');
        exit;
    }

    $error = 'Invalid password. Please try again.';
}

$is_logged_in = !empty($_SESSION['admin_data_logged_in']);
$contacts = [];
$subscribers = [];

if ($is_logged_in) {
    $pdo = db();
    $contacts = $pdo->query("
        SELECT id, name, email, phone, subject, message, ip_address, created_at
        FROM contact_messages
        ORDER BY id DESC
    ")->fetchAll();

    $subscribers = $pdo->query("
        SELECT id, email, ip_address, created_at
        FROM newsletter_subscribers
        ORDER BY id DESC
    ")->fetchAll();
}

require_once __DIR__ . '/../includes/header.php';
?>

<section class="inner-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Stored Data</span></nav>
    <h1>Stored <span>Data</span></h1>
    <p>View contact form messages and newsletter subscriptions saved by the website.</p>
  </div>
</section>

<section class="admin-data-section">
  <div class="container">
    <?php if (!$is_logged_in): ?>
      <div class="admin-login-panel">
        <h2>Admin Login</h2>
        <p>Enter the data viewer password to continue.</p>
        <?php if ($error): ?>
          <div class="admin-alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" class="admin-login-form">
          <input type="hidden" name="action" value="login">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required autocomplete="current-password">
          <button type="submit" class="btn btn-primary">Open Data Viewer</button>
        </form>
      </div>
    <?php else: ?>
      <div class="admin-data-head">
        <div>
          <span class="section-tag">Database Viewer</span>
          <h2 class="section-title">Website <span>Submissions</span></h2>
        </div>
        <form method="post">
          <input type="hidden" name="action" value="logout">
          <button type="submit" class="btn btn-secondary">Logout</button>
        </form>
      </div>

      <div class="admin-stats">
        <div>
          <strong><?= count($contacts) ?></strong>
          <span>Contact Messages</span>
        </div>
        <div>
          <strong><?= count($subscribers) ?></strong>
          <span>Newsletter Subscribers</span>
        </div>
      </div>

      <div class="admin-table-block">
        <h3>Contact Messages</h3>
        <?php if (!$contacts): ?>
          <p class="admin-empty">No contact messages have been stored yet.</p>
        <?php else: ?>
          <div class="admin-table-wrap">
            <table class="admin-data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>IP</th>
                  <th>Created</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($contacts as $row): ?>
                  <tr>
                    <td><?= (int) $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><a href="mailto:<?= htmlspecialchars($row['email']) ?>"><?= htmlspecialchars($row['email']) ?></a></td>
                    <td><?= htmlspecialchars($row['phone'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['subject'] ?? '') ?></td>
                    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                    <td><?= htmlspecialchars($row['ip_address'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>

      <div class="admin-table-block">
        <h3>Newsletter Subscribers</h3>
        <?php if (!$subscribers): ?>
          <p class="admin-empty">No newsletter subscribers have been stored yet.</p>
        <?php else: ?>
          <div class="admin-table-wrap">
            <table class="admin-data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Email</th>
                  <th>IP</th>
                  <th>Created</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($subscribers as $row): ?>
                  <tr>
                    <td><?= (int) $row['id'] ?></td>
                    <td><a href="mailto:<?= htmlspecialchars($row['email']) ?>"><?= htmlspecialchars($row['email']) ?></a></td>
                    <td><?= htmlspecialchars($row['ip_address'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
