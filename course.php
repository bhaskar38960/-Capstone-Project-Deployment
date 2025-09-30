<?php
require 'includes/db.php';
require 'includes/header.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->execute([$id]);
$course = $stmt->fetch();
if(!$course){
  echo '<div class="alert alert-danger">Course not found.</div>';
  require 'includes/footer.php';
  exit;
}
?>
<div class="row">
  <div class="col-lg-8">
    <div class="card p-3">
      <h3><?=htmlspecialchars($course['title'])?></h3>
      <p class="text-muted"><?=htmlspecialchars($course['short_desc'])?></p>
      <p><?=nl2br(htmlspecialchars($course['long_desc']))?></p>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card p-3">
      <h5>Enroll</h5>
      <p class="mb-1">Price: <?= $course['price']==0 ? 'Free' : '$'.number_format($course['price'],2) ?></p>
      <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
      <?php if (empty($_SESSION['user'])): ?>
        <p class="text-muted">Please <a href="login.php?next=course.php?id=<?=$course['id']?>">login</a> to enroll.</p>
      <?php else: ?>
        <button id="enrollBtn" data-course="<?=$course['id']?>" class="btn btn-primary w-100">Enroll Now</button>
        <div id="enrollMsg" class="mt-2"></div>
        <script>
          document.getElementById('enrollBtn').addEventListener('click', function(){
            this.disabled = true;
            fetch('/capstone-elearning/api/enroll.php', {
              method: 'POST',
              headers: {'Content-Type':'application/json'},
              body: JSON.stringify({course_id: this.dataset.course})
            }).then(r => r.json()).then(j=>{
              document.getElementById('enrollMsg').innerHTML = j.message;
              if(j.success) document.getElementById('enrollBtn').textContent = 'Enrolled';
            }).catch(e=>{
              document.getElementById('enrollMsg').innerHTML = 'Error';
              this.disabled = false;
            });
          });
        </script>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php require 'includes/footer.php'; ?>
