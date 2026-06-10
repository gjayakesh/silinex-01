<?php
require_once __DIR__ . '/../includes/auth.php'; require_auth();
require_once __DIR__ . '/../includes/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$ids  = array_filter(array_map('intval', $data['ids'] ?? []), fn($id) => $id > 0);

foreach (array_values($ids) as $order => $id) {
    $pdo->prepare("UPDATE sections SET section_order = ? WHERE id = ?")
        ->execute([$order, $id]);
}
echo json_encode(['ok' => true]);
