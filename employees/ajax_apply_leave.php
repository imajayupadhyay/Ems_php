<?php
include "../includes/config.php";
include "../includes/session.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // Apply for leave
    if ($action == "apply_leave") {
        $employee_id = $_SESSION['employee_id'];
        $leave_type_id = intval($_POST['leave_type_id']);
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $reason = $conn->real_escape_string($_POST['reason']);

        if (strtotime($end_date) < strtotime($start_date)) {
            echo "❌ Error: End date cannot be before start date!";
            exit();
        }

        $sql = "INSERT INTO employee_leaves (employee_id, leave_type_id, start_date, end_date, reason) 
                VALUES ('$employee_id', '$leave_type_id', '$start_date', '$end_date', '$reason')";

        echo ($conn->query($sql) === TRUE) ? "✅ Leave request submitted successfully!" : "❌ Error: " . $conn->error;
    }

    // Cancel leave request
    if ($action == "cancel_leave") {
        $leave_id = intval($_POST['leave_id']);

        $sql = "DELETE FROM employee_leaves WHERE id = '$leave_id' AND status = 'Pending'";
        echo ($conn->query($sql) === TRUE) ? "✅ Leave request canceled successfully!" : "❌ Error: Unable to cancel leave!";
    }
}

?>
