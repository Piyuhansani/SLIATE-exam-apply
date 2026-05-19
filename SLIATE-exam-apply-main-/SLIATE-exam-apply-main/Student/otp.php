<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    

<style>
    
body {
    font-family: Arial, sans-serif;
    background-color: #ece000;
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

p {
    font-size: 16px;
    color: #555;
}

.otp-input {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
}

.otp-input input {
    width: 50px;
    height: 50px;
    font-size: 24px;
    text-align: center;
    border: 2px solid #ccc;
    border-radius: 5px;
    transition: border 0.3s ease;
}

.otp-input input:focus {
    border-color: #007bff;
    outline: none;
}

button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
}

button:hover {
    background-color: #0056b3;
}

.resend {
    font-size: 14px;
    margin-top: 15px;
}

.resend a {
    color: #007bff;
    text-decoration: none;
}

.resend a:hover {
    text-decoration: underline;
}

</style>

    </script>



</head>
<body>

    <div class="container">
        <h2>OTP Verification</h2>
        <p>Enter OTP code sent to <span id="email">a*****@gmail.com</span></p>
        
        <div class="otp-input">
            <input type="text" id="otp1" maxlength="1" oninput="moveFocus(this, 'otp2')">
            <input type="text" id="otp2" maxlength="1" oninput="moveFocus(this, 'otp3')">
            <input type="text" id="otp3" maxlength="1" oninput="moveFocus(this, 'otp4')">
            <input type="text" id="otp4" maxlength="1">
        </div>

        <p class="resend">
            Didn't receive OTP Code? <a href="#" onclick="resendOtp()">Resend Code</a>
        </p>

        <button onclick="verifyOtp()">Verify</button>
    </div>

    <script src="script.js"></script>

</body>
</html>