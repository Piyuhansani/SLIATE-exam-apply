<?php
// Add connection
include "../DBConnection/connect.php";

// Check for form submission
if (isset($_POST['submit'])) {
    $Director_ID = $_POST['Director_ID'];
    $password = $_POST['password'];

    // Query to fetch password hash for the provided Director ID
    $sql = "SELECT password_hash, name FROM director WHERE Director_ID = '$Director_ID'";  
    $result = $conn->query($sql);

    // Check if a user exists with the provided Director ID
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the entered password with the hashed password
        if (password_verify($password, $row['password_hash'])) {
            // Store the director's name in the session
            session_start();
            $_SESSION['userName'] = $row['name'];

            // Redirect to admin page on successful login
            header("Location: admin.php");
            exit();
        } else {
            // Password doesn't match
            echo '<script>
                    alert("Login failed. Invalid password!");
                    window.location.href = "admin_login.php";
                  </script>';
        }
    } else {
        // User not found
        echo '<script>
                alert("Login failed. Invalid ID number!");
                window.location.href = "admin_login.php";
              </script>';
    }
}

// Closing the database connection
$conn->close();
?>
