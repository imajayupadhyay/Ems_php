<?php
include "../includes/config.php";
include "../includes/session.php";

// Ensure only admins can update leave requests
if (!isset($_SESSION['admin_id'])) {
    die("❌ Unauthorized Access!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // ✅ Approve or Reject Leave Request
    if ($action == "update_status") {
        $leave_id = intval($_POST['leave_id']);
        $status = $_POST['status'];

        if (!in_array($status, ["Approved", "Rejected"])) {
            die("❌ Invalid Status!");
        }

        $sql = "UPDATE employee_leaves SET status = '$status' WHERE id = '$leave_id'";
        echo ($conn->query($sql) === TRUE) ? "✅ Leave request updated successfully!" : "❌ Error: " . $conn->error;
    }

    // ✅ Delete Leave Request (Cancel Leave)
    if ($action == "delete_leave") {
        $leave_id = intval($_POST['leave_id']);

        $sql = "DELETE FROM employee_leaves WHERE id = '$leave_id'";
        echo ($conn->query($sql) === TRUE) ? "✅ Leave request deleted successfully!" : "❌ Error: " . $conn->error;
    }
}
?>
