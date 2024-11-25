<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="astyle.css">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-size: 0.9rem;
        }
        /* Sidebar Styles */
    .sidebar {
      width: 250px;
      background-color: #000; /* Black background */
      color: #fff;
      height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 20px 15px;
    }

    .sidebar h2 {
      font-size: 1.2rem;
      margin-bottom: 20px;
    }

    .sidebar a {
      color: #ff6700; /* Orange text */
      text-decoration: none;
      padding: 10px 15px;
      border-radius: 5px;
      margin-bottom: 10px;
      display: block;
      transition: background 0.3s;
    }

    .sidebar a:hover {
      background-color: #ff6700;
      color: #fff;
    }
        .main-content {
            padding: 15px;
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
    <aside class="sidebar">
    <h2>Admin Dashboard</h2>
    <a href="admindashboard.php">Dashboard</a>
    <a href="manage.php">Manage Restaurants</a>
    <a href="customer.php">View Customers</a>
    <a href="setting.php">Settings</a>
    <a href="logout.php">Logout</a>
    </aside>


<!-- Main content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <h1 class="h4 mb-3">Dashboard</h1>

    <!-- Cards for total restaurants and customers -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Restaurants</h5>
                    <p class="card-text display-4">150</p>
                    <p class="card-text text-success">
                        <i class="bi bi-arrow-up"></i> 5.3% increase
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Customers</h5>
                    <p class="card-text display-4">10,500</p>
                    <p class="card-text text-success">
                        <i class="bi bi-arrow-up"></i> 7.1% increase
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bar graph -->
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Monthly Orders</h5>
            <canvas id="monthlyOrdersChart"></canvas>
        </div>
    </div>
</main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js configuration
    const ctx = document.getElementById('monthlyOrdersChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Number of Orders',
                data: [1200, 1900, 3000, 5000, 2000, 3000, 4500, 5500, 6000, 4000, 3500, 4800],
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
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Orders',
                        font: {
                            size: 10
                        }
                    },
                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month',
                        font: {
                            size: 10
                        }
                    },
                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });
</script>
</body>
</html>
