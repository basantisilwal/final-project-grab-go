<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diamond Restro</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    background-color: #f8f8f8;
}

.gallery {
    display: flex;
    gap: 20px;
    margin: 20px;
}

.card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    width: 200px;
    text-align: center;
}

.product-image {
    width: 100%;
    height: auto;
    border-bottom: 1px solid #ddd;
}

h3 {
    margin: 15px 0;
    font-size: 1.1em;
    color: #333;
}

.buttons {
    display: flex;
    gap: 10px;
    padding: 10px;
    justify-content: center;
}

button {
    padding: 8px 16px;
    font-size: 0.9em;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    opacity: 0.8;
}

button:nth-child(1) {
    background-color: #ff6699;
    color: #fff;
}

button:nth-child(2) {
    background-color: #ff6699;
    color: #fff;
}

button:nth-child(3) {
    background-color; #ff6699;
    color: #fff;
}
</style>
<body>
    <div class="gallery">
        <!-- Card 1 -->
        <div class="card">
            <img src="../images/jhol momo.jpg" alt="Jhol-momo" class="product-image">
            <h3>Jhol MOMO</h3>
            <div class="buttons">
                <button onclick="editPost()">Edit</button>
                <button onclick="deletePost()">Delete</button>
                <button onclick="viewPost()">View Post</button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card">
            <img src="../images/fry fish.jpg" alt="Fry fish" class="product-image">
            <h3>Fry Fish</h3>
            <div class="buttons">
                <button onclick="editPost()">Edit</button>
                <button onclick="deletePost()">Delete</button>
                <button onclick="viewPost()">View Post</button>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="card">
            <img src="chicken chaumin.jpg" alt="chiken chaumin" class="product-image">
            <h3>$100/-</h3>
            <div class="buttons">
                <button onclick="editPost()">Edit</button>
                <button onclick="deletePost()">Delete</button>
                <button onclick="viewPost()">View Post</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
<style>
function editPost() {
    alert("Edit function triggered!");
}

function deletePost() {
    alert("Delete function triggered!");
}

function viewPost() {
    alert("View Post function triggered!");
}
</style>
</html>
