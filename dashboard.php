<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}
include 'includes/header.php';
?>
<div class="container mt-5">
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>!</h2>
  <p>You are now logged in.</p>
  <a href="courses.php" class="btn btn-primary">View Courses</a>
  <a href="logout.php" class="btn btn-danger">Logout</a>
</div>
<?php include 'includes/footer.php'; ?>