<?php
// api/search.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../includes/db.php';
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($q === '') {
    $stmt = $pdo->query("SELECT id, title, short_desc, price FROM courses ORDER BY id DESC");
} else {
    $stmt = $pdo->prepare("SELECT id, title, short_desc, price FROM courses WHERE title LIKE ? OR short_desc LIKE ? LIMIT 30");
    $like = "%$q%";
    $stmt->execute([$like, $like]);
}
$rows = $stmt->fetchAll();
echo json_encode($rows);
