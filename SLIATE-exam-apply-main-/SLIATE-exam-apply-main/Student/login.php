<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../style2.css">
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="regNumber">Registration Number</label>
                <input type="text" id="regNumber" name="regNumber" placeholder="Enter Registration Number" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
            </div>

            <div class="button-container">
                <button type="submit" name="submit">Login</button>
            </div>

            <p class="register-message">Don't have an account? <a href="StudentSignup.php">Register here</a></p>
            
            <p class="register-message">Froget Password? <a href="froget_pwd.php">Change Password</a></p>
        </form>
    </div>


<script src="script.js"></script>

</body>
</html>
