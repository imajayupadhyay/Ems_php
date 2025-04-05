<?php
include "../includes/config.php";
include "../includes/session.php";

// Ensure only admins can access
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch employees for dropdown
$employees = $conn->query("SELECT id, first_name, last_name FROM employees");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Daily Tasks</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        .card {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .btn {
            border-radius: 8px;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
</head>
<body>

<div class="wrapper">
    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <h3 class="mb-4">Employee Daily Tasks</h3>

        <!-- Filter Form -->
        <form id="taskFilterForm" class="card p-4 mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="employee_id">Employee</label>
                    <select name="employee_id" id="employee_id" class="form-control">
                        <option value="">-- All Employees --</option>
                        <?php while ($row = $employees->fetch_assoc()) { ?>
                            <option value="<?= $row['id']; ?>"><?= $row['first_name'] . " " . $row['last_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="task_date">Task Date</label>
                    <input type="date" name="task_date" id="task_date" class="form-control">
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <!-- Task List Table -->
        <div id="taskTable">
            <div class="alert alert-info text-center">Please apply filter to view tasks.</div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
$(document).ready(function () {
    $("#taskFilterForm").submit(function (e) {
        e.preventDefault();

        var employee_id = $("#employee_id").val();
        var task_date = $("#task_date").val();

        $.ajax({
            url: "ajax_fetch_tasks.php",
            type: "POST",
            data: {
                employee_id: employee_id,
                task_date: task_date
            },
            success: function (response) {
                $("#taskTable").html(response);
            },
            error: function () {
                alert("Something went wrong while fetching tasks.");
            }
        });
    });
});
</script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
