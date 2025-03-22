<?php
include "../includes/config.php";
require '../vendor/autoload.php'; // Load PHPSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$employee_id = isset($_GET['employee_id']) ? $conn->real_escape_string($_GET['employee_id']) : '';
$month = isset($_GET['month']) ? $conn->real_escape_string($_GET['month']) : '';
$date = isset($_GET['date']) ? $conn->real_escape_string($_GET['date']) : '';

// Base query
$query = "SELECT a.*, e.first_name, e.last_name FROM attendance a
          JOIN employees e ON a.employee_id = e.id WHERE 1";

// Apply filters
if (!empty($employee_id)) {
    $query .= " AND a.employee_id = '$employee_id'";
}
if (!empty($date)) {
    $query .= " AND DATE(a.punch_in) = '$date'";
} elseif (!empty($month)) {
    $query .= " AND DATE_FORMAT(a.punch_in, '%Y-%m') = '$month'";
}

$query .= " ORDER BY a.punch_in DESC";
$result = $conn->query($query);

// Create Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Attendance Report");

// Header row
$headers = ["Employee Name", "Date", "Punch In", "Punch Out", "Worked Hours"];
$sheet->fromArray([$headers], NULL, 'A1');

// Populate data
$rowNum = 2;
while ($record = $result->fetch_assoc()) {
    $sheet->setCellValue("A$rowNum", $record['first_name'] . " " . $record['last_name']);
    $sheet->setCellValue("B$rowNum", date("d M Y", strtotime($record['punch_in'])));
    $sheet->setCellValue("C$rowNum", date("h:i A", strtotime($record['punch_in'])));
    $sheet->setCellValue("D$rowNum", (!empty($record['punch_out']) ? date("h:i A", strtotime($record['punch_out'])) : 'Not Yet'));
    $sheet->setCellValue("E$rowNum", (!empty($record['work_hours']) ? number_format($record['work_hours'], 2) . " hrs" : "Pending"));
    $rowNum++;
}

// Generate and Download Excel file
$filename = "Attendance_Report_" . date("YmdHis") . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
?>
