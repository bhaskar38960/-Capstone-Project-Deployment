<?php
// api/stats.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../includes/db.php';
$stmt = $pdo->query("SELECT c.title, COUNT(e.id) AS count FROM courses c LEFT JOIN enrollments e ON c.id=e.course_id GROUP BY c.id ORDER BY count DESC");
echo json_encode($stmt->fetchAll());
