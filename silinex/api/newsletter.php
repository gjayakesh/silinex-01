<?php
// api/newsletter.php
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../includes/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Method not allowed']);
    exit;
}

$email = strtolower(trim($_POST['email'] ?? ''));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['ok' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

// Honeypot
if (!empty($_POST['url'])) {
    echo json_encode(['ok' => true, 'message' => 'Thank you for subscribing!']);
    exit;
}

try {
    $check = db()->prepare('SELECT id FROM newsletter_subscribers WHERE email = :email LIMIT 1');
    $check->execute([':email' => $email]);

    if ($check->fetch()) {
        echo json_encode(['ok' => true, 'message' => 'You are already subscribed - thank you!']);
        exit;
    }

    $stmt = db()->prepare("
        INSERT INTO newsletter_subscribers (email, ip_address, user_agent)
        VALUES (:email, :ip_address, :user_agent)
    ");
    $stmt->execute([
        ':email'      => $email,
        ':ip_address' => request_ip() ?: null,
        ':user_agent' => request_user_agent() ?: null,
    ]);
} catch (Throwable $e) {
    error_log('Newsletter database error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'We could not save your subscription right now. Please try again shortly.']);
    exit;
}

// Notify admin
$subject = 'New Newsletter Subscriber - ' . SITE_NAME;
$body    = "New subscriber: {$email}\nDate: " . date('Y-m-d H:i:s') . "\n";
@mail(SITE_EMAIL, $subject, $body, 'From: noreply@silinexglobal.com');

echo json_encode(['ok' => true, 'message' => 'Thank you for subscribing! You will hear from us soon.']);
