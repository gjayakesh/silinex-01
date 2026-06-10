<?php
// api/contact.php
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../includes/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok'=>false,'message'=>'Method not allowed']);
    exit;
}

$name    = trim($_POST['name']    ?? '');
$email   = trim($_POST['email']   ?? '');
$phone   = trim($_POST['phone']   ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validation
$errors = [];
if (strlen($name) < 2)              $errors[] = 'Please enter your full name.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
if (strlen($message) < 10)         $errors[] = 'Message must be at least 10 characters.';

// Basic honeypot (bot protection)
if (!empty($_POST['website'])) {
    echo json_encode(['ok'=>true,'message'=>'Thank you! We will be in touch shortly.']);
    exit;
}

if ($errors) {
    echo json_encode(['ok'=>false,'message'=>implode(' ', $errors)]);
    exit;
}

try {
    $stmt = db()->prepare("
        INSERT INTO contact_messages
            (name, email, phone, subject, message, ip_address, user_agent)
        VALUES
            (:name, :email, :phone, :subject, :message, :ip_address, :user_agent)
    ");
    $stmt->execute([
        ':name'       => $name,
        ':email'      => strtolower($email),
        ':phone'      => $phone ?: null,
        ':subject'    => $subject ?: null,
        ':message'    => $message,
        ':ip_address' => request_ip() ?: null,
        ':user_agent' => request_user_agent() ?: null,
    ]);
} catch (Throwable $e) {
    error_log('Contact form database error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['ok'=>false,'message'=>'We could not save your message right now. Please try again in a few minutes.']);
    exit;
}

// Compose email
$to      = SITE_EMAIL;
$subLine = 'Website Enquiry: ' . ($subject ?: 'General') . ' – ' . $name;
$body    = "New contact form submission from Silinex Global website\n";
$body   .= str_repeat('-', 50) . "\n";
$body   .= "Name:    $name\n";
$body   .= "Email:   $email\n";
$body   .= "Phone:   $phone\n";
$body   .= "Subject: $subject\n\n";
$body   .= "Message:\n$message\n";
$body   .= str_repeat('-', 50) . "\n";
$body   .= "Sent at: " . date('Y-m-d H:i:s') . "\n";

$headers  = "From: noreply@silinexglobal.com\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . PHP_VERSION . "\r\n";

@mail($to, $subLine, $body, $headers);

echo json_encode([
    'ok'      => true,
    'message' => 'Thank you, ' . htmlspecialchars($name) . '! We\'ve received your message and will respond within 24 hours.',
]);
