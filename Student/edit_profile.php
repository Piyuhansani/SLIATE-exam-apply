<?php
// Start session
session_start();

// Include database connection
include "../DBConnection/connect.php";

// Ensure the session has the student's registration number
if (!isset($_SESSION['regNumber'])) {
    die("Unauthorized access.");
}

$registration_number = $_SESSION['regNumber'];

// Fetch existing student details
$sql = "SELECT * FROM student WHERE Registration_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $registration_number);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect input data
    $title = $_POST['initialsTitle'] ?? '';
    $full_name = $_POST['full_name'] ?? '';
    $name_with_initials = $_POST['name_with_initials'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $address = $_POST['address'] ?? '';
    $department = $_POST['department'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirmpassword'] ?? '';

    // Validate passwords
    if (!empty($password) && $password !== $confirm_password) {
        echo '<script>alert("Passwords do not match. Please try again.");</script>';
    } else {
        // Hash the password if it's provided
        $password_hash = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : $student['password_hash'];

        // Update student details in the database
        $update_sql = "UPDATE student SET 
            title = ?, 
            Full_Name = ?, 
            name_with_initials = ?, 
            email = ?, 
            contact_number = ?, 
            address = ?, 
            department = ?, 
            password_hash = ? 
            WHERE Registration_number = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param(
            "sssssssss", 
            $title, 
            $full_name, 
            $name_with_initials, 
            $email, 
            $contact_number, 
            $address, 
            $department, 
            $password_hash, 
            $registration_number
        );

        if ($update_stmt->execute()) {
            // Include PHPMailer configuration
            require "mailer.php";

            try {
                // Configure email
                $mail->setFrom("noreply@example.com", "SLIATE Admin Team");
                $mail->addAddress($email, $full_name);
                $mail->Subject = "Profile Updated Successfully";
                $mail->Body = <<<EOL
Dear $full_name,

Your profile has been successfully updated. You can log in to your account using the following link:
http://localhost:8080/SLIATE-exam-apply/Student/login.php

Best regards,
SLIATE Admin Team
EOL;

                // Send the email
                $mail->send();
                echo '<script>alert("Profile updated successfully! Notification sent.");</script>';
            } catch (Exception $e) {
                echo '<script>alert("Profile updated successfully, but email notification failed: ' . $mail->ErrorInfo . '");</script>';
            }
        } else {
            echo '<script>alert("Error updating profile: ' . $conn->error . '");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffe100;
        }

        .card {
            background-color: #f0ff7f;
        }
    </style>
</head>
<body>
    <!-- Back Button -->
    <div class="container my-3">
    <a href="javascript:history.back()" class="btn btn-secondary">&larr; Back</a>
</div>


    <!-- Edit Profile Form -->
    <div class="container my-5">
        <div class="text-center mb-4">
            <h1 class="fw-bold">Edit Your Profile</h1>
        </div>

        <div class="card p-4 shadow-sm">
            <h3 class="card-title mb-3">Personal Details</h3>
            <form action="" method="post" onsubmit="return validateForm()">
                <div class="row g-3">

                    <!-- Title -->
                    <div class="col-md-6">
                        <label for="initialsTitle" class="form-label">Title:</label>
                        <select id="initialsTitle" name="initialsTitle" class="form-select" required>
                            <option value="" disabled selected>Title</option>
                            <option value="Mr">Mr</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Ms">Ms</option>
                            <option value="Rev">Rev</option>
                        </select>
                    </div>

                    <!-- Full Name -->
                    <div class="col-md-6">
                        <label for="full_name" class="form-label">Full Name:</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo htmlspecialchars($student['Full_Name']); ?>" required>
                    </div>

                    <!-- Name with Initials -->
                    <div class="col-md-6">
                        <label for="name_with_initials" class="form-label">Name with Initials:</label>
                        <input type="text" id="name_with_initials" name="name_with_initials" class="form-control" value="<?php echo htmlspecialchars($student['name_with_initials']); ?>" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($student['email']); ?>" onkeyup="showerror()" required>
                        <span id="emailError" class="text-danger small"></span>
                    </div>

                    <!-- Contact Number -->
                    <div class="col-md-6">
                        <label for="contact_number" class="form-label">Contact Number:</label>
                        <input type="text" id="contact_number" name="contact_number" class="form-control" value="<?php echo htmlspecialchars($student['contact_number']); ?>" required>
                    </div>

                    <!-- Address -->
                    <div class="col-md-6">
                        <label for="address" class="form-label">Address:</label>
                        <textarea id="address" name="address" class="form-control" rows="3" required><?php echo htmlspecialchars($student['address']); ?></textarea>
                    </div>

                    <!-- Department -->
                    <div class="col-md-6">
                        <label for="department" class="form-label">Department:</label>
                        <select id="department" name="department" class="form-control">
                            <option value="">Select Department</option>
                            <?php
                            $dept_sql = "SELECT DISTINCT department FROM course WHERE department IS NOT NULL AND department != ''";
                            $dept_result = $conn->query($dept_sql);
                            if ($dept_result->num_rows > 0) {
                                while ($row = $dept_result->fetch_assoc()) {
                                    echo '<option value="' . htmlspecialchars($row['department']) . '">' . htmlspecialchars($row['department']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="col-md-12">
                        <label for="password" class="form-label">New Password:</label>
                        <input type="password" id="password" name="password" class="form-control mb-3" placeholder="Enter New Password">
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-md-12">
                        <label for="confirmPassword" class="form-label">Confirm Password:</label>
                        <input type="password" id="confirmPassword" name="confirmpassword" class="form-control" placeholder="Confirm Your Password" onkeyup="validatePasswords()">
                        <span id="passwordError" class="text-danger small"></span>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" name="SUBMIT" class="btn btn-primary btn-lg">Update Profile</button>
                </div>
            </form>
        </div>
    </div>

    
    <script src="script.js"></script>
</body>
</html>
