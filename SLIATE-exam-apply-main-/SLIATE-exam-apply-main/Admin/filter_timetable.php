<?php
// Include database connection
include "../DBConnection/connect.php";

// Get filter inputs
$department = $_GET['department'] ?? '';
$batch = $_GET['batch'] ?? '';
$year = $_GET['year'] ?? '';
$semester = $_GET['semester'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Timetable</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }
        body {background-color: #ffe100;} 
        .card {background-color: #f0ff7f;} 
    </style>
</head>
<body class="">

    <!-- Profile Icon and Dropdown -->
    <?php include('navbar.php'); ?> 
    
    <!-- Filter Form -->
    <div class="container mt-5 pt-3">
        <h2 class="fw-bold text-center mb-4">Filter and Print Timetable</h2>
        <form action="print_timetable.php" method="get" class="card p-4 shadow-lg">
            <div class="mb-3">
                <label for="department" class="form-label">Select Department:</label>
                <select id="department" name="department" class="form-select" required>
                    <option value="">Select Department</option>
                    <option value="Computer Science" <?php echo ($department == "Computer Science" ? "selected" : ""); ?>>Computer Science</option>
                    <option value="Information Technology" <?php echo ($department == "Information Technology" ? "selected" : ""); ?>>Information Technology</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="batch" class="form-label">Enter Batch:</label>
                <input type="text" id="batch" name="batch" value="<?php echo htmlspecialchars($batch); ?>" class="form-control" placeholder="Enter Batch" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Select Year:</label>
                <select id="year" name="year" class="form-select" required>
                    <option value="">Select Year</option>
                    <?php
                    for ($y = date("Y"); $y >= 2020; $y--) {
                        echo '<option value="' . $y . '"' . ($year == $y ? "selected" : "") . '>' . $y . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="semester" class="form-label">Select Semester:</label>
                <select id="semester" name="semester" class="form-select" required>
                    <option value="">Select Semester</option>
                    <?php
                    for ($s = 1; $s <= 8; $s++) {
                        echo '<option value="' . $s . '"' . ($semester == $s ? "selected" : "") . '>Semester ' . $s . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                  <a href="admin.php" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>

    <?php if (!empty($department) && !empty($batch) && !empty($year) && !empty($semester)): ?>
        <!-- Timetable Results -->
        <div class="container mt-5">
            <?php
            // Use prepared statement to avoid SQL injection
            $stmt = $conn->prepare("SELECT * FROM timetable WHERE department = ? AND batch = ? AND year = ? AND semester = ?");
            $stmt->bind_param("ssss", $department, $batch, $year, $semester);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0): ?>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Subject</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                <td><?php echo htmlspecialchars($row['start_time']); ?></td>
                                <td><?php echo htmlspecialchars($row['end_time']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <div class="no-print text-center mt-4">
                    <button class="btn btn-primary" onclick="window.print()">Print Timetable</button>
                    <a href="admin.php" class="btn btn-secondary">Back</a>
                </div>
            <?php else: ?>
                <p class="text-danger text-center">No records found for the selected filters.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="container mt-5 text-center">
            <p class="text-danger">Please fill all filters to view the timetable.</p>
        </div>
    <?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
