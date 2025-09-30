<?php
$pageTitle = 'Courses';
require 'includes/header.php';
require 'includes/db.php';
$stmt = $pdo->query("SELECT id, title, short_desc, price FROM courses ORDER BY id DESC");
$courses = $stmt->fetchAll();
?>
<div class="row">
  <div class="col-12">
    <h2>All Courses</h2>
    <div class="row mt-3" id="coursesList">
      <?php foreach($courses as $c): ?>
        <div class="col-sm-6 col-lg-4 mb-3">
          <div class="card card-course h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="course-title"><?=htmlspecialchars($c['title'])?></h5>
              <p class="text-muted small"><?=htmlspecialchars($c['short_desc'])?></p>
              <div class="mt-auto d-flex justify-content-between align-items-center">
                <a href="course.php?id=<?=$c['id']?>" class="btn btn-outline-primary btn-sm">View</a>
                <span class="fw-bold"><?= $c['price']==0 ? 'Free' : '$'.number_format($c['price'],2) ?></span>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php require 'includes/footer.php'; ?>