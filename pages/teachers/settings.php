<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['teacher_role'])) {
    include '../../data/admin_operations.php';
    include '../../controls/connection.php';
    $username = $_SESSION['username'];
    $sql = "SELECT nic FROM user_tbl WHERE username='$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $sql2 = "SELECT staff_id FROM staff_tbl WHERE nic='" . $row['nic'] . "'";
    $result2 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $teacher = getTeacherById($row2['staff_id'], $con);
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="shortcut icon"
            href="https://img.freepik.com/free-vector/hand-drawn-high-school-logo-template_23-2149689290.jpg?w=900&t=st=1694450465~exp=1694451065~hmac=7a936b09b3a1b26e48c21cff671f711ffc7577f0e79a5b62864237f7f0f81168"
            type="image/x-icon">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Settings - Teacger Portal</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="../../js/jquery-3.6.3.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body class="sb-nav-fixed">

        <?php include '../top-navbar.php'; ?>
        <?php include 'left-side-bar.php'; ?>

        <div id="layoutSidenav_content">

            <!-- content goes here. do not remove any code -->
            <div class="container-fluid">
                <h1 class="mt-4">Settings</h1>
                <?php if (isset($_GET['success'])) { ?>
                    <!-- <div class='alert alert-success' role='alert'>
                            <?= $_GET['success'] ?>
                        </div> -->

                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Done',
                            text: "<?= $_GET['success'] ?>"
                        })
                    </script>
                <?php } ?>

                <?php if (isset($_GET['error'])) { ?>
                    <!-- <div class='alert alert-danger' role='alert'>
                            <?= $_GET['error'] ?>
                        </div> -->

                    <script>
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: "<?= $_GET['error'] ?>"
                        })
                    </script>
                <?php } ?>
                <!-- Your further code goes here. keep coding in this div -->
                <div class="container mt-3">
                    <form
                        action="../../data/change-teacher-password.php?id=<?= $teacher['staff_id'] ?>&nic=<?= $teacher['nic'] ?>"
                        method="post" class="shadow p-3  mt-5 form-w">
                        <h3>Change Password</h3>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" readonly value="<?= $_SESSION['username'] ?>"
                                autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Old Password</label>
                            <input type="password" name="old_pwd" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Passowrd</label>
                            <div class="input-group mb-3">
                                <input type="text" name="new_pwd" class="form-control" id="passInput" required>
                                <button class="btn btn-secondary" id="gBTN">Random</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="c_new_pwd" class="form-control" autocomplete="off" required>
                        </div>
                        <button type="submit" class="btn btn-warning" name="change_pwd">Change</button>
                    </form>
                </div><br />


                <script src="../../bootstrap/js/bootstrap.bundle.js"></script>

            </div>

            <!-- footer -->
            <?php include '../footer.php'; ?>
        </div>
        </div>

        <!-- content goes here -->
        <script src="../js/scripts.js"></script>
        <script>
            var gBTN = document.getElementById('gBTN');
            gBTN.addEventListener('click', function (e) {
                e.preventDefault();
                makePass(5)
            });

            function makePass(length) {
                let result = '';
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                const charactersLength = characters.length;
                let counter = 0;
                while (counter < length) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                    counter += 1;
                }

                passInput.value = result;
            }
        </script>
    </body>

    </html>

<?php } else {
    header("Location:../../login.php");
    exit;
}
?>