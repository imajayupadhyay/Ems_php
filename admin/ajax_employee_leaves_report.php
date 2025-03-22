<?php
include "../includes/config.php";

$employee_id = $_POST['employee_id'] ?? '';
$leave_type_id = $_POST['leave_type_id'] ?? '';
$month = $_POST['month'] ?? '';

// Build SQL Query Dynamically
$query = "SELECT e.first_name, e.last_name, lt.name AS leave_type, el.start_date, el.end_date, el.status, 
                DATEDIFF(el.end_date, el.start_date) + 1 AS total_days 
          FROM employee_leaves el
          JOIN employees e ON el.employee_id = e.id
          JOIN leave_types lt ON el.leave_type_id = lt.id
          WHERE 1=1";

if (!empty($employee_id)) {
    $query .= " AND el.employee_id = '$employee_id'";
}
if (!empty($leave_type_id)) {
    $query .= " AND el.leave_type_id = '$leave_type_id'";
}
if (!empty($month)) {
    $query .= " AND DATE_FORMAT(el.start_date, '%Y-%m') = '$month'";
}

$query .= " ORDER BY el.start_date DESC";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['first_name']} {$row['last_name']}</td>
                <td>{$row['leave_type']}</td>
                <td>{$row['start_date']}</td>
                <td>{$row['end_date']}</td>
                <td>{$row['status']}</td>
                <td>{$row['total_days']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>No leave records found.</td></tr>";
}
?>
