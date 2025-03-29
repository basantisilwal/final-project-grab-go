<?php 
include('../conn/conn.php'); 

/******************************
 * 1. Fetch Total Users
 ******************************/
$sqlUsers = "SELECT COUNT(*) AS total_users FROM tbl_otp";
$stmtUsers = $conn->prepare($sqlUsers);
$stmtUsers->execute();
$rowUsers = $stmtUsers->fetch(PDO::FETCH_ASSOC);
$totalUsers = $rowUsers['total_users'] ?? 0;  // Default to 0 if no users

/******************************
 * 2. Fetch Monthly Orders Data
 ******************************/
$sqlOrders = "SELECT DATE_FORMAT(created_at, '%b') AS month, COUNT(*) AS total_orders
              FROM tbl_orders
              WHERE YEAR(created_at) = YEAR(CURDATE())
              GROUP BY MONTH(created_at), month
              ORDER BY MONTH(created_at)";
$stmtOrders = $conn->query($sqlOrders);

$months = [];
$orders = [];

while ($row = $stmtOrders->fetch(PDO::FETCH_ASSOC)) {
    $months[] = $row['month'];
    $orders[] = $row['total_orders'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* General Styles */
    body {
      font-size: 0.9rem;
      background-color: #FFE0B2;
      display: flex;
      margin: 0;
      padding: 0;
    }
    /* Sidebar Styles */
    .sidebar {
      width: 220px;
      background: linear-gradient(135deg, #f7b733, #fc4a1a);
      color: #fff;
      height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 15px;
      position: fixed;
      top: 0;
      left: 0;
      box-shadow: 3px 0 8px rgba(0, 0, 0, 0.2);
    }
    .sidebar a {
      color: black;
      text-decoration: none;
      padding: 10px;
      display: flex;
      align-items: center;
      transition: 0.3s;
      font-size: 1rem;
    }
    .sidebar h2 {
      font-size: 1.1rem;
      margin-bottom: 15px;
      color: #000;
      font-weight: bold;
      text-align: center;
      padding-bottom: 10px;
      border-bottom: 2px solid #d4b870;
    }
    .sidebar a:hover {
      background-color: black;
      color: #fff;
    }
    
    /* Logo */
    .logo-container {
      text-align: center;
      margin-bottom: 20px;
    }
    .logo-container img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      border: 2px solid black;
    }

    /* Main Content */
    .main-content {
      margin-left: 270px;
      padding: 20px;
      width: 100%;
    }
    .card {
      margin-bottom: 15px;
    }
    .card-body {
      padding: 1rem;
    }
    .card-title {
      font-size: 1rem;
      margin-bottom: 0.5rem;
    }
    .card-text.display-4 {
      font-size: 2rem;
      font-weight: bold;
    }
    .card-text {
      font-size: 0.8rem;
    }
    #monthlyOrdersChart {
      height: 300px !important;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="main-container d-flex">
        <aside class="sidebar">
            <h2>Admin Dashboard</h2>
            <a href="admindashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="manage.php"><i class="bi bi-shop"></i> Manage Owner</a>
            <a href="customer.php"><i class="bi bi-people"></i> View Users</a>
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </aside>

  <!-- Main content -->
  <main class="main-content">
    <h1 class="h4 mb-3">Dashboard</h1>

    <!-- Card for Total Users -->
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Total Users</h5>
            <!-- Display the total user count from tbl_otp -->
            <p class="card-text display-4"><?php echo $totalUsers; ?></p>
            <p class="card-text text-success">
              <i class="bi bi-arrow-up"></i> 7.1% increase
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Bar graph for Monthly Orders -->
    <div class="card mt-3">
      <div class="card-body">
        <h5 class="card-title">Monthly Orders</h5>
        <canvas id="monthlyOrdersChart"></canvas>
      </div>
    </div>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Use the PHP arrays to populate the chart
    const ctx = document.getElementById('monthlyOrdersChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
          label: 'Number of Orders',
          data: <?php echo json_encode($orders); ?>,
          backgroundColor: 'rgba(75, 192, 192, 0.6)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</body>
</html>
