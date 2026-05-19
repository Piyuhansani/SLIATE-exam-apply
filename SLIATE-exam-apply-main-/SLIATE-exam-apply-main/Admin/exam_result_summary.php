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

// Fetch data based on filters and calculate counts
function getCount($table, $filters, $condition = "1=1") {
    global $conn;
    $sql = "SELECT COUNT(*) as count FROM $table WHERE $condition";

    // Apply filters
    foreach ($filters as $key => $value) {
        if (!empty($value)) {
            $sql .= " AND $key = '" . $conn->real_escape_string($value) . "'";
        }
    }

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Fetch filter options
$departments = getFilterOptions('department', 'approved_results');
$batches = getFilterOptions('batch', 'approved_results');
$semesters = getFilterOptions('semester', 'approved_results');
$years = getFilterOptions('year', 'approved_results');
$grades = getFilterOptions('grade', 'approved_results');

// Apply filters
$filters = [
    'department' => $_GET['department'] ?? '',
    'batch' => $_GET['batch'] ?? '',
    'semester' => $_GET['semester'] ?? '',
    'year' => $_GET['year'] ?? '',
    'grade' => $_GET['grade'] ?? ''
];

// Get counts
$totalApproved = getCount('approved_results', $filters);
$totalRejected = getCount('reject_results', $filters);
$totalResults = $totalApproved + $totalRejected;

$passedCount = getCount('approved_results', $filters, "grade IN ('A', 'B', 'C')");
$failedCount = getCount('approved_results', $filters, "grade IN ('D', 'F')");
$marksPercentage = $totalResults ? round(($passedCount / $totalResults) * 100, 2) : 0;
$gradePercentage = $totalResults ? round(($failedCount / $totalResults) * 100, 2) : 0;

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #ffe100; } /* Yellow background */
        .card { background-color: #f0ff7f; } /* Card background */
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <?php include('navbar.php'); ?>

    <br>

    <div class="container mt-5">
        <!-- Filters Section -->
        <div class="card p-4 shadow-lg mb-4">
            <h2 class="fw-bold text-center mb-4">Filters</h2>
            <form method="GET" id="filterForm">
                <div class="row">
                    <div class="col-md-2">
                        <label for="department" class="form-label">Department</label>
                        <select name="department" id="department" class="form-select">
                            <option value="">All</option>
                            <?php foreach ($departments as $department): ?>
                                <option value="<?= $department ?>"><?= $department ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="batch" class="form-label">Batch</label>
                        <select name="batch" id="batch" class="form-select">
                            <option value="">All</option>
                            <?php foreach ($batches as $batch): ?>
                                <option value="<?= $batch ?>"><?= $batch ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="semester" class="form-label">Semester</label>
                        <select name="semester" id="semester" class="form-select">
                            <option value="">All</option>
                            <?php foreach ($semesters as $semester): ?>
                                <option value="<?= $semester ?>"><?= $semester ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="year" class="form-label">Year</label>
                        <select name="year" id="year" class="form-select">
                            <option value="">All</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?= $year ?>"><?= $year ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="grade" class="form-label">Grade</label>
                        <select name="grade" id="grade" class="form-select">
                            <option value="">All</option>
                            <?php foreach ($grades as $grade): ?>
                                <option value="<?= $grade ?>"><?= $grade ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Apply Filters</button>
            </form>
        </div>

        <!-- Summary Section -->
        <div class="card p-4 shadow-lg mb-4">
            <h2 class="fw-bold text-center mb-4">Exam Result Summary</h2>
            <div>
                <h4>Total Approved Results: <?= $totalApproved ?></h4>
                <h4>Total Rejected Results: <?= $totalRejected ?></h4>
                <h4>Passed Percentage: <?= $marksPercentage ?>%</h4>
                <h4>Failed Percentage: <?= $gradePercentage ?>%</h4>
            </div>
        </div>

        <!-- Visualizations Section -->
        <div class="card p-4 shadow-lg">
            <h2 class="fw-bold text-center mb-4">Visualizations</h2>
            <div class="row">
                <div class="col-md-6">
                    <canvas id="pieChart" class="w-100"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="barChart" class="w-100"></canvas>
                </div>
            </div>
        </div>

        <!-- Print Button -->
        <div class="text-center mt-4">
            <button class="btn btn-primary" onclick="printPage()">Print Results</button>
        </div>
    </div>

    <!-- Bootstrap JS and Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function printPage() {
            window.print();
        }

        // Visualization Logic
        const pieChartCanvas = document.getElementById('pieChart').getContext('2d');
        const barChartCanvas = document.getElementById('barChart').getContext('2d');

        new Chart(pieChartCanvas, {
            type: 'pie',
            data: {
                labels: ['Passed', 'Failed'],
                datasets: [{
                    data: [<?= $marksPercentage ?>, <?= $gradePercentage ?>],
                    backgroundColor: ['green', 'red']
                }]
            }
        });

        new Chart(barChartCanvas, {
            type: 'bar',
            data: {
                labels: ['Approved', 'Rejected'],
                datasets: [{
                    data: [<?= $totalApproved ?>, <?= $totalRejected ?>],
                    backgroundColor: ['blue', 'orange']
                }]
            }
        });
    </script>
</body>
</html>
