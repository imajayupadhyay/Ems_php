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
    overflow-y: auto;
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
.nav-item i{
    padding-right: 10px;
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
    <a class="nav-link <?= ($current_page == 'view_tasks.php') ? 'active' : '' ?>" href="view_tasks.php">
        <i class="bi bi-journal-text"></i> View Daily Tasks
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
<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#leavesMenu" role="button" aria-expanded="<?= ($current_page == 'manage_leaves.php' || $current_page == 'manage_leave_requests.php' || $current_page == 'employee_leaves_report.php') ? 'true' : 'false'; ?>" aria-controls="leavesMenu">
        <i class="bi bi-calendar"></i> Leaves
        <i class="bi bi-chevron-down"></i>
    </a>
    <div class="collapse <?= ($current_page == 'manage_leaves.php' || $current_page == 'manage_leave_requests.php' || $current_page == 'employee_leaves_report.php') ? 'show' : ''; ?>" id="leavesMenu">
        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'manage_leaves.php') ? 'active' : '' ?>" href="manage_leaves.php">
                    <i class="bi bi-calendar-check"></i> Manage Leaves
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'manage_leave_requests.php') ? 'active' : '' ?>" href="manage_leave_requests.php">
                    <i class="bi bi-calendar-check"></i> Leave Requests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'employee_leaves_report.php') ? 'active' : '' ?>" href="employee_leaves_report.php">
                    <i class="bi bi-calendar-check"></i> Employee Leaves
                </a>
            </li>
        </ul>
    </div>
</li>


<!-- <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'manage_leaves.php') ? 'active' : '' ?>" href="manage_leaves.php">
                <i class="bi bi-calendar-check"></i> Manage Leaves
            </a>
        </li>
        <li class="nav-item">
    <a class="nav-link <?= ($current_page == 'manage_leave_requests.php') ? 'active' : '' ?>" href="manage_leave_requests.php">
        <i class="bi bi-calendar-check"></i>Leave Requests
    </a>
</li>
<li class="nav-item">
    <a class="nav-link <?= ($current_page == 'employee_leaves_report.php') ? 'active' : '' ?>" href="employee_leaves_report.php">
        <i class="bi bi-calendar-check"></i> Employee Leaves
    </a>
</li> -->


        <li class="nav-item bg-danger mt-5">
            <a class="nav-link text-white" href="logout.php">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>
</div>
<!-- Bootstrap JS (required for dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
