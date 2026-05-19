<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Already Applied</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-warning.bg-gradient">

    <!-- Profile Icon and Dropdown -->
    <?php include('navbar.php'); ?>

    <div class="container mt-5 pt-5"> 
        <!-- Message Container -->
        <div class="card p-4 shadow-lg mx-auto text-center" style="max-width: 600px;">
            <h1 class="fw-bold text-primary mb-4">You're already applied for this semester exam</h1>
            
            <!-- Buttons for different options -->
            <a href="ApplicationStatus.php" class="btn btn-primary btn-lg mb-3">Application Status</a>
            <a href="view_exam_timetable.php" class="btn btn-primary btn-lg mb-3">Exam Timetable</a>
            <a href="showResults.php" class="btn btn-primary btn-lg">Previous Exams Results</a>
        </div>
    </div>

    
</body>
</html>
