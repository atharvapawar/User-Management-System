<?php
session_start();
include_once('../includes/config.php');

if (!isset($_SESSION['adminid']) || strlen($_SESSION['adminid']) == 0) {
    header('location:logout.php');
    exit();
}

if (isset($_POST['update'])) {
    $oldpassword = $_POST['currentpassword'];
    $newpassword = $_POST['newpassword'];
    $adminid = $_SESSION['adminid'];

    $stmt = $con->prepare("SELECT password FROM admin WHERE id = ?");
    $stmt->bind_param("i", $adminid);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    if (password_verify($oldpassword, $hashedPassword)) {

        $newHashedPassword = password_hash($newpassword, PASSWORD_BCRYPT);
        $updateStmt = $con->prepare("UPDATE admin SET password = ? WHERE id = ?");
        $updateStmt->bind_param("si", $newHashedPassword, $adminid);

        if ($updateStmt->execute()) {
            echo "<script>alert('Password Changed Successfully!');</script>";
        } else {
            echo "<script>alert('Password Change Failed. Please try again!');</script>";
        }
        $updateStmt->close();
    } else {
        echo "<script>alert('Old Password does not match!');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Change Password | User Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

    <script>
        function valid() {
            const newPassword = document.changepassword.newpassword.value;
            const confirmPassword = document.changepassword.confirmpassword.value;
            if (newPassword !== confirmPassword) {
                alert("Password and Confirm Password do not match!");
                document.changepassword.confirmpassword.focus();
                return false;
            }
            return true;
        }
        
        function goBack() {
            window.history.back();
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
                        <form method="post" name="changepassword" onsubmit="return valid();">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Current Password</th>
                                        <td><input class="form-control" id="currentpassword" name="currentpassword" type="password" required /></td>
                                    </tr>
                                    <tr>
                                        <th>New Password</th>
                                        <td><input class="form-control" id="newpassword" name="newpassword" type="password" required /></td>
                                    </tr>
                                    <tr>
                                        <th>Confirm Password</th>
                                        <td><input class="form-control" id="confirmpassword" name="confirmpassword" type="password" required /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block" name="update">Change</button>
                                            <button type="button" class="btn btn-secondary btn-block" onclick="goBack()">Back</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
            <?php include('../includes/footer.php'); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
</body>

</html>
