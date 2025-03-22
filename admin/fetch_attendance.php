<?php
include "../includes/config.php";

// Check if request is via AJAX
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(["error" => "Invalid request method."]));
}

// Get filter values
$employee_id = isset($_POST['employee_id']) ? $conn->real_escape_string($_POST['employee_id']) : '';
$month = isset($_POST['month']) ? $conn->real_escape_string($_POST['month']) : '';
$date = isset($_POST['date']) ? $conn->real_escape_string($_POST['date']) : '';

$response = [
    "attendanceTable" => "",
    "totalWorkingDays" => 0
];

// Base Query for Attendance Data
$query = "SELECT a.*, e.first_name, e.last_name 
          FROM attendance a
          JOIN employees e ON a.employee_id = e.id
          WHERE 1";

// Apply Employee Filter
if (!empty($employee_id) && is_numeric($employee_id)) {
    $query .= " AND a.employee_id = '$employee_id'";
}

// Apply Date Filter
if (!empty($date)) {
    $query .= " AND DATE(a.punch_in) = '$date'";
} elseif (!empty($month)) { // Apply Month Filter
    $query .= " AND DATE_FORMAT(a.punch_in, '%Y-%m') = '$month'";
}

// Order by latest
$query .= " ORDER BY a.punch_in DESC";
$result = $conn->query($query);

// Generate Attendance Table
$tableHTML = "<h4>Attendance Records</h4>
              <table class='table table-bordered mt-3'>
              <thead>
                  <tr>
                      <th>Employee Name</th>
                      <th>Date</th>
                      <th>Punch In</th>
                      <th>Punch Out</th>
                      <th>Worked Hours</th>
                  </tr>
              </thead>
              <tbody>";

if ($result->num_rows > 0) {
    while ($record = $result->fetch_assoc()) {
        $tableHTML .= "<tr>
                        <td>" . $record['first_name'] . " " . $record['last_name'] . "</td>
                        <td>" . date("d M Y", strtotime($record['punch_in'])) . "</td>
                        <td>" . date("h:i A", strtotime($record['punch_in'])) . "</td>
                        <td>" . (!empty($record['punch_out']) ? date("h:i A", strtotime($record['punch_out'])) : 'Not Yet') . "</td>
                        <td>" . (!empty($record['work_hours']) ? number_format($record['work_hours'], 2) . " hrs" : "Pending") . "</td>
                      </tr>";
    }
} else {
    $tableHTML .= "<tr><td colspan='5' class='text-center'>No records found.</td></tr>";
}

$tableHTML .= "</tbody></table>";

$response["attendanceTable"] = $tableHTML;

// **Calculate Total Working Days**
if (!empty($employee_id) && !empty($month)) {
    $workingDaysQuery = "SELECT COUNT(DISTINCT DATE(punch_in)) AS total_days 
                         FROM attendance 
                         WHERE employee_id = '$employee_id' 
                         AND DATE_FORMAT(punch_in, '%Y-%m') = '$month'";

    $workingDaysResult = $conn->query($workingDaysQuery);
    $workingDaysRow = $workingDaysResult->fetch_assoc();
    $response["totalWorkingDays"] = $workingDaysRow['total_days'];
}

// Send response as JSON
echo json_encode($response);
?>
