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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/admin.css" rel="stylesheet"> <!-- Admin Panel CSS -->
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap");

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
}

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

.sidebar .nav-link:hover, .sidebar .nav-link.active {
    background: rgb(255, 255, 255);
    color: black;
    text-decoration: none;
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
    <h4 class="text-center bg-primary text-white mt-3 mb-3 p-3">Admin Panel</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'manage_employees.php') ? 'active' : '' ?>" href="manage_employees.php">
                <i class="bi bi-people"></i> Manage Employees
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'manage_tasks.php') ? 'active' : '' ?>" href="manage_tasks.php">
                <i class="bi bi-list-task"></i> Manage Tasks
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'attendance_report.php') ? 'active' : '' ?>" href="attendance_report.php">
                <i class="bi bi-clock-history"></i> Attendance Report
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'department.php') ? 'active' : '' ?>" href="department.php">
                <i class="bi bi-arrow-right-circle"></i> Departments
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'designation.php') ? 'active' : '' ?>" href="designation.php">
                <i class="bi bi-arrow-right-circle"></i> Designations
            </a>
        </li>
        <li class="nav-item">
    <a class="nav-link" href="manage_ips.php">
        <i class="bi bi-globe"></i> Manage Employee IPs
    </a>
</li>
        <li class="nav-item bg-danger mt-5">
            <a class="nav-link text-white" href="logout.php">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>
</div>
</body>
</html>
