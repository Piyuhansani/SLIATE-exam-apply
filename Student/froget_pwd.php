<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Your Password</title>
   
    <!-- CSS link -->
    <link rel="stylesheet" href="../style.css">

</head>
<body>

<div class="container">
        <div class="form-box">
            <div class="icon-container">
                <img src="../Images/padlock.png" alt="Lock Icon">
            </div>
            <h2>Forgot Your Password?</h2>
            <form action="../send-password-reset.php" method="post">
                <label for="email">Enter Your Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your Email" required>
                <div class="button-container">
                     <button type="button" onclick="window.location.href='login.php'" class="button" id="fg_pw_back_btn">Back</button>
                     <button type="submit" class="button" id="fg_pw_continue_btn">Continue</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
