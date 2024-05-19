<?php session_start();
include ("config.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1 class="text-center">View Task</h1>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">

        <?php
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $users = "SELECT * FROM `tbl_tasklist` WHERE `id` = '$id'";
            $users_run = mysqli_query($con, $users);

            if(mysqli_num_rows($users_run) > 0)
            {
                foreach($users_run as $user)
                {
                ?>

            <form action="process.php" method="POST">

            <input type="hidden" name="id" value="<?=$user['id'];?>">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="task_name" class="form-label">Task Name</label>
                        <input type="text" class="form-control" id="task_name" value="<?=$user['task_name'];?>" name="task_name" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="task_course" class="form-label">Task Description</label>
                        <input type="text" class="form-control" id="task_course" value="<?=$user['task_course'];?>" name="task_course" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="text" class="form-control" id="deadline" value="<?=$user['deadline'];?>" name="deadline">
                    </div>

                    <div class="col-md-12 mb-3 text-center">
                        <button type="back" class="btn btn-danger" name="backButton" style="float: left;">Back</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
                }
            }
            else
            {
                ?>
                <h4>No Record Found!</h4>
                <?php
            }
        }
?>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
if (isset($_SESSION['status']) && $_SESSION['status_code'] != '' )
{
    ?>
    <script>
        swal({
            title: "<?php echo $_SESSION['status']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>",
        });
    </script>
    <?php
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>
</body>
</html>
