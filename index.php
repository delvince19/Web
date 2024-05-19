<?php 
session_start();
include ("config.php");

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}

$student_id = $_SESSION['student_id']; 
$firstname = $_SESSION['firstname'];
$middlename = $_SESSION['middlename'];
$lastname = $_SESSION['lastname'];

$query = "SELECT profile_picture FROM tbl_users WHERE student_id = '$student_id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$profile_picture = $row['profile_picture'];

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    ?>
    <script>
        swal({
            title: "<?php echo $_SESSION['status']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>",
        });
    </script>
    <?php
    // Unset session variables after displaying the SweetAlert prompt
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-img-container {
            width: 60px;
            height: 60px;
            overflow: hidden;
            border-radius: 50%;
            border: 2px solid #fff;
            cursor: pointer;
            position: relative;
        }

        .profile-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #options {
            display: none;
            position: absolute;
            top: 70px;
            right: 0;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        #options a {
            display: block;
            padding: 10px;
            color: black;
            text-decoration: none;
        }

        #options a:hover {
            background-color: #f1f1f1;
        }

        .user-profile {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .user-profile img {
            width: 40px;
            height: 40%;
            border-radius: 50%;
            margin-left: 10px;
            cursor: pointer;
        }

        .user-profile h5 {
            margin-bottom: 0;
            margin-left: 10px;
        }

        .dropdown-menu {
            display: none;
        }

        .dropdown-visible {
            display: block !important;
        }
    </style>
</head>
<body>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="card-body1">
                                    <h5 class="card-title1">Task Tracker</h5>
                                </div>
                            </div>
                            <div class="col flex-row" style="display: flex; justify-content: right;">
                            <h5 class="card-title2"><?php echo "$firstname $middlename $lastname"; ?></h5>
                                <div class="user-profile">
                                <img src="<?php echo $profile_picture ?>" 
                                    title="<?php echo $firstname . ' ' . $middlename . ' ' . $lastname; ?>" 
                                    alt="<?php echo $firstname . ' ' . $middlename . ' ' . $lastname; ?>" 
                                    onclick="toggleDropdown()" 
                                    style="width: 75px; height: auto;">
                                    <div id="dropdownContainer" class="dropdown-menu" style="background-color: #fcb651">
                                        <ul class="proflogout mt-3 ">
                                            <li class="prof fw-bold"><a href="profile.php" style="color: #1a1851; font-size: 20px;">Profile</a></li>
                                            <li class="logout fw-bold"><a href="logout.php" style="color: #1a1851; font-size: 20px;">Logout</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="insert.php" style="float: right;" class="btn btn-primary">Add Task</a>
                    <table class="table datatable">
                        <thead class="trlist">
                        <tr style="align-items: 0;">
                            <th class="col">Task Title</th>
                            <th class="col">Task Description</th>
                            <th class="col">Priority</th>
                            <th class="col">Deadline</th>
                            <th class="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = "SELECT * FROM `tbl_tasklist` WHERE `student_id` = '$student_id'";
                        $query_run = mysqli_query($con, $query);
                        if(mysqli_num_rows($query_run) > 0)
                        {
                            foreach($query_run as $row)
                            {
                                ?>
                                <tr class="trlistsql">
                                    <td><?= $row['task_name']; ?></td>
                                    <td><b><?= $row['task_course']; ?></b></td>
                                    <td><?= ucfirst($row['priority']); ?></td>
                                    <td><?= $row['deadline']; ?></td>      
                                    <td>
                                       <input type="checkbox" id="markAsDone_<?= $row['id']; ?>" <?= $row['mark_as_done'] ? 'checked' : '' ?> onchange="markAsDone(<?= $row['id']; ?>)"> Mark as done
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                                <a type="button" class="btn btn-outline-primary" href="view.php?id=<?=$row['id'];?>">VIEW</a>
                                                <a type="button" class="btn btn-outline-warning" href="update.php?id=<?=$row['id'];?>">UPDATE</a>
                                                <form action="process.php" method="POST" style="display: inline;">
                                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                    <button name="delete" type="submit" class="btn btn-outline-danger">DELETE</button>
                                                </form>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>   
                                <?php
                            }
                        } else
                        {
                            ?>
                            <tr>
                                <td colspan="4">No Record Found</td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<script>
    function toggleDropdown() {
        var dropdownContainer = document.getElementById("dropdownContainer");
        dropdownContainer.classList.toggle("dropdown-visible");
    }

    window.onclick = function(event) {
        var dropdownContainer = document.getElementById("dropdownContainer");
        if (!event.target.closest('.user-profile')) {
            dropdownContainer.classList.remove("dropdown-visible");
        }
    }

    function markAsDone(taskId) {
        var isChecked = document.getElementById("markAsDone_" + taskId).checked;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_task_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader("X-HTTP-Method-Override", "PATCH"); // Simulate PATCH request
        xhr.send("id=" + taskId + "&mark_as_done=" + (isChecked ? 1 : 0));
    }
</script>
</body>
</html>
