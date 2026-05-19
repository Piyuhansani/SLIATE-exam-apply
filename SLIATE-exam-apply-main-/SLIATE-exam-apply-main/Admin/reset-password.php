<?php

// Get the token from the URL
$token = $_GET["token"];

// Hash the token using SHA-256
$token_hash = hash("sha256", $token);

// Connect to the database
$conn = require __DIR__ . "/../DBConnection/connect.php";

// Prepare SQL statement to select the user with the given reset token hash
$sql = "SELECT * FROM director
        WHERE reset_token_hash = ?";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Bind the token hash parameter to the SQL statement
$stmt->bind_param("s", $token_hash);

// Execute the SQL statement
$stmt->execute();

// Get the result of the SQL query
$result = $stmt->get_result();

// Fetch the user data from the result
$user = $result->fetch_assoc();

// Check if the user was not found
if ($user === null) {
    die("token not found");
}

// Check if the reset token has expired
if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Reset link is expired");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <!-- Bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {background-color:#ffe100;}
       form,.card {background-color: #f0ff7f;}
    </style>
</head>
<body class="bg-warning.bg-gradient d-flex justify-content-center align-items-center" style="height: 100vh;"> <!-- Yellow background -->

    <div class="container text-center">
        <div class="card p-4 shadow-lg mx-auto" style="max-width: 400px;">
            <!-- Icon container with a lock icon image -->
            <div class="mb-4">
                <img src="../Images/open-padlock.png" alt="Lock Icon" class="img-fluid" style="width: 40px; height: 40px;">
            </div>
            
            <h2 class="fw-bold mb-4">Reset Your Password</h2>
            
            <!-- Form to handle password reset -->
            <form action="process-reset-password.php" onsubmit="return validatethisForm()" method="POST">
                <!-- Hidden input to store the token value -->
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter New Password" required>
                </div>

                <div class="mb-3">
                    <label for="confirmpassword" class="form-label">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmpassword" class="form-control" placeholder="Confirm Your Password" onkeyup="validatePasswords()" required>
                    <span id="passwordError" class="text-danger small"></span>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" onclick="window.location.href='admin_login.php'" class="btn btn-secondary">Back</button>
                    <button type="submit" class="btn btn-primary">Done</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript file -->
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>