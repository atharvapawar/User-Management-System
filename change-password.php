<?php
session_start();
include_once('includes/config.php');

// Redirect if the user is not logged in
if (strlen($_SESSION['id'] == 0)) {
    header('location:logout.php');
} else {
    // Code for updating password
    if (isset($_POST['update'])) {
        // Get user input
        $oldpassword = $_POST['currentpassword'];
        $newpassword = $_POST['newpassword'];
        $confirmpassword = $_POST['confirmpassword'];

        // Ensure passwords match
        if ($newpassword !== $confirmpassword) {
            echo "<script>alert('New Password and Confirm Password do not match!');</script>";
            exit;
        }

        // Check if old password is correct
        $userid = $_SESSION['id'];
        $stmt = $con->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify the old password
        if ($user && password_verify($oldpassword, $user['password'])) {
            // Hash the new password before updating
            $newpasswordHash = password_hash($newpassword, PASSWORD_BCRYPT);

            // Update password in the database
            $updateStmt = $con->prepare("UPDATE users SET password = ? WHERE id = ?");
            $updateStmt->bind_param("si", $newpasswordHash, $userid);
            if ($updateStmt->execute()) {
                echo "<script>alert('Password Changed Successfully!');</script>";
                echo "<script type='text/javascript'> document.location = 'change-password.php'; </script>";
            } else {
                echo "<script>alert('An error occurred. Please try again later.');</script>";
            }
        } else {
            echo "<script>alert('Old Password does not match!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Change Password | User Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script language="javascript" type="text/javascript">
        function valid() {
            if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
                alert("Password and Confirm Password do not match!");
                document.changepassword.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
</head>

<body class="sb-nav-fixed">
    <?php include_once('includes/navbar.php'); ?>
    <div id="layoutSidenav">
        <?php include_once('includes/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Change Password</h1>
                    <div class="card mb-4">
                        <form method="post" name="changepassword" onSubmit="return valid();">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="currentpassword" class="form-label">Current Password</label>
                                    <input class="form-control" id="currentpassword" name="currentpassword" type="password" required />
                                </div>
                                <div class="mb-3">
                                    <label for="newpassword" class="form-label">New Password</label>
                                    <input class="form-control" id="newpassword" name="newpassword" type="password" required />
                                </div>
                                <div class="mb-3">
                                    <label for="confirmpassword" class="form-label">Confirm Password</label>
                                    <input class="form-control" id="confirmpassword" name="confirmpassword" type="password" required />
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary" name="update">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <a href="welcome.php" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </main>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>