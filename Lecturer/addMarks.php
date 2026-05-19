<?php

include "../DBConnection/connect.php";


// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the lecturer ID is set in the session e 
if (!isset($_SESSION['lecturer_id'])) {
    $_SESSION['lecturer_id'] = "0000"; 
}



$result_ID = null;

// Query to fetch the next AUTO_INCREMENT value
$query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES 
          WHERE TABLE_SCHEMA = 'exam_managment_system' AND TABLE_NAME = 'results'";
$result = $conn->query($query);
if ($row = $result->fetch_assoc()) {
    $result_ID = $row['AUTO_INCREMENT'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Entry</title>

    <!-- Bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffe100; 
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <!-- Form Container -->
    <div class="container mt-5 pt-4">
        <div class="card shadow-lg p-4" style="max-width: 600px; margin: auto; background-color: #f0ff7f;">
            <h1 class="fw-bold text-center mb-4">Result Entry</h1>
            <form action="" method="POST" onsubmit="return validateForm();">
                <div class="row mb-3">
                    <label for="result_ID" class="col-sm-4 col-form-label">Result ID:</label>
                    <div class="col-sm-8">
                        <input type="text" id="result_ID" name="result_ID" class="form-control" value="<?= htmlspecialchars($result_ID) ?>" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="department" class="col-sm-4 col-form-label">Department:</label>
                    <div class="col-sm-8">
                        <select id="department" name="department" class="form-select" required>
                            <option value="">Select Department</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Information Technology">Information Technology</option>
                            <option value="Business Administration">Business Administration</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Mathematics">Mathematics</option>
                            <option value="Physics">Physics</option>
                            <option value="Biology">Biology</option>
                            <option value="Chemistry">Chemistry</option>
                            <option value="Accounting">Accounting</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="lecturer_id" class="col-sm-4 col-form-label">Lecturer ID:</label>
                    <div class="col-sm-8">
                    <input type="text" id="lecturer_id" name="lecturer_id" class="form-control" value="<?= htmlspecialchars($_SESSION['lecturer_id']) ?>" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="Module" class="col-sm-4 col-form-label">Module:</label>
                    <div class="col-sm-8">
                        <input type="text" id="Module" name="Module" class="form-control" placeholder="Enter Module" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="registrationNumber" class="col-sm-4 col-form-label">Student Reg. No:</label>
                    <div class="col-sm-8">
                        <input type="text" id="registrationNumber" name="registrationNumber" class="form-control" placeholder="Enter Registration Number" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="grade" class="col-sm-4 col-form-label">Grade:</label>
                    <div class="col-sm-8">
                        <select id="grade" name="grade" class="form-select" required>
                            <option value="">Select Grade</option>
                            <option value="A+">A+</option>
                            <option value="A">A</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B">B</option>
                            <option value="B-">B-</option>
                            <option value="C+">C+</option>
                            <option value="C">C</option>
                            <option value="C-">C-</option>
                            <option value="D+">D+</option>
                            <option value="D">D</option>
                            <option value="F">F</option>
                            <option value="AB">AB</option>
                            <option value="MC">MC</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="issued_Date" class="col-sm-4 col-form-label">Issued Date:</label>
                    <div class="col-sm-8">
                        <input type="date" id="issued_Date" name="issued_Date" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="issued_time" class="col-sm-4 col-form-label">Issued Time:</label>
                    <div class="col-sm-8">
                        <input type="time" id="issued_time" name="issued_time" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="result_status" class="col-sm-4 col-form-label">Result Status:</label>
                    <div class="col-sm-8">
                        <input type="text" id="result_status" name="result_status" class="form-control" value="Pending" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="marks" class="col-sm-4 col-form-label">Marks:</label>
                    <div class="col-sm-8">
                        <input type="text" id="marks" name="marks" class="form-control" placeholder="Enter Marks" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="year" class="col-sm-4 col-form-label">Year:</label>
                    <div class="col-sm-8">
                        <select id="year" name="year" class="form-select" required>
                            <option value="">Select Year</option>
                            <?php
                            for ($year = date("Y"); $year >= 2020; $year--) {
                                echo "<option value=\"$year\">$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="semester" class="col-sm-4 col-form-label">Semester:</label>
                    <div class="col-sm-8">
                        <select id="semester" name="semester" class="form-select" required>
                            <option value="">Select Semester</option>
                            <?php
                            for ($i = 1; $i <= 8; $i++) {
                                echo "<option value=\"$i\">Semester $i</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="batch" class="col-sm-4 col-form-label">Batch:</label>
                    <div class="col-sm-8">
                        <input type="text" id="batch" name="batch" class="form-control" placeholder="Enter Batch" required>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <button type="submit" id="btn_btn-primary" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <!-- Back button -->
            <div class="mt-3 text-center">
                <a href="LecturerPage.php" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>

   
    <script src="script.js"></script>

<?php // Check if the form is submitted
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $department = $_POST["department"];
     $lecturer_id = $_POST["lecturer_id"];
     $Module = $_POST["Module"];
     $registrationNumber = $_POST["registrationNumber"];
     $grade = $_POST["grade"];
    $issued_Date = $_POST["issued_Date"]; 
    $issued_time = $_POST["issued_time"]; 
    $result_status = $_POST["result_status"]; 
    $marks = $_POST["marks"]; $year = $_POST["year"]; 
    $semester = $_POST["semester"]; $batch = $_POST["batch"]; 
    
    // Inserting results into the database 
    $sql = "INSERT INTO results (department, lecturer_id, Module, 
    registrationNumber, grade, issued_Date, issued_time, 
    result_status, marks, year, semester, batch)
     VALUES ('$department', '$lecturer_id', '$Module',
      '$registrationNumber', '$grade', '$issued_Date', '$issued_time',
       '$result_status', '$marks', '$year', '$semester', '$batch')";
        $result = $conn->query($sql); 
        
        if ($result) { echo "<script>alert('Results successfully submitted!'); window.location.href = 'addMarks.php';</script>"; }
         else { echo "<script>alert('Error: " . $conn->error . "'); window.location.href = 'addMarks.php';</script>"; } }
          // Closing the database connection
           $conn->close(); ?>

</body>
</html>
