<?php
include "../includes/config.php";
include "../includes/session.php";

// Ensure only admins can access
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all employees for the dropdown
$employees = $conn->query("SELECT id, first_name, last_name FROM employees");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Attendance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/attendance.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for AJAX -->
    <style>
        .working-days{
    border-radius: 20px;
    text-align: center;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include "sidebar.php"; ?>

        <div class="main-content">
            <h2 class="mb-4">Attendance Report</h2>

            <!-- Filters for Employee, Month & Date -->
            <form id="filterForm" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <label for="employee">Select Employee:</label>
                        <select name="employee_id" id="employee" class="form-control">
                            <option value="">-- All Employees --</option>
                            <?php while ($row = $employees->fetch_assoc()) { ?>
                                <option value="<?= $row['id']; ?>">
                                    <?= $row['first_name'] . " " . $row['last_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="month">Select Month:</label>
                        <input type="month" name="month" id="month" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="date">Select Date:</label>
                        <input type="date" name="date" id="date" class="form-control">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>

            <!-- Total Working Days Container -->
            <div class="container m-3 p-3 bg-primary text-white working-days" id="workingDaysContainer" style="display: none;">
                <h5><strong>Total Working Days:</strong> <span id="totalWorkingDays">0</span></h5>
            </div>

            <!-- Attendance Table -->
            <div id="attendanceTable">
                <h4>Attendance Records</h4>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Date</th>
                            <th>Punch In</th>
                            <th>Punch Out</th>
                            <th>Worked Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="5" class="text-center">Select filters to view attendance.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#filterForm").submit(function (e) {
                e.preventDefault(); // Prevent page reload

                var employee_id = $("#employee").val();
                var month = $("#month").val();
                var date = $("#date").val();

                // Check if a specific date is selected, then ignore the month
                if (date) {
                    month = ''; // Reset month filter if date is selected
                }

                $.ajax({
                    url: "fetch_attendance.php",
                    type: "POST",
                    data: { employee_id: employee_id, month: month, date: date },
                    dataType: "json",
                    success: function (response) {
                        // Update Attendance Table
                        $("#attendanceTable").html(response.attendanceTable);

                        // Update Total Working Days
                        if (response.totalWorkingDays !== undefined && employee_id && month) {
                            $("#totalWorkingDays").text(response.totalWorkingDays);
                            $("#workingDaysContainer").show();
                        } else {
                            $("#workingDaysContainer").hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>
