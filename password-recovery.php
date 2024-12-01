<?php
// Start the session and include configuration
session_start();
include('includes/config.php');

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Handle form submission
if (isset($_POST['send'])) {
    $femail = mysqli_real_escape_string($con, trim($_POST['femail'])); // Sanitize user input

    // Query to check if the email exists
    $query = "SELECT email, password, fname FROM users WHERE email = '$femail'";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_array($result);

    if ($user) {
        $toemail = $user['email'];
        $fname = $user['fname'];
        $password = $user['password'];
        $subject = "Password Recovery";
        $message = "Dear $fname,<br>Your password is: <strong>$password</strong>";

        // Initialize PHPMailer
        $mail = new PHPMailer;
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USER');  // Secure with environment variable
            $mail->Password = getenv('SMTP_PASS');  // Secure with environment variable
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('your-gmail-id@gmail.com', 'Your Company');
            $mail->addAddress($toemail);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Attempt to send the email
            if (!$mail->send()) {
                echo "<script>alert('Message could not be sent.');</script>";
                error_log('Mailer Error: ' . $mail->ErrorInfo); // Log the error for debugging
            } else {
                echo "<script>alert('Your password has been sent successfully!');</script>";
            }
        } catch (Exception $e) {
            error_log("Mailer Exception: {$e->getMessage()}"); // Log any exceptions
            echo "<script>alert('Failed to send email. Please try again later.');</script>";
        }
    } else {
        echo "<script>alert('Email is not registered with us.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery | User Management System</title>
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Password Recovery</h3>
                                </div>
                                <div class="card-body">
                                    <div class="small mb-3 text-muted">Enter your email address, and we will send your password.</div>
                                    <form method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="femail" type="email" placeholder="name@example.com" required>
                                            <label for="femail">Email address</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="login.php">Return to login</a>
                                            <button class="btn btn-primary" type="submit" name="send">Send Email</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="signup.php">Need an account? Sign up!</a></div>
                                    <div class="small"><a href="index.php">Back to Home</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?php include('includes/footer.php'); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>