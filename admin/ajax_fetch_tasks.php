<?php
include "../includes/config.php";

// Ensure it's an AJAX POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Invalid request method.";
    exit;
}

$employee_id = isset($_POST['employee_id']) ? intval($_POST['employee_id']) : '';
$task_date = isset($_POST['task_date']) ? $_POST['task_date'] : '';

// Base query
$query = "SELECT t.*, e.first_name, e.last_name 
          FROM tasks t
          JOIN employees e ON t.employee_id = e.id
          WHERE 1";

// Apply filters if available
if (!empty($employee_id)) {
    $query .= " AND t.employee_id = '$employee_id'";
}

if (!empty($task_date)) {
    $query .= " AND t.task_date = '$task_date'";
}

$query .= " ORDER BY t.task_date DESC";

$result = $conn->query($query);

// If no records
if ($result->num_rows == 0) {
    echo "<div class='alert alert-warning text-center'>No tasks found for the selected filters.</div>";
    exit;
}

// Output HTML table
echo "<div class='card p-3'>
        <h5>Task List</h5>
        <div class='table-responsive'>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Task Date</th>
                    <th>Task Description</th>
                </tr>
            </thead>
            <tbody>";

$counter = 1;
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$counter}</td>
            <td>{$row['first_name']} {$row['last_name']}</td>
            <td>{$row['task_date']}</td>
            <td>" . nl2br($row['task_description']) . "</td>
          </tr>";
    $counter++;
}

echo "</tbody></table></div></div>";
?>
