<?php
session_start();
include('../conn/conn.php');

// ✅ Get `food_id` from URL
$food_id = isset($_GET['food_id']) ? $_GET['food_id'] : null;

// ✅ Check if `food_id` is valid
if ($food_id) {
    // ✅ Fetch Comments from Database
    $stmt = $pdo->prepare("SELECT * FROM tbl_comments WHERE food_id = ? ORDER BY created_at DESC");
    $stmt->execute([$food_id]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $comments = [];
}
// Fetch Logo
$current_logo = "logo.png"; // fallback if none in DB
$logoQuery    = "SELECT name, path FROM tbl_owlogo LIMIT 1";
$logoStmt     = $conn->prepare($logoQuery);
$logoStmt->execute();

if ($row = $logoStmt->fetch(PDO::FETCH_ASSOC)) {
    // If a logo exists in DB, use that
    $current_logo = $row['path'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFE0B2;
            color: #333;
        }

        header {
            background-color: #555;
            color: white;
            text-align: center;
            padding: 20px;
        }
/* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #f7b733, #fc4a1a); /* Gradient Background */
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2); /* Soft shadow for depth */
        }

        .sidebar h2 {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: 1px;
        }

        .sidebar a {
            color: #000;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            transition: all 0.3s ease-in-out;
            font-weight: 500;
        }

        .sidebar a:hover {
            background: #000; /* Semi-transparent hover effect */
            color: #fff;
            transform: translateX(5px); /* Subtle movement effect */
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo-container img {
            width: 80px;
            border-radius: 50%;
            border: 2px solid black;
        }
        /* ✅ Main Content Container */
        .main-container {
            margin-left: 270px; /* Adjust margin to avoid sidebar overlap */
            padding: 20px;
            width: calc(100% - 270px); /* Sidebar width subtracted */
            min-height: 100vh;
            background: #fff; 
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .main-container h2 {
            color: #444;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* ✅ Comments Section */
        .comments-section {
            background: #fafafa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .comment-box {
            background: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
        }

        .comment-box p {
            margin: 0;
            font-size: 16px;
        }

        .comment-box small {
            color: #777;
        }
        </style>

<body>
<div class="main-layout">
    <aside class="sidebar">
    <div class="logo-container">
        <img src="<?php echo htmlspecialchars($current_logo); ?>" alt="Logo">
    </div>
    <h2>Dashboard</h2>
    <a href="das.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="addfood.php"><i class="fas fa-utensils"></i> Add Food</a>
    <a href="viewfood.php"><i class="fas fa-list"></i> View Food</a>
    <a href="vieworder.php"><i class="fas fa-shopping-cart"></i> View Order</a>
    <a href="setting.php"><i class="bi bi-gear"></i> Settings</a>
    <a href="viewfeedback.php"><i class="bi bi-chat-dots"></i> Feedback</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</aside>

<!-- ✅ Main Content -->
<div class="main-container">
    <h2>Comments for Food ID: <?php echo htmlspecialchars($food_id); ?></h2>

    <!-- ✅ Display Comments -->
    <div class="comments-section">
        <?php
        if (count($comments) > 0) {
            foreach ($comments as $comment) {
                echo "<div class='comment-box'>";
                echo "<p><strong>" . htmlspecialchars($comment['user_name']) . ":</strong> " . htmlspecialchars($comment['comment']) . "</p>";
                echo "<small>Posted on: " . htmlspecialchars($comment['created_at']) . "</small>";
                echo "</div>";
            }
        } else {
            echo "<p>No comments available for this food item.</p>";
        }
        ?>
    </div>
</div>


</body>
</html>
