<?php
// Include database connection
include "../DBConnection/connect.php";

// Fetch unique filter options dynamically
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

// Fetch pending applications
function getPendingApplications($filters) {
    global $conn;
    $sql = "SELECT * FROM pending_studentapply WHERE 1=1";

    // Apply filters
    foreach ($filters as $key => $value) {
        if (!empty($value)) {
            $sql .= " AND $key = '" . $conn->real_escape_string($value) . "'";
        }
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Approve an application
function approveApplication($registrationNumber) {
    global $conn;
    $sql = "INSERT INTO approved_studentapply SELECT * FROM pending_studentapply WHERE Registration_number = '$registrationNumber'";
    $deleteSql = "DELETE FROM pending_studentapply WHERE Registration_number = '$registrationNumber'";

    if ($conn->query($sql) === TRUE && $conn->query($deleteSql) === TRUE) {
        return true;
    }
    return false;
}

// Reject an application
function rejectApplication($registrationNumber) {
    global $conn;
    $sql = "INSERT INTO reject_studentapply SELECT * FROM pending_studentapply WHERE Registration_number = '$registrationNumber'";
    $deleteSql = "DELETE FROM pending_studentapply WHERE Registration_number = '$registrationNumber'";

    if ($conn->query($sql) === TRUE && $conn->query($deleteSql) === TRUE) {
        return true;
    }
    return false;
}

// Handle approval/rejection actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve'])) {
        $registrationNumber = $_POST['registration_number'];
        approveApplication($registrationNumber);
    } elseif (isset($_POST['reject'])) {
        $registrationNumber = $_POST['registration_number'];
        rejectApplication($registrationNumber);
    }
}

// Fetch filter options
$departments = getFilterOptions('department', 'pending_studentapply');
$batches = getFilterOptions('academic_year', 'pending_studentapply');
$semesters = getFilterOptions('semester', 'pending_studentapply');

// Apply filters
$filters = [
    'department' => $_GET['department'] ?? '',
    'academic_year' => $_GET['academic_year'] ?? '',
    'semester' => $_GET['semester'] ?? '',
    'Registration_number' => $_GET['Registration_number'] ?? ''
];

// Fetch pending applications
$pendingApplications = getPendingApplications($filters);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Approvals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {background-color: #ffe100;} 
        .card {background-color: #f0ff7f;} 
    </style>
</head>
<body>

<br>

    <!-- Profile Icon and Dropdown -->
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Application Approvals</h1>

        <!-- Filters Section -->
        <form method="GET" class="card p-4 shadow-lg mb-4">
            <h2 class="fw-bold text-center mb-4">Filters</h2>
            <div class="row">
                <div class="col-md-3">
                    <label for="department" class="form-label">Department</label>
                    <select name="department" id="department" class="form-select">
                        <option value="">All</option>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?= $department ?>" <?= (isset($_GET['department']) && $_GET['department'] === $department) ? 'selected' : '' ?>>
                                <?= $department ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="academic_year" class="form-label">Batch</label>
                    <select name="academic_year" id="academic_year" class="form-select">
                        <option value="">All</option>
                        <?php foreach ($batches as $batch): ?>
                            <option value="<?= $batch ?>" <?= (isset($_GET['academic_year']) && $_GET['academic_year'] === $batch) ? 'selected' : '' ?>>
                                <?= $batch ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select name="semester" id="semester" class="form-select">
                        <option value="">All</option>
                        <?php foreach ($semesters as $semester): ?>
                            <option value="<?= $semester ?>" <?= (isset($_GET['semester']) && $_GET['semester'] === $semester) ? 'selected' : '' ?>>
                                <?= $semester ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="Registration_number" class="form-label">Student</label>
                    <input type="text" name="Registration_number" id="Registration_number" class="form-control" placeholder="e.g., 12345" value="<?= $_GET['Registration_number'] ?? '' ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Apply Filters</button>
        </form>

        <!-- Pending Applications Table -->
        <div class="card p-4 shadow-lg">
            <h2 class="fw-bold text-center mb-4">Pending Applications</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Registration Number</th>
                        <th>Course Name</th>
                        <th>Semester</th>
                        <th>Academic Year</th>
                        <th>Index Number</th>
                        <th>Department</th>
                        <th>Eligibility</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pendingApplications)): ?>
                        <?php foreach ($pendingApplications as $application): ?>
                            <tr>
                                <td><?= $application['Registration_number'] ?></td>
                                <td><?= $application['course_name'] ?></td>
                                <td><?= $application['semester'] ?></td>
                                <td><?= $application['academic_year'] ?></td>
                                <td><?= $application['index_number'] ?></td>
                                <td><?= $application['department'] ?></td>
                                <td><?= $application['eligibility'] ?></td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="registration_number" value="<?= $application['Registration_number'] ?>">
                                        <button type="submit" name="approve" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="registration_number" value="<?= $application['Registration_number'] ?>">
                                        <button type="submit" name="reject" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No pending applications found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
