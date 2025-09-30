<?php
session_start();
require 'includes/db.php';
if (!isset($_SESSION['user'])) { header('Location: login.php'); exit; }
$course_id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)");
$stmt->execute([$_SESSION['user']['id'], $course_id]);
header('Location: courses.php');
exit;
?>