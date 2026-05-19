<?php
// Start session to store user data
session_start();

// Add connection
include "../DBConnection/connect.php";

// Add details
if (isset($_POST['SUBMIT'])) {
    $title = $_POST['title'];
    $fullName = $_POST['fullName'];
    $nameWithInitials = $_POST['nameWithInitials'];
    $regNumber = $_POST['regNumber'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $department = $_POST['department'];
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Checking existing customer IDs
    $sql1 = "SELECT * FROM lecturer WHERE Registration_number='$regNumber'";
    $result1 = $conn->query($sql1);
    if ($result1->num_rows > 0) {
        echo "<script>alert('You are already signed up!'); window.location.href = 'Lecturer_login.php';</script>";
    } else {
        // Inserting customers
        $sql2 = "INSERT INTO lecturer (Registration_number, title, Full_Name, name_with_initials, gender, email, contact_number, address, department, confirm_Password, password_hash)
                 VALUES ('$regNumber', '$title', '$fullName', '$nameWithInitials', '$gender', '$email', '$mobile', '$address', '$department', '$confirmPassword', '$password_hash')";

        $result2 = $conn->query($sql2);

        if ($result2) {
            echo "<script>alert('You successfully signed up!'); window.location.href = 'Lecturer_login.php';</script>";
        }
    }
}

// Login lecturerID and password hash from database
if (isset($_POST['submit'])) {
    $regNumber = $_POST['regNumber'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM lecturer WHERE Registration_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $regNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user exists with the provided registration number
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the entered password with the hashed password
        if (password_verify($password, $row['password_hash'])) {
            // Fetch lecturer's details using their email
            $query = "SELECT Registration_number FROM lecturer WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $row['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            $lecturer = $result->fetch_assoc();

            if ($lecturer) {
                // Store the Registration_number in the session
                $_SESSION['userName'] = $row['name_with_initials'];
                $_SESSION['lecturer_id'] = $row['Registration_number'];
                $_SESSION['department'] = $row['department'];

                // Password matches, login successful
                header("Location: LecturerPage.php");
                exit();
            } else {
                echo '<script>
                        alert("Login failed. Invalid email!");
                        window.location.href = "Lecturer_login.php";
                      </script>';
            }
        } else {
            echo '<script>
                    alert("Login failed. Invalid password!");
                    window.location.href = "Lecturer_login.php";
                  </script>';
        }
    } else {
        echo '<script>
                alert("Login failed. Invalid registration number!");
                window.location.href = "Lecturer_login.php";
              </script>';
    }
}

// Closing the database connection
$conn->close();
?>
