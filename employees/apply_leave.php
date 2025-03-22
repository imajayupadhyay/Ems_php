<?php
include "../includes/session.php";
include "../includes/config.php";

$employee_id = $_SESSION['employee_id'];

// Fetch available leave types
$leave_types_query = "SELECT lt.id, lt.name, lt.number_of_days, 
                      (SELECT IFNULL(SUM(DATEDIFF(el.end_date, el.start_date) + 1), 0) 
                       FROM employee_leaves el WHERE el.leave_type_id = lt.id 
                       AND el.employee_id = '$employee_id' AND el.status = 'Approved') 
                      AS used_leaves 
                      FROM leave_types lt";
$leave_types_result = $conn->query($leave_types_query);

// Fetch applied leaves history
$applied_leaves_query = "SELECT el.*, lt.name AS leave_type FROM employee_leaves el 
                         JOIN leave_types lt ON el.leave_type_id = lt.id 
                         WHERE el.employee_id = '$employee_id' 
                         ORDER BY el.created_at DESC";
$applied_leaves_result = $conn->query($applied_leaves_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Apply for Leave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .card { box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); border-radius: 10px; }
        .btn { border-radius: 8px; font-weight: bold; }
        .table { background: white; border-radius: 8px; }
        .highlight { color: red; font-weight: bold; }
        .navbar {
            background-color: #05386b;
            margin: 0px;
            border-radius: 25px;
        }
        .navbar-brand {
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <nav class="navbar px-3 mb-3">
                <a class="navbar-brand p-2">Apply for Leave</a>
            </nav>
        <!-- Available Leaves -->
        <div class="card p-4 mt-3">
            <h5>Available Leaves</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Leave Type</th>
                        <th>Total Days</th>
                        <th>Used Days</th>
                        <th>Remaining Days</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $leave_types_result->fetch_assoc()) { 
                        $remaining_days = $row['number_of_days'] - $row['used_leaves'];
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= $row['number_of_days'] ?> days</td>
                            <td><?= $row['used_leaves'] ?> days</td>
                            <td class="<?= $remaining_days <= 0 ? 'highlight' : '' ?>">
                                <?= max(0, $remaining_days) ?> days
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Apply for Leave Form -->
        <div class="card p-4 mt-3">
            <h5>Apply for Leave</h5>
            <form id="applyLeaveForm">
                <select name="leave_type_id" id="leave_type_id" class="form-control mb-2" required>
                    <option value="">Select Leave Type</option>
                    <?php
                    $leave_types_result->data_seek(0); // Reset the result set pointer
                    while ($row = $leave_types_result->fetch_assoc()) { ?>
                        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                    <?php } ?>
                </select>
                <input type="date" name="start_date" id="start_date" class="form-control mb-2" required>
                <input type="date" name="end_date" id="end_date" class="form-control mb-2" required>
                <textarea name="reason" id="reason" class="form-control mb-2" placeholder="Enter reason for leave" required></textarea>
                <button type="submit" class="btn btn-primary">Submit Leave Request</button>
            </form>
        </div>

   <!-- Leave Application History -->
<div class="card p-4 mt-3">
    <h5>Your Leave Applications</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Reason</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $applied_leaves_result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['leave_type']) ?></td>
                    <td><?= $row['start_date'] ?></td>
                    <td><?= $row['end_date'] ?></td>
                    <td>
                        <span class="badge bg-<?= $row['status'] == 'Approved' ? 'success' : ($row['status'] == 'Rejected' ? 'danger' : 'warning') ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($row['reason']) ?></td>
                    <td>
                        <?php if ($row['status'] == 'Pending') { ?>
                            <button class="btn btn-danger btn-sm cancel-leave" data-id="<?= $row['id'] ?>">Cancel</button>
                        <?php } else { ?>
                            <span class="text-muted">N/A</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

    </div>
</div>

<!-- jQuery & AJAX -->
<script>

$(document).ready(function () {
    $(".cancel-leave").click(function () {
        var leave_id = $(this).data("id");

        if (confirm("Are you sure you want to cancel this leave request?")) {
            $.post("ajax_apply_leave.php", { action: "cancel_leave", leave_id: leave_id }, function (response) {
                alert(response);
                location.reload();
            });
        }
    });
});


$(document).ready(function () {
    $("#applyLeaveForm").submit(function (e) {
        e.preventDefault();
        var leave_type_id = $("#leave_type_id").val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var reason = $("#reason").val();

        $.post("ajax_apply_leave.php", { 
            action: "apply_leave", 
            leave_type_id: leave_type_id, 
            start_date: start_date, 
            end_date: end_date, 
            reason: reason 
        }, function (response) {
            alert(response);
            location.reload();
        });
    });
});
</script>

</body>
</html>
