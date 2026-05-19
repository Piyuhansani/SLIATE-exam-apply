<?php
//Add connection
include "../DBConnection/connect.php";


  // login directorID and password hash from dtabase 
if (isset($_POST['submit'])) {
    $Director_ID = $_POST['Director_ID'];
    $password = $_POST['password'];


    $sql = "SELECT password_hash FROM director WHERE Director_ID = '$Director_ID'";  
    $result = $conn->query($sql);

    // Check if a user exists with the provided registration number
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the entered password with the hashed password
        if (password_verify($password, $row['password_hash'])) {
            // Password matches, login successful
            header("Location: admin.php");
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