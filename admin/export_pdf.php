<?php
include "../includes/config.php";
require '../vendor/autoload.php'; // Load TCPDF

use TCPDF;

$employee_id = isset($_GET['employee_id']) ? $conn->real_escape_string($_GET['employee_id']) : '';
$month = isset($_GET['month']) ? $conn->real_escape_string($_GET['month']) : '';
$date = isset($_GET['date']) ? $conn->real_escape_string($_GET['date']) : '';

// Base query
$query = "SELECT a.*, e.first_name, e.last_name FROM attendance a
          JOIN employees e ON a.employee_id = e.id WHERE 1";

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

// Initialize PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("EMS System");
$pdf->SetTitle("Attendance Report");
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

// Header
$pdf->SetFont("helvetica", "B", 16);
$pdf->Cell(0, 10, "Attendance Report", 0, 1, "C");
$pdf->SetFont("helvetica", "", 12);

// Table header
$pdf->SetFont("helvetica", "B", 10);
$pdf->Cell(45, 10, "Employee Name", 1);
$pdf->Cell(30, 10, "Date", 1);
$pdf->Cell(30, 10, "Punch In", 1);
$pdf->Cell(30, 10, "Punch Out", 1);
$pdf->Cell(30, 10, "Worked Hours", 1);
$pdf->Ln();

// Table data
$pdf->SetFont("helvetica", "", 10);
while ($record = $result->fetch_assoc()) {
    $pdf->Cell(45, 10, $record['first_name'] . " " . $record['last_name'], 1);
    $pdf->Cell(30, 10, date("d M Y", strtotime($record['punch_in'])), 1);
    $pdf->Cell(30, 10, date("h:i A", strtotime($record['punch_in'])), 1);
    $pdf->Cell(30, 10, (!empty($record['punch_out']) ? date("h:i A", strtotime($record['punch_out'])) : 'Not Yet'), 1);
    $pdf->Cell(30, 10, (!empty($record['work_hours']) ? number_format($record['work_hours'], 2) . " hrs" : "Pending"), 1);
    $pdf->Ln();
}

// Output PDF
$pdf->Output("Attendance_Report_" . date("YmdHis") . ".pdf", "D");
?>
