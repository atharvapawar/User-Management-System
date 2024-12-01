<?php
session_start();
include_once('../includes/config.php');

if (!isset($_SESSION['adminid']) || strlen($_SESSION['adminid']) == 0) {
    header('location:logout.php');
    exit();
}

if (isset($_GET['id'])) {
    $adminid = intval($_GET['id']);
    $stmt = $con->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $adminid);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully');</script>";
    } else {
        echo "<script>alert('Failed to delete user');</script>";
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
    <title>B/w Dates Report Result | User Management System</title>
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
                    <h1 class="mt-4">B/w Dates Report Result</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">B/w Dates Report Result</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header text-center" style="font-size:20px;">
                            <i class="fas fa-table me-1"></i>
                            <?php
                            $fdate = $_POST['fromdate'];
                            $tdate = $_POST['todate'];
                            echo "Report from " . date("d-m-Y", strtotime($fdate)) . " to " . date("d-m-Y", strtotime($tdate));
                            ?>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sno.</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email Id</th>
                                        <th>Contact No.</th>
                                        <th>Reg. Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $con->prepare("SELECT * FROM users WHERE DATE(posting_date) BETWEEN ? AND ?");
                                    $stmt->bind_param("ss", $fdate, $tdate);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $cnt = 1;

                                    while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo htmlspecialchars($row['fname']); ?></td>
                                            <td><?php echo htmlspecialchars($row['lname']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['contactno']); ?></td>
                                            <td><?php echo htmlspecialchars($row['posting_date']); ?></td>
                                            <td>
                                                <a href="user-profile.php?uid=<?php echo $row['id']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="manage-users.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Do you really want to delete this user?');">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php $cnt++;
                                    } ?>
                                    <?php $stmt->close(); ?>
                                </tbody>
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>