

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <!-- Bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {background-color: #ffe100;} 
    </style>
</head>
<body class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100vh;">

    <!-- Profile Icon and Dropdown -->
    <?php include('navbar.php'); ?>

    <!-- Admin Options Container -->
    <div class="card p-4 shadow-lg text-center" style="width: 100%; max-width: 600px; background-color: #f0ff7f;">
        <h1 class="fw-bold mb-4">Admin's Page</h1>
        <!-- Navigation Buttons -->
        <div class="d-grid gap-3">
            <a href="close_applications_progress.php" class="btn btn-primary btn-lg">Close Applications</a>
            <a href="close_timetable_progress.php" class="btn btn-primary btn-lg">Close Timetable</a>
            
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
