<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
     <!-- CSS link -->
    <link rel="stylesheet" href="../style2.css"> 
</head>
<body>
    <div class="admin_login_container">
        <h2>Admin Login</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="button-container">
                <button type="submit">Login</button>
            </div>
            <p class="register-message">Froget Password? <a href="#">Change Password</a></p>
        </form>
    </div>
</body>
</html>
