<?php
require '../includes/db.php';
require '../includes/auth.php';
require_login();
if (!$_SESSION['user']['is_admin']) { header('Location: ../index.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
  if ($_POST['action'] === 'add') {
    $t = trim($_POST['title']);
    $s = trim($_POST['short_desc']);
    $l = trim($_POST['long_desc']);
    $p = floatval($_POST['price']);
    if ($t==='') $errors[]='Title required';
    if (!$errors) {
      $stmt = $pdo->prepare("INSERT INTO courses (title, short_desc, long_desc, price) VALUES (?,?,?,?)");
      $stmt->execute([$t,$s,$l,$p]);
      header('Location: manage_courses.php'); exit;
    }
  } elseif ($_POST['action'] === 'delete') {
    $id = intval($_POST['id']);
    $pdo->prepare("DELETE FROM courses WHERE id = ?")->execute([$id]);
    header('Location: manage_courses.php'); exit;
  }
}
$all = $pdo->query("SELECT * FROM courses ORDER BY id DESC")->fetchAll();
?>
<?php require '../includes/header.php'; ?>
<div class="row">
  <div class="col-md-6">
    <h4>Manage Courses</h4>
    <?php if($errors) foreach($errors as $e): ?><div class="alert alert-danger"><?=htmlspecialchars($e)?></div><?php endforeach; ?>
    <form method="post">
      <input type="hidden" name="action" value="add">
      <div class="mb-2"><input name="title" class="form-control" placeholder="Course title"></div>
      <div class="mb-2"><input name="short_desc" class="form-control" placeholder="Short description"></div>
      <div class="mb-2"><textarea name="long_desc" class="form-control" placeholder="Long description"></textarea></div>
      <div class="mb-2"><input name="price" class="form-control" placeholder="Price (0 for free)"></div>
      <button class="btn btn-success">Add Course</button>
    </form>
  </div>
  <div class="col-md-6">
    <h4>Existing</h4>
    <div class="list-group">
      <?php foreach($all as $c): ?>
        <div class="list-group-item">
          <div class="d-flex justify-content-between">
            <div>
              <strong><?=htmlspecialchars($c['title'])?></strong><br>
              <small class="text-muted"><?=htmlspecialchars($c['short_desc'])?></small>
            </div>
            <form method="post" onsubmit="return confirm('Delete?')">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?=$c['id']?>">
              <button class="btn btn-outline-danger btn-sm">Delete</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="mt-3">
      <a class="btn btn-primary" href="analytics.php">Analytics</a>
    </div>
  </div>
</div>
<?php require '../includes/footer.php'; ?>
