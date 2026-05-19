<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Ensure the user's full name is available in the session
if (!isset($_SESSION['userName'])) {
    $_SESSION['userName'] = "Guest"; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Navbar with Yellow Background</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: yellow; 
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-warning fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../Images/images.png" alt="Logo" style="width: 150px;" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="LecturerPage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://gampaha.sliate.ac.lk/index.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://gampaha.sliate.ac.lk/contact.html">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://gampaha.sliate.ac.lk/about.html">About</a>
                    </li>
                </ul>
                <div class="dropdown">
                    <img src="../Images/profile-user.png" class="rounded-circle dropdown-toggle" style="width: 40px; cursor: pointer;" data-bs-toggle="dropdown" alt="User">
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="dropdown-item">
                            <img src="../Images/profile-user.png" alt="User" class="rounded-circle me-2" style="width: 30px;">
                            <strong><?php echo htmlspecialchars($_SESSION['userName']); ?></strong>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><img src="../Images/user-avatar.png" class="me-2" style="width: 20px;">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="#"><img src="../Images/setting.png" class="me-2" style="width: 20px;">Setting</a></li>
                        <li><a class="dropdown-item" href="#"><img src="../Images/help-web-button.png" class="me-2" style="width: 20px;">Help</a></li>
                        <li><a class="dropdown-item" href="Lecturer_login.php"><img src="../Images/logout.png" class="me-2" style="width: 20px;">Log Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
