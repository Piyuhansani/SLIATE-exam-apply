<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <link rel="stylesheet" href="styles.css">

<style>
    /* General Body Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #ece000;
    ;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 100%;
    max-width: 400px;
}

h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

.icon-container img {
    width: 40px;
    height: 40px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 14px;
    color: #555;
    margin-bottom: 5px;
}

.form-group input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: rgb(228, 227, 227);
}

.form-group input:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.button-container {
    display: flex;
    justify-content: space-between;
}

button {
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    width: 45%;
}

button[type="button"] {
    background-color: #007bff;
    color: white;
    border: none;
}

button[type="button"]:hover {
    background-color: #0056b3;
}

button[type="submit"] {
    background-color: #007bff;
    color: white;
    border: none;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

#passwordError {
    margin-top: 5px;
    color: red;
    font-size: 0.9rem;
}
</style>

</head>
<body>

    <div class="container">
    <div class="icon-container">
            <img src="Images/open-padlock.png" alt="Lock Icon">
        </div>
        
        <h2>Reset Your Password</h2>
        

        <form action="" method="POST">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" placeholder="Enter New Password" required>
            </div>

            <div class="form-group">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmpassword" placeholder="Confirm Your Password" onkeyup="validatePasswords()" required>
                <span id="passwordError" style="color: red; font-size: 0.9rem;"></span>
            </div>

            <div class="button-container">
                <button type="button" onclick="window.location.href='Student/login.php'">Back</button>
                <button type="submit">Done</button>
            </div>
        </form>
    </div>

<script src="script.js"></script>

</body>
</html>
