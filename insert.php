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

<h1 class="text-center">Task Tracking System</h1>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <form action="process.php" method="POST" autocomplete="off">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="task_name" class="form-label">Task Name</label>
                        <input type="text" placeholder="Enter Student ID" class="form-control" name="task_name">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="task_course" class="form-label">Course</label>
                        <input type="text" placeholder="Course" class="form-control" name="task_course">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="priority" class="form-label">Priority Level</label>
                        <select class="form-control" name="priority">
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" placeholder="Input Deadline" class="form-control" name="deadline">
                    </div>

                    <div class="col-md-12 mb-3 text-center">
                        <button type="submit" class="btn btn-primary"  style="float: right;" name="submitButton">Submit</button>
                        <button type="back" class="btn btn-danger" name="backButton" style="float: left;">Back</button>
                    </div> 
                </div>
            </form>
        </div>
    </div>
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
