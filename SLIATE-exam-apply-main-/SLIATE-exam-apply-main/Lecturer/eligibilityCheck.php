<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include "../DBConnection/connect.php";

// Ensure the lecturer's department is stored in session
if (!isset($_SESSION['department'])) {
    die("Error: Department information is missing. Please log in again.");
}

// Fetch lecturer's department from session
$lecturer_department = $_SESSION['department'];

// Fetch students and their subjects from the studentapply table for the lecturer's department
$sql = "SELECT Registration_number, course_name, semester, academic_year, index_number, department, subject1, subject2, subject3, subject4, subject5, subject6, subject7, subject8, subject9, subject10 FROM studentapply WHERE department = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $lecturer_department);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eligibility Check</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {background-color:#ffe100;}
    </style>
</head>
<body>

    <!-- Profile Icon and Dropdown -->
    <?php include('navbar.php'); ?>

    <br>

    <div class="container my-5">
        <h1 class="text-center">Eligibility Check</h1>
        <p class="text-center">Review and determine the eligibility of students from your department.</p>

        <!-- Back Button -->
        <div class="mb-4">
            <a href="LecturerPage.php" class="btn btn-secondary">Back</a>
        </div>

        <form method="post" action="">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Registration Number</th>
                            <th>Course Name</th>
                            <th>Semester</th>
                            <th>Academic Year</th>
                            <th>Index Number</th>
                            <th>Department</th>
                            <th>Subjects</th>
                            <th>Eligibility</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php 
    while ($row = $result->fetch_assoc()): 
    ?>
        <tr>
            <td rowspan="10">
                <input type="hidden" name="Registration_number[]" value="<?php echo $row['Registration_number']; ?>">
                <?php echo $row['Registration_number']; ?>
            </td>
            <td rowspan="10">
                <input type="hidden" name="course_name[]" value="<?php echo $row['course_name']; ?>">
                <?php echo $row['course_name']; ?>
            </td>
            <td rowspan="10">
                <input type="hidden" name="semester[]" value="<?php echo $row['semester']; ?>">
                <?php echo $row['semester']; ?>
            </td>
            <td rowspan="10">
                <input type="hidden" name="academic_year[]" value="<?php echo $row['academic_year']; ?>">
                <?php echo $row['academic_year']; ?>
            </td>
            <td rowspan="10">
                <input type="hidden" name="index_number[]" value="<?php echo $row['index_number']; ?>">
                <?php echo $row['index_number']; ?>
            </td>
            <td rowspan="10">
                <input type="hidden" name="department[]" value="<?php echo $row['department']; ?>">
                <?php echo $row['department']; ?>
            </td>

    <?php 
        for ($i = 1; $i <= 10; $i++): 
            $subject = $row["subject$i"];
            if ($subject): 
    ?>
        <tr>
            <td>
                <input type="hidden" name="subject[]" value="<?php echo $subject; ?>">
                <?php echo $subject; ?>
            </td>
            <td>
                <select name="eligibility[]" class="form-select" required>
                    <option value="">Select</option>
                    <option value="Eligible">Eligible</option>
                    <option value="Not Eligible">Not Eligible</option>
                </select>
            </td>
            <td>
                <input type="text" name="remarks[]" class="form-control" placeholder="Add remarks">
            </td>
        </tr>
    <?php 
            endif; 
        endfor; 
    endwhile; 
    ?>
                    </tbody>
                </table>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// Include database connection
include "../DBConnection/connect.php";

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Fetch values from the form
    $registration_numbers = $_POST['Registration_number'];
    $course_names = $_POST['course_name'];
    $semesters = $_POST['semester'];
    $academic_years = $_POST['academic_year'];
    $index_numbers = $_POST['index_number'];
    $departments = $_POST['department'];
    $subjects = $_POST['subject'];
    $eligibilities = $_POST['eligibility'];
    $remarks = $_POST['remarks'];

    // SQL query for inserting/updating into pending_studentapply table
    $sql = "INSERT INTO pending_studentapply (Registration_number, course_name, semester, academic_year, index_number, department, subject1, subject2, subject3, subject4, subject5, subject6, subject7, subject8, subject9, subject10, eligibility, remarks) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            course_name = VALUES(course_name),
            semester = VALUES(semester),
            academic_year = VALUES(academic_year),
            index_number = VALUES(index_number),
            department = VALUES(department),
            eligibility = VALUES(eligibility),
            remarks = VALUES(remarks)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Loop through all rows in the form
    foreach ($registration_numbers as $key => $registration_number) {
        $course_name = $course_names[$key];
        $semester = $semesters[$key];
        $academic_year = $academic_years[$key];
        $index_number = $index_numbers[$key];
        $department = $departments[$key];
        $eligibility = $eligibilities[$key];
        $remark = $remarks[$key];

        // Pass values for each subject (assumes subjects array matches dynamically)
        $subject_values = array_fill(0, 10, NULL); // Default null for subjects
        for ($i = 0; $i < 10; $i++) {
            if (isset($subjects[$key * 10 + $i])) {
                $subject_values[$i] = $subjects[$key * 10 + $i];
            }
        }

        // Bind and execute the prepared statement
        $stmt->bind_param("ssssssssssssssssss", 
            $registration_number, 
            $course_name, 
            $semester, 
            $academic_year, 
            $index_number, 
            $department, 
            $subject_values[0], 
            $subject_values[1], 
            $subject_values[2], 
            $subject_values[3], 
            $subject_values[4], 
            $subject_values[5], 
            $subject_values[6], 
            $subject_values[7], 
            $subject_values[8], 
            $subject_values[9], 
            $eligibility, 
            $remark
        );
        $stmt->execute();
    }

    // Close the statement
    $stmt->close();

    echo "Data successfully updated!";
}

// Close the database connection
$conn->close();
?>
