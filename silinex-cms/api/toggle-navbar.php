<?php
require_once __DIR__ . '/../includes/auth.php'; require_auth();
require_once __DIR__ . '/../includes/db.php';
header('Content-Type: application/json');

$data  = json_decode(file_get_contents('php://input'), true);
$id    = (int)($data['id']    ?? 0);
$value = (int)($data['value'] ?? 0);

if ($id > 0) {
    $pdo->prepare("UPDATE pages SET in_navbar = ? WHERE id = ?")
        ->execute([$value, $id]);
}
echo json_encode(['ok' => true]);
