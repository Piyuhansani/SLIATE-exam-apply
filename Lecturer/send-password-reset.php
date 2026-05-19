<?php

// Get the email address from the POST request
$email = $_POST["email"];

// Generate a random token
$token = bin2hex(random_bytes(16));

// Hash the token using SHA-256
$token_hash = hash("sha256", $token);

// Set the expiry time for the token (15 minutes from now)
$expiry = date("Y-m-d H:i:s", time() + 60 * 15);

// Connect to the database
$conn = require __DIR__ . "/../DBConnection/connect.php";

// Prepare SQL statement to update the user's reset token and its expiry time
$sql = "UPDATE lecturer
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Bind the token hash, expiry time, and email parameters to the SQL statement
$stmt->bind_param("sss", $token_hash, $expiry, $email);

// Execute the SQL statement
$stmt->execute();

// Check if any rows were affected (i.e., if the email address exists in the database)
if ($conn->affected_rows){
    // Include the mailer configuration
    $mail = require __DIR__ . "/mailer.php";

    // Set the email details
    $mail->setFrom("noreply@example.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END

    Click <a href="http://localhost:8080/SLIATE-exam-apply/Lecturer/reset-password.php?token=$token">here</a> 
    to reset your password.

    END;

    try {
        // Attempt to send the email
        $mail->send();
        // Redirect to a success page if the email was sent successfully
        header("Location: sent_mail_successful.php");
        exit;

    } catch (Exception $e) {
        // If the email could not be sent, display an error message
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
    }
}

// Display an alert if the email could not be found or the email could not be sent
echo '<script>
                alert("Mail could not be sent. Invalid Email!");
                window.location.href = "froget_pwd.php";
 </script>';
