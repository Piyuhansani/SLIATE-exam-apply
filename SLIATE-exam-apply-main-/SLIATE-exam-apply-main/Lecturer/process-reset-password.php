<?php

// Set default token
$token = $_POST["token"];

// Hash the token using SHA-256
$token_hash = hash("sha256", $token);

// Connect to the database
$conn = require __DIR__ . "/../DBConnection/connect.php";

// Prepare SQL statement to select the user with the given reset token hash
$sql = "SELECT * FROM lecturer
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

// Check if the token has expired
if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

// Hash the new password using the default algorithm
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Prepare SQL statement to update the user's password and reset token fields
$sql = "UPDATE lecturer
        SET password_hash = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE email = ?";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Bind the password hash and user email parameters to the SQL statement
$stmt->bind_param("ss", $password_hash, $user["email"]);

// Execute the SQL statement
$stmt->execute();

// Output a JavaScript alert to inform the user that the password has been updated
echo '<script>
                alert("Password updated. You can now login.");
                window.location.href = "Lecturer_login.php";
 </script>';
