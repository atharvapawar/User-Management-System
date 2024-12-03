<?php
session_set_cookie_params([
    'httponly' => true,
    'secure' => isset($_SERVER['HTTPS']),
    'samesite' => 'Strict',
]);
session_start();
include_once('../includes/config.php');

if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}

if (isset($_POST['login'])) {
    $adminusername = $_POST['username'];
    $input_password = $_POST['password'];

    $stmt = $con->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $adminusername);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($admin_id, $db_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();

        if (password_verify($input_password, $db_password)) {
            $_SESSION['login'] = $adminusername;
            $_SESSION['adminid'] = $admin_id;
            header("Location: dashboard.php");
            exit();
        } elseif ($input_password === $db_password) {
            // Rehash and update the database with password_hash (bcrypt)
            $hashed_password = password_hash($input_password, PASSWORD_DEFAULT);
            $update_stmt = $con->prepare("UPDATE admin SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $hashed_password, $admin_id);
            $update_stmt->execute();

            $_SESSION['login'] = $adminusername;
            $_SESSION['adminid'] = $admin_id;
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = 'Invalid username or password';
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = 'Invalid username or password';
        header("Location: index.php");
        exit();
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
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Login | User Management System</title>
    <link href="../css/styles.css" rel="stylesheet" />
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
                                    <h3 class="text-center font-weight-light my-4">Admin Login</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="username" type="text" placeholder="Username" required />
                                            <label for="inputEmail">Username</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="password" type="password" placeholder="Password" required />
                                            <label for="inputPassword">Password</label>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password-recovery.php">Forgot Password?</a>
                                            <button class="btn btn-primary" name="login" type="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="../index.php">Back to Home Page</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?php include('../includes/footer.php'); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
</body>

</html>