<?php
session_start();
require 'includes/db.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=? AND password=?");
    $stmt->execute([$_POST['email'], md5($_POST['password'])]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit;
    } else {
        $message = "Invalid login!";
    }
}
include 'includes/header.php';
?>
<div class="container mt-5">
<h2>Login</h2>
<?php if($message) echo "<div class='alert alert-danger'>$message</div>"; ?>
<form method="post">
  <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
  <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
  <button type="submit" class="btn btn-success">Login</button>
</form>
</div>
<?php include 'includes/footer.php'; ?>