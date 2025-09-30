<?php
require 'includes/db.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO users (name,email,password,is_admin) VALUES (?,?,?,0)");
    $stmt->execute([$_POST['name'], $_POST['email'], md5($_POST['password'])]);
    $message = "Registered successfully! <a href='login.php'>Login</a>";
}
include 'includes/header.php';
?>
<div class="container mt-5">
<h2>Register</h2>
<?php if($message) echo "<div class='alert alert-info'>$message</div>"; ?>
<form method="post">
  <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Full Name" required></div>
  <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
  <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
  <button type="submit" class="btn btn-primary">Register</button>
</form>
</div>
<?php include 'includes/footer.php'; ?>