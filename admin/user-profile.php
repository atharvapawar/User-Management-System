<?php
session_start();
include_once('../includes/config.php');

if (!isset($_SESSION['adminid']) || strlen($_SESSION['adminid']) == 0) {
    header('location:logout.php');
    exit();
} else {
    $userid = isset($_GET['uid']) ? mysqli_real_escape_string($con, $_GET['uid']) : null;

    if ($userid) {
        $query = mysqli_query($con, "SELECT * FROM users WHERE id = '$userid'");

        if (mysqli_num_rows($query) > 0) {
            $result = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php echo htmlspecialchars($result['fname']); ?>'s Profile | User Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include_once('includes/navbar.php'); ?>
    <div id="layoutSidenav">
        <?php include_once('includes/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?php echo htmlspecialchars($result['fname']); ?>'s Profile</h1>
                    <div class="card mb-4">
                        <div class="card-body">
                            <a href="edit-profile.php?uid=<?php echo $result['id']; ?>" class="btn btn-primary">Edit Profile</a>
                            <table class="table table-bordered mt-3">
                                <tr>
                                    <th>First Name</th>
                                    <td><?php echo htmlspecialchars($result['fname']); ?></td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td><?php echo htmlspecialchars($result['lname']); ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td colspan="3"><?php echo htmlspecialchars($result['email']); ?></td>
                                </tr>
                                <tr>
                                    <th>Contact No.</th>
                                    <td colspan="3"><?php echo htmlspecialchars($result['contactno']); ?></td>
                                </tr>
                                <tr>
                                    <th>Reg. Date</th>
                                    <td colspan="3"><?php echo htmlspecialchars($result['posting_date']); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include('../includes/footer.php'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>
<?php 
        } else {
            echo "<script>alert('User not found.'); window.location.href='manage-users.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid user ID.'); window.location.href='manage-users.php';</script>";
    }
} 
?>
