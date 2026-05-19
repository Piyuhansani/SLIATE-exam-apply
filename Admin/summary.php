<?php
// Include database connection
include "../DBConnection/connect.php";

// Check if the function doesn't already exist
if (!function_exists('getFilterOptions')) {
    // Fetch filter options dynamically
    function getFilterOptions($column, $table) {
        global $conn;
        $sql = "SELECT DISTINCT $column FROM $table";
        $result = $conn->query($sql);
        $options = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $options[] = $row[$column];
            }
        }
        return $options;
    }
}

// Fetch student applications with status
function getStudentApplications($filters) {
    global $conn;
    $sql = "SELECT 
                sa.Registration_number, 
                sa.course_name, 
                sa.semester, 
                sa.academic_year, 
                sa.index_number, 
                sa.department, 
                IF(psa.Registration_number IS NOT NULL, 'Pending', 
                    IF(asa.Registration_number IS NOT NULL, 'Complete', 'Review')) AS status
            FROM studentapply sa
            LEFT JOIN pending_studentapply psa ON sa.Registration_number = psa.Registration_number
            LEFT JOIN approved_studentapply asa ON sa.Registration_number = asa.Registration_number
            WHERE 1=1";

    // Apply filters
    foreach ($filters as $key => $value) {
        if (!empty($value)) {
            $sql .= " AND sa.$key = '" . $conn->real_escape_string($value) . "'";
        }
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Fetch totals for visualization
function getStatusCounts($filters) {
    global $conn;
    $pendingCountSql = "SELECT COUNT(*) as pending FROM pending_studentapply psa WHERE 1=1";
    $approvedCountSql = "SELECT COUNT(*) as approved FROM approved_studentapply asa WHERE 1=1";
    $totalCountSql = "SELECT COUNT(*) as total FROM studentapply sa WHERE 1=1";

    // Apply filters
    foreach ($filters as $key => $value) {
        if (!empty($value)) {
            $pendingCountSql .= " AND psa.$key = '" . $conn->real_escape_string($value) . "'";
            $approvedCountSql .= " AND asa.$key = '" . $conn->real_escape_string($value) . "'";
            $totalCountSql .= " AND sa.$key = '" . $conn->real_escape_string($value) . "'";
        }
    }

    $pending = $conn->query($pendingCountSql)->fetch_assoc()['pending'];
    $approved = $conn->query($approvedCountSql)->fetch_assoc()['approved'];
    $total = $conn->query($totalCountSql)->fetch_assoc()['total'];
    $rejected = $total - ($pending + $approved);

    return ['pending' => $pending, 'approved' => $approved, 'rejected' => $rejected, 'total' => $total];
}

// Fetch filter options
$departments = getFilterOptions('department', 'studentapply');
$years = getFilterOptions('academic_year', 'studentapply');
$semesters = getFilterOptions('semester', 'studentapply');
$batches = getFilterOptions('academic_year', 'studentapply'); // Batch filter

// Apply filters
$filters = [
    'department' => $_GET['department'] ?? '',
    'academic_year' => $_GET['academic_year'] ?? '',
    'semester' => $_GET['semester'] ?? '',
    'batch' => $_GET['batch'] ?? '' // Batch filter handled here
];

// Fetch student applications and status counts
$studentApplications = getStudentApplications($filters);
$statusCounts = getStatusCounts($filters);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Applied Students Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {background-color: #ffe100;} 
        .card {background-color: #f0ff7f;} 
    </style>
</head>
<body>

    <!-- Profile Icon and Dropdown -->
    <?php include('navbar.php'); ?> 

    <br>
    
    <div class="container mt-5 pt-3">
        <h1 class="fw-bold text-center mb-4">Exam Applied Students Summary</h1>

        <!-- Filters Section -->
        <form method="GET" class="card p-4 shadow-lg mb-4">
            <h2 class="fw-bold text-center mb-4">Filters</h2>
            <div class="row">
                <div class="col-md-3">
                    <label for="department" class="form-label">Department</label>
                    <select name="department" id="department" class="form-select">
                        <option value="">All</option>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?= $department ?>" <?= ($_GET['department'] ?? '') === $department ? 'selected' : '' ?>>
                                <?= $department ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="academic_year" class="form-label">Year</label>
                    <select name="academic_year" id="academic_year" class="form-select">
                        <option value="">All</option>
                        <?php foreach ($years as $year): ?>
                            <option value="<?= $year ?>" <?= ($_GET['academic_year'] ?? '') === $year ? 'selected' : '' ?>>
                                <?= $year ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select name="semester" id="semester" class="form-select">
                        <option value="">All</option>
                        <?php foreach ($semesters as $semester): ?>
                            <option value="<?= $semester ?>" <?= ($_GET['semester'] ?? '') === $semester ? 'selected' : '' ?>>
                                <?= $semester ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="batch" class="form-label">Batch</label>
                    <select name="batch" id="batch" class="form-select">
                        <option value="">All</option>
                        <?php foreach ($batches as $batch): ?>
                            <option value="<?= $batch ?>" <?= ($_GET['batch'] ?? '') === $batch ? 'selected' : '' ?>>
                                <?= $batch ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Apply Filters</button>
        </form>

        <!-- Summary Info -->
        <div class="card p-4 shadow-lg mb-4">
            <h2 class="fw-bold text-center">Summary</h2>
            <p class="text-center">Total Students: <?= $statusCounts['total'] ?></p>
            <p class="text-center">Pending Applications: <?= $statusCounts['pending'] ?></p>
            <p class="text-center">Approved Applications: <?= $statusCounts['approved'] ?></p>
            <p class="text-center">Rejected Applications: <?= $statusCounts['rejected'] ?></p>
        </div>

        <!-- Applied Students Table -->
        <div class="card p-4 shadow-lg">
            <h3 class="fw-bold text-center mb-4">Applied Students List</h3>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Registration Number</th>
                        <th>Course Name</th>
                        <th>Semester</th>
                        <th>Year</th>
                        <th>Index Number</th>
                        <th>Department</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($studentApplications)): ?>
                        <?php foreach ($studentApplications as $application): ?>
                            <tr>
                                <td><?= $application['Registration_number'] ?></td>
                                <td><?= $application['course_name'] ?></td>
                                <td><?= $application['semester'] ?></td>
                                <td><?= $application['academic_year'] ?></td>
                                <td><?= $application['index_number'] ?></td>
                                <td><?= $application['department'] ?></td>
                                <td><?= $application['status'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No applications found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Back and Print Summary Buttons -->
        <div class="text-center mt-4">
            <button class="btn btn-secondary" onclick="window.location.href='admin.php'">Back</button>
            <button