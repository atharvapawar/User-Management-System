<?php
include('includes/config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (isset($_POST['send'])) {
    $femail = mysqli_real_escape_string($con, trim($_POST['femail'])); // Sanitize input

    // Query to fetch user data based on email
    $row1 = mysqli_query($con, "SELECT email, password, fname FROM users WHERE email = '$femail'");
    $row2 = mysqli_fetch_array($row1);

    if ($row2) {
        $toemail = $row2['email'];
        $fname = $row2['fname'];
        $subject = "Information about your password";
        $password = $row2['password'];
        $message = "Your password is " . $password;

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your-gmail-id@gmail.com'; // Use environment variables here
        $mail->Password = 'your-gmail-password'; // Use environment variables here
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('your-gmail-id@gmail.com', 'Your Name');
        $mail->addAddress($toemail);
        $mail->isHTML(true);

        // Compose email content
        $bodyContent = "Dear " . $fname;
        $bodyContent .= "<p>" . $message . "</p>";
        $mail->Subject = $subject;
        $mail->Body = $bodyContent;

        if (!$mail->send()) {
            echo "<script>alert('Message could not be sent.');</script>";
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo "<script>alert('Your password has been sent successfully!');</script>";
        }
    } else {
        echo "<script>alert('Email is not registered with us.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Password Reset | User Management System</title>
    <link href="css/styles.css" rel="stylesheet" />
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
                                    <div class="small mb-3 text-muted">Enter your email address, and we will send you your password via email.</div>
                                    <form method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="femail" type="email" placeholder="name@example.com" required />
                                            <label for="inputEmail">Email address</label>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="login.php">Return to login</a>
                                            <button class="btn btn-primary" type="submit" name="send">Reset Password</button>
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