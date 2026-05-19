
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Your Password</title>
   
    <!-- Bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {background-color:#ffe100;}
       form,.card {background-color: #f0ff7f;}
    </style>
</head>
<body class="bg-warning.bg-gradient d-flex justify-content-center align-items-center" style="height: 100vh;"> 

    <div class="container text-center">
        <div class="card p-4 shadow-lg mx-auto" style="max-width: 400px;">
            <!-- Icon container with a lock icon image -->
            <div class="mb-4">
                <img src="../Images/padlock.png" alt="Lock Icon" class="img-fluid" style="width: 50px; height: 50px;">
            </div>
            <h2 class="fw-bold mb-4">Forgot Your Password?</h2>
            <!-- Form for password reset -->
            <form action="send-password-reset.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Enter Your Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your Email" required>
                </div>
                <!-- Buttons container -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" onclick="window.location.href='admin_login.php'" class="btn btn-secondary">Back</button>
                    <button type="submit" class="btn btn-primary">Continue</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>














