<?php
include "../DBConnection/connect.php";

// Handle approve or reject actions
if (isset($_POST['action'])) {
    $result_ID = $_POST['result_ID'];
    $action = $_POST['action']; // 'approve' or 'reject'

    if ($action === 'approve') {
        // Move data to approved_results
        $queryMove = "INSERT INTO approved_results (result_ID, lecturer_id, department, Module, registrationNumber, issued_Date, issued_time, result_status, grade, marks, year, semester, batch)
                      SELECT result_ID, lecturer_id, department, Module, registrationNumber, issued_Date, issued_time, 'Completed', grade, marks, year, semester, batch 
                      FROM results WHERE result_ID = ?";
    } elseif ($action === 'reject') {
        // Move data to reject_results
        $queryMove = "INSERT INTO reject_results (result_ID, lecturer_id, department, Module, registrationNumber, issued_Date, issued_time, result_status, grade, marks, year, semester, batch)
                      SELECT result_ID, lecturer_id, department, Module, registrationNumber, issued_Date, issued_time, 'Rejected', grade, marks, year, semester, batch 
                      FROM results WHERE result_ID = ?";
    }

    // Execute the move query
    if (isset($queryMove)) {
        $stmtMove = $conn->prepare($queryMove);
        $stmtMove->bind_param("i", $result_ID);
        $stmtMove->execute();
    }

    // Remove the result from the results table
    $queryDelete = "DELETE FROM results WHERE result_ID = ?";
    $stmtDelete = $conn->prepare($queryDelete);
    $stmtDelete->bind_param("i", $result_ID);
    $stmtDelete->execute();

    echo "<script>alert('Result successfully {$action}d!');</script>";
}

// Fetch data with filters
$filter = "";
if (isset($_POST['filter'])) {
    $column = $_POST['filter_column'];
    $value = $_POST['filter_value'];
    $filter = "WHERE $column = ?";
}

$query = "SELECT * FROM results $filter";
$stmt = $conn->prepare($query);
if ($filter !== "") {
    $stmt->bind_param("s", $value);
}
$stmt->execute();
$results = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Marking Approvals</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #ffe100; } /* Yellow background */
    </style>
</head>
<body>

    <!-- Profile Icon and Dropdown -->
    <?php include('navbar.php'); ?> 

    <div class="container mt-5 pt-3"> <!-- Added space below navbar -->
        <h1 class="fw-bold text-center mb-4">Markings Approvals</h1>

        <!-- Filter Form -->
        <form method="POST" class="mb-3 card p-3 shadow-lg">
            <div class="row g-3">
                <div class="col-md-4">
                    <select name="filter_column" class="form-select" required>
                        <option value="year">Year</option>
                        <option value="batch">Batch</option>
                        <option value="registrationNumber">Registration Number</option>
                        <option value="Module">Module</option>
                        <option value="department">Department</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="filter_value" class="form-control" placeholder="Enter filter value" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" name="filter" class="btn btn-primary w-100">Apply Filter</button>
                </div>
            </div>
        </form>

        <!-- Results Table -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Result ID</th>
                    <th>Lecturer ID</th>
                    <th>Department</th>
                    <th>Module</th>
                    <th>Registration Number</th>
                    <th>Issued Date</th>
                    <th>Issued Time</th>
                    <th>Grade</th>
                    <th>Marks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['result_ID']) ?></td>
                        <td><?= htmlspecialchars($row['lecturer_id']) ?></td>
                        <td><?= htmlspecialchars($row['department']) ?></td>
                        <td><?= htmlspecialchars($row['Module']) ?></td>
                        <td><?= htmlspecialchars($row['registrationNumber']) ?></td>
                        <td><?= htmlspecialchars($row['issued_Date']) ?></td>
                        <td><?= htmlspecialchars($row['issued_time']) ?></td>
                        <td><?= htmlspecialchars($row['grade']) ?></td>
                        <td><?= htmlspecialchars($row['marks']) ?></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="result_ID" value="<?= $row['result_ID'] ?>">
                                <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                                <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="admin.php" class="btn btn-secondary">Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
