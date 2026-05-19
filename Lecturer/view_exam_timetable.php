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

// Fetch distinct filter options from the timetable table
$years_query = "SELECT DISTINCT Year FROM timetable WHERE department = ?";
$semesters_query = "SELECT DISTINCT Semester FROM timetable WHERE department = ?";
$batches_query = "SELECT DISTINCT Batch FROM timetable WHERE department = ?";

// Prepare and execute Year query
$stmt = $conn->prepare($years_query);
$stmt->bind_param("s", $lecturer_department);
$stmt->execute();
$years_result = $stmt->get_result();

// Prepare and execute Semester query
$stmt = $conn->prepare($semesters_query);
$stmt->bind_param("s", $lecturer_department);
$stmt->execute();
$semesters_result = $stmt->get_result();

// Prepare and execute Batch query
$stmt = $conn->prepare($batches_query);
$stmt->bind_param("s", $lecturer_department);
$stmt->execute();
$batches_result = $stmt->get_result();

// Initialize filter variables
$filter_year = isset($_GET['year']) ? $_GET['year'] : '';
$filter_semester = isset($_GET['semester']) ? $_GET['semester'] : '';
$filter_batch = isset($_GET['batch']) ? $_GET['batch'] : '';

// Build SQL query with filtering
$sql = "SELECT * FROM timetable WHERE department = ?";
$params = [$lecturer_department];
$types = "s";

if ($filter_year) {
    $sql .= " AND Year = ?";
    $params[] = $filter_year;
    $types .= "s";
}

if ($filter_semester) {
    $sql .= " AND Semester = ?";
    $params[] = $filter_semester;
    $types .= "s";
}

if ($filter_batch) {
    $sql .= " AND Batch = ?";
    $params[] = $filter_batch;
    $types .= "s";
}

// Prepare and execute the query for timetable
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Exam Timetable</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {background-color:#ece000;}
       form,.card {background-color: #f0ff7f;}
    </style>
</head>
<body>

         <!-- Profile Icon and Dropdown -->
    <?php include('navbar.php'); ?>

        <br>
        
    <div class="container my-5">
        <h1 class="text-center">Exam Timetable</h1>
        <p class="text-center">Filter and view the exam timetable for your department.</p>

        <!-- Filter Form -->
        <form method="get" action="view_exam_timetable.php" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="year" class="form-label">Year</label>
                    <select id="year" name="year" class="form-select">
                        <option value="">All</option>
                        <?php while ($row = $years_result->fetch_assoc()): ?>
                            <option value="<?php echo $row['Year']; ?>" <?php echo ($filter_year == $row['Year']) ? 'selected' : ''; ?>>
                                <?php echo $row['Year']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="semester" class="form-label">Semester</label>
                    <select id="semester" name="semester" class="form-select">
                        <option value="">All</option>
                        <?php while ($row = $semesters_result->fetch_assoc()): ?>
                            <option value="<?php echo $row['Semester']; ?>" <?php echo ($filter_semester == $row['Semester']) ? 'selected' : ''; ?>>
                                <?php echo $row['Semester']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="batch" class="form-label">Batch</label>
                    <select id="batch" name="batch" class="form-select">
                        <option value="">All</option>
                        <?php while ($row = $batches_result->fetch_assoc()): ?>
                            <option value="<?php echo $row['Batch']; ?>" <?php echo ($filter_batch == $row['Batch']) ? 'selected' : ''; ?>>
                                <?php echo $row['Batch']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <!-- Timetable Table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Department</th>
                        <th>Subject</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Batch</th>
                        <th>Year</th>
                        <th>Semester</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['department']; ?></td>
                                <td><?php echo $row['subject']; ?></td>
                                <td><?php echo $row['start_time']; ?></td>
                                <td><?php echo $row['end_time']; ?></td>
                                <td><?php echo $row['Batch']; ?></td>
                                <td><?php echo $row['Year']; ?></td>
                                <td><?php echo $row['Semester']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No timetable available for the selected filters.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Back Button -->
        <div class="mt-4 text-center">
            <a href="LecturerPage.php" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
