<?php
include "../includes/config.php";
include "../includes/session.php";

// Ensure only admins can access
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all leave types
$leave_query = "SELECT * FROM leave_types ORDER BY id DESC";
$leave_result = $conn->query($leave_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Leave Types</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .card { box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); border-radius: 10px; }
        .btn { border-radius: 8px; font-weight: bold; }
        .table { background: white; border-radius: 8px; }
    </style>
</head>
<body>

<div class="wrapper">
    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <h3 class="text-center">Manage Leave Types</h3>

        <!-- Add Leave Type Form -->
        <div class="card p-4 mt-3">
            <h5>Add Leave Type</h5>
            <form id="addLeaveForm">
                <input type="text" name="name" id="name" class="form-control mb-2" placeholder="Enter Leave Type Name" required>
                <textarea name="description" id="description" class="form-control mb-2" placeholder="Enter Leave Description" required></textarea>
                <input type="number" name="number_of_days" id="number_of_days" class="form-control mb-2" placeholder="Number of Days" required>
                <button type="submit" class="btn btn-primary">Add Leave Type</button>
            </form>
        </div>

        <!-- List of Leave Types -->
        <div class="card p-4 mt-3">
            <h5>List of Leave Types</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Leave Type</th>
                        <th>Description</th>
                        <th>Number of Days</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="leaveList">
                    <?php while ($row = $leave_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= htmlspecialchars($row['number_of_days']) ?> days</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-leave" 
                                    data-id="<?= $row['id'] ?>" 
                                    data-name="<?= $row['name'] ?>" 
                                    data-description="<?= $row['description'] ?>" 
                                    data-days="<?= $row['number_of_days'] ?>">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete-leave" data-id="<?= $row['id'] ?>">Delete</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery & AJAX Scripts -->
<script>
$(document).ready(function () {
    // Add Leave Type
    $("#addLeaveForm").submit(function (e) {
        e.preventDefault();
        var leaveName = $("#name").val();
        var description = $("#description").val();
        var numberOfDays = $("#number_of_days").val();

        $.post("ajax_manage_leaves.php", { action: "add_leave", name: leaveName, description: description, number_of_days: numberOfDays }, function (response) {
            alert(response);
            location.reload();
        });
    });

    // Edit Leave Type
    $(".edit-leave").click(function () {
        var id = $(this).data("id");
        var newName = prompt("Enter new Leave Type Name:", $(this).data("name"));
        var newDescription = prompt("Enter new Description:", $(this).data("description"));
        var newDays = prompt("Enter new Number of Days:", $(this).data("days"));

        if (newName !== null && newDays !== null) {
            $.post("ajax_manage_leaves.php", { action: "edit_leave", id: id, name: newName, description: newDescription, number_of_days: newDays }, function (response) {
                alert(response);
                location.reload();
            });
        }
    });

    // Delete Leave Type
    $(".delete-leave").click(function () {
        if (confirm("Are you sure you want to delete this Leave Type?")) {
            var id = $(this).data("id");
            $.post("ajax_manage_leaves.php", { action: "delete_leave", id: id }, function (response) {
                alert(response);
                location.reload();
            });
        }
    });
});
</script>

</body>
</html>
