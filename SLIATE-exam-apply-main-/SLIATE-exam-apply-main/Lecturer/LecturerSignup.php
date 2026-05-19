<?php
// Include database connection
include "../DBConnection/connect.php";

// Query to fetch unique department names, excluding null values
$sql = "SELECT DISTINCT department FROM course WHERE department IS NOT NULL AND department != ''";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {background-color:#ffe100;}
        select {width:20px;}
       form,.card {background-color: #f0ff7f;}
    </style>
</head>
<body>
<div class="container my-5">
    <div class="row">
        <!-- Form Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow p-4">
                <h2 class="text-center mb-4">Lecturer Register</h2>
                <form id="registrationForm" action="register.php" method="post" onsubmit="return validateForm()">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">I. Name In Full</label>
                        <div class="d-flex gap-2">
                            <select id="title" name="title" class="form-select" required>
                                <option value="" disabled selected>Title</option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Ms">Ms</option>
                                <option value="Rev">Rev</option>
                            </select>
                            <input type="text" id="fullName" name="fullName" class="form-control" placeholder="Enter Your Full Name" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nameWithInitials" class="form-label">II. Name With Initials</label>
                        <div class="d-flex gap-2">
                            <select id="initialsTitle" name="initialsTitle" class="form-select" required>
                                <option value="" disabled selected>Title</option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Ms">Ms</option>
                                <option value="Rev">Rev</option>
                            </select>
                            <input type="text" id="nameWithInitials" name="nameWithInitials" class="form-control" placeholder="Enter Your Name With Initials" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="regNumber" class="form-label">III. Registration Number</label>
                        <input type="text" id="regNumber" name="regNumber" class="form-control" placeholder="Enter Your Registration Number" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">IV. Present Address</label>
                        <input type="text" id="address" name="address" class="form-control" placeholder="Enter Your Address" required>
                    </div>

                    <div class="mb-3">
                    <label for="department">Department:</label>
                     <select id="department" name="department" class="form-control">
                      <option value="">Select Department</option>
                     <?php
                   // Populate the dropdown with departments from the course table
                   if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                     echo '<option value="' . htmlspecialchars($row['department']) . '">' . htmlspecialchars($row['department']) . '</option>';
                      }
                  }
                  ?>
             </select>
            </div>

                    <div class="mb-3">
                        <label class="form-label">V. Contact Details</label>
                        <div class="mb-2">
                            <label for="mobile" class="form-label">Mobile No:</label>
                            <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Enter Your Contact Number" required>
                        </div>
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" id="emailField" name="email" class="form-control" placeholder="Enter Your E-mail Address" onkeyup="showerror()" required>
                        <span id="emailError" class="text-danger small"></span>
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select id="gender" name="gender" class="form-select" required>
                            <option value="" disabled selected>Select your gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm Your Password" onkeyup="validatePasswords()" required>
                        <span id="passwordError" class="text-danger small"></span>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="SUBMIT" class="btn btn-primary w-100">Sign Up</button>
                    </div>

                    <p class="text-center mt-3">Already registered? <a href="Lecturer_login.php">Log in</a></p>
                </form>
            </div>
        </div>

        <!-- Image Section -->
        <div class="col-lg-6 d-flex align-items-center">
            <img src="../Images/best-laptops1_3rct.1248.png" alt="Signup display photo" class="img-fluid rounded shadow">
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
