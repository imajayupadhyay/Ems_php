<?php
include "../includes/config.php";
include "../includes/session.php";

// Ensure only admins can access
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all pending leave requests
$sql = "SELECT el.*, e.first_name, e.last_name, lt.name AS leave_type 
        FROM employee_leaves el
        JOIN employees e ON el.employee_id = e.id
        JOIN leave_types lt ON el.leave_type_id = lt.id
        WHERE el.status = 'Pending'
        ORDER BY el.created_at DESC";

$result = $conn->query($sql);

function timeElapsed($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    if ($diff < 60) {
        return $diff . " seconds ago";
    } elseif ($diff < 3600) {
        return floor($diff / 60) . " minutes ago";
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . " hours ago";
    } elseif ($diff < 604800) {
        return floor($diff / 86400) . " days ago";
    } else {
        return floor($diff / 604800) . " weeks ago";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Leave Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .card { box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); border-radius: 10px; }
        .btn { border-radius: 8px; font-weight: bold; }
    </style>
</head>
<body>
   
<div class="wrapper">
    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <h3 class="text-center">Manage Leave request</h3>
    <div class="card p-4 mt-3">
        <h5>Pending Leave Requests</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Requested</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['first_name'] . " " . $row['last_name'] ?></td>
                        <td><?= $row['leave_type'] ?></td>
                        <td><?= $row['start_date'] ?></td>
                        <td><?= $row['end_date'] ?></td>
                        <td><?= $row['reason'] ?></td>
                        <td><?= timeElapsed($row['created_at']) ?></td>
                        <td>
                            <button class="btn btn-success btn-sm approve-leave" data-id="<?= $row['id'] ?>">Approve</button>
                            <button class="btn btn-danger btn-sm reject-leave" data-id="<?= $row['id'] ?>">Reject</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<!-- jQuery AJAX Script -->
<script>
$(document).ready(function () {
    $(".approve-leave, .reject-leave").click(function () {
        var leave_id = $(this).data("id");
        var status = $(this).hasClass("approve-leave") ? "Approved" : "Rejected";

        if (confirm("Are you sure you want to " + status.toLowerCase() + " this leave request?")) {
            $.post("ajax_manage_leave_requests.php", { action: "update_status", leave_id: leave_id, status: status }, function (response) {
                alert(response);
                location.reload();
            });
        }
    });

    $(".delete-leave").click(function () {
        var leave_id = $(this).data("id");

        if (confirm("Are you sure you want to delete this leave request?")) {
            $.post("ajax_manage_leave_requests.php", { action: "delete_leave", leave_id: leave_id }, function (response) {
                alert(response);
                location.reload();
            });
        }
    });
});
</script>

</body>
</html>
