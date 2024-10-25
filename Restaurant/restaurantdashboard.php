<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Dashboard</title>
    <link rel="stylesheet" href="rstyle.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li>My Project</li>
                <li>Data</li>
                <li>Statistics</li>
                <li>Team</li>
                <li>Saved</li>
                <li>Draft</li>
                <li>Trash</li>
            </ul>
        </nav>

        <div class="main-content">
            <h1>Restaurant Dashboard</h1>
            <img src="../images/Background.jpg" alt="pizza" class="ractengle-img">
            <div class="buttons">
                <button onclick="showAlert('Pending food orders')">Pending food orders</button>
                <button onclick="showAlert('Manage food menu')">Manage food menu</button>
                <button onclick="showAlert('Manage payment')">Manage payment</button>
                <button onclick="showAlert('Give Token ID')">Give Token ID</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>