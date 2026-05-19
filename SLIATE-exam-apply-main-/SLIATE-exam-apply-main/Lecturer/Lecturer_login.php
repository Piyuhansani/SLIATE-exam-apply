<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Login</title>
    <!-- Bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {background-color:#ffe100;}
       form,.card {background-color: #f0ff7f;}
    </style>
</head>

<body class=" d-flex justify-content-center align-items-center" style="height: 100vh;"> 

    <!-- Lecturer login container -->
    <div class="card p-4 shadow-lg text-center" style="width: 100%; max-width: 400px;">
        <h2 class="fw-bold mb-4">Lecturer Login</h2>
        <form method="POST" action="register.php">
            <div class="mb-3">
                <!-- Input Registration Number field -->
                <label for="regNumber" class="form-label">Registration Number</label>
                <input type="text" id="regNumber" name="regNumber" class="form-control" placeholder="Enter your Registration Number" required>
            </div>
            <!-- Input password field -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your Password" required>
            </div>
            <!-- Buttons -->
            <div class="d-grid">
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
            </div>
            <p class="mt-3">
                Forget Password? <a href="froget_pwd.php" class="text-decoration-none">Change Password</a>
            </p>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
