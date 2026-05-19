<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #ffe100; } 
        .container { max-width: 600px; } 
    </style>
</head>
<body>

    <!-- Profile Icon and Dropdown -->
    <?php include('navbar.php'); ?> 

    <!-- Admin Options Container -->
    <div class="container mt-5 pt-3">
        <h1 class="fw-bold text-center mb-4">Admin's Page</h1>
        <div class="card p-4 shadow-lg">
            <div class="d-grid gap-3">
                <a href="setTimeTable.php" class="btn btn-primary">Set Timetables</a>
                <a href="filter_timetable.php" class="btn btn-primary">Filter and Print Time Table</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
