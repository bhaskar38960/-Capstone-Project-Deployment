<?php
require '../includes/db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email']; $pass = $_POST['password'];
  $stmt = $pdo->prepare("SELECT id,name,email,password,is_admin FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();
  if ($user && password_verify($pass, $user['password']) && $user['is_admin']) {
    $_SESSION['user'] = ['id'=>$user['id'],'name'=>$user['name'],'email'=>$user['email'],'is_admin'=>$user['is_admin=1']];
    header('Location: manage_courses.php'); exit;
  } else $err = 'Invalid admin credentials';
}
?>
<!doctype html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-5">
<div class="container"><div class="row justify-content-center"><div class="col-md-5">
  <h3>Admin Login</h3>
  <?php if(!empty($err)): ?><div class="alert alert-danger"><?=$err?></div><?php endif; ?>
  <form method="post">
    <input name="email" class="form-control mb-2" placeholder="Email">
    <input name="password" type="password" class="form-control mb-2" placeholder="Password">
    <button class="btn btn-primary">Login</button>
  </form>
</div></div></div>
</body></html>
