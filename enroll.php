<?php
// api/enroll.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../includes/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user'])) {
    echo json_encode(['success'=>false,'message'=>'Login required.']); exit;
}
$input = json_decode(file_get_contents('php://input'), true);
$course_id = isset($input['course_id']) ? intval($input['course_id']) : 0;
$user_id = intval($_SESSION['user']['id']);
if ($course_id<=0) {
    echo json_encode(['success'=>false,'message'=>'Invalid course.']); exit;
}
try {
    $stmt = $pdo->prepare("INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $course_id]);
    echo json_encode(['success'=>true,'message'=>'Enrolled successfully.']);
} catch (PDOException $e) {
    // duplicate entry?
    echo json_encode(['success'=>false,'message'=>'Already enrolled or error.']);
}
