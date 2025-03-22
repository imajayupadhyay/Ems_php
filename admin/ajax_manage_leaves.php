<?php
include "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // Add Leave Type
    if ($action == "add_leave") {
        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);
        $number_of_days = intval($_POST['number_of_days']);

        $sql = "INSERT INTO leave_types (name, description, number_of_days) VALUES ('$name', '$description', '$number_of_days')";
        if ($conn->query($sql) === TRUE) {
            echo "✅ Leave Type Added Successfully!";
        } else {
            echo "❌ Error: " . $conn->error;
        }
    }

    // Edit Leave Type
    if ($action == "edit_leave") {
        $id = intval($_POST['id']);
        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);
        $number_of_days = intval($_POST['number_of_days']);

        $sql = "UPDATE leave_types SET name = '$name', description = '$description', number_of_days = '$number_of_days' WHERE id = '$id'";
        if ($conn->query($sql) === TRUE) {
            echo "✅ Leave Type Updated Successfully!";
        } else {
            echo "❌ Error: " . $conn->error;
        }
    }

    // Delete Leave Type
    if ($action == "delete_leave") {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM leave_types WHERE id = '$id'";
        if ($conn->query($sql) === TRUE) {
            echo "✅ Leave Type Deleted Successfully!";
        } else {
            echo "❌ Error: " . $conn->error;
        }
    }
}
?>
