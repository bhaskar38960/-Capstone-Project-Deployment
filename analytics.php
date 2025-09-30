<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
// admin check skipped for simplicity
$sql = "SELECT c.title, COUNT(e.id) AS count
        FROM courses c
        LEFT JOIN enrollments e ON c.id = e.course_id
        GROUP BY c.id";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll();
$labels = array_column($rows, 'title');
$values = array_column($rows, 'count');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Analytics</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="p-5">
  <h2>Enrollment Analytics</h2>
  <canvas id="chart" height="100"></canvas>
  <script>
  const ctx = document.getElementById('chart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($labels); ?>,
      datasets: [{
        label: 'Enrollments',
        data: <?php echo json_encode($values); ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.6)'
      }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
  });
  </script>
</body>
</html>