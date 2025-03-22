<?php
include "../includes/config.php";
include "../includes/session.php";

// Ensure only admins can access
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all employees
$employees_query = "SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM employees ORDER BY first_name";
$employees_result = $conn->query($employees_query);

// Fetch all leave types
$leave_types_query = "SELECT id, name FROM leave_types ORDER BY name";
$leave_types_result = $conn->query($leave_types_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Leave Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .card { box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); border-radius: 10px; }
        .btn { border-radius: 8px; font-weight: bold; }
        .filter-section { display: flex; gap: 10px; align-items: center; }
    </style>
</head>
<body>
<div class="wrapper">
    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <h3 class="text-center">Employee Leave Report</h3>

    <!-- Filter Options -->
    <div class="card p-4 mt-3">
        <h5>Filter Leave Records</h5>
        <div class="filter-section">
            <select id="employee_filter" class="form-control">
                <option value="">All Employees</option>
                <?php while ($emp = $employees_result->fetch_assoc()) { ?>
                    <option value="<?= $emp['id'] ?>"><?= $emp['name'] ?></option>
                <?php } ?>
            </select>

            <select id="leave_type_filter" class="form-control">
                <option value="">All Leave Types</option>
                <?php while ($leave = $leave_types_result->fetch_assoc()) { ?>
                    <option value="<?= $leave['id'] ?>"><?= $leave['name'] ?></option>
                <?php } ?>
            </select>

            <input type="month" id="month_filter" class="form-control">

            <button id="filterBtn" class="btn btn-primary">Filter</button>
        </div>
    </div>

    <!-- Leave Report Table -->
    <div class="card p-4 mt-3">
        <h5>Leave Records</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Total Days</th>
                </tr>
            </thead>
            <tbody id="leaveRecords">
                <tr><td colspan="6" class="text-center">Select filters and click "Filter" to see records.</td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- jQuery & AJAX Script -->
<script>
$(document).ready(function () {
    $("#filterBtn").click(function () {
        var employee_id = $("#employee_filter").val();
        var leave_type_id = $("#leave_type_filter").val();
        var month = $("#month_filter").val();

        $.ajax({
            url: "ajax_employee_leaves_report.php",
            type: "POST",
            data: { employee_id: employee_id, leave_type_id: leave_type_id, month: month },
            success: function (response) {
                $("#leaveRecords").html(response);
            }
        });
    });
});
</script>

</body>
</html>
