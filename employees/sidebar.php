<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get current file name
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        .sidebar {
            width: 250px;
            background: #05386b;
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
        }

        .sidebar ul {
            padding-left: 0;
        }

        .sidebar .nav-link {
            color: white;
            padding: 12px;
            display: block;
            transition: 0.3s;
            font-size: 16px;
            padding: 17px 20px;
        }

        i {
            margin-right: 10px;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgb(255, 255, 255);
            color: black;
            text-decoration: none;
        }
        body {
    background-color: #f8f9fa;
}
h1,h2,h3,h4,h5,h6,p,li {
  font-family: "Poppins", serif;
  font-weight: 400;
  font-style: normal;
}
.wrapper {
    display: flex;
    height: 100vh;
}

.main-content {
    margin-left: 250px;
    width: 100%;
    padding: 20px;
}

.card {
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.btn {
    border-radius: 8px;
    font-weight: bold;
}

    </style>
</head>
<body>
<div class="sidebar">
    <h4 class="text-center bg-primary text-white mt-3 mb-3 p-3">Dashboard</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php">
                <i class="bi bi-house-door"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'attendance.php') ? 'active' : '' ?>" href="attendance.php">
                <i class="bi bi-clock"></i> Attendance
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'tasks.php') ? 'active' : '' ?>" href="tasks.php">
                <i class="bi bi-list-check"></i> My Tasks
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'assign_task.php') ? 'active' : '' ?>" href="assign_task.php">
                <i class="bi bi-person-plus"></i> Assign Task
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'assigned_tasks.php') ? 'active' : '' ?>" href="assigned_tasks.php">
                <i class="bi bi-person-lines-fill"></i> Assigned Tasks
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'punch.php') ? 'active' : '' ?>" href="punch.php">
                <i class="bi bi-geo-alt"></i> Punch In/Out
            </a>
        </li>
        <li class="nav-item">
    <a class="nav-link <?= ($current_page == 'apply_leave.php') ? 'active' : '' ?>" href="apply_leave.php">
        <i class="bi bi-calendar-plus"></i> Apply for Leave
    </a>
</li>

        <li class="nav-item bg-danger mt-5 ">
            <a class="nav-link text-white" <?= ($current_page == 'logout.php') ? 'active' : '' ?>" href="logout.php">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>
</div>
</body>
</html>
