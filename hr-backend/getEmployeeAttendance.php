<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'hr_database.php';

$employeeId = intval($_GET['id'] ?? 0);
$startDate = $_GET['start'] ?? '';
$endDate = $_GET['end'] ?? '';

if (!$employeeId || !$startDate || !$endDate) {
    echo json_encode(["error" => "Missing required parameters"]);
    exit();
}

$sql = "SELECT date, status
        FROM attendance
        WHERE employee_id = $employeeId
          AND attendance_date BETWEEN '$startDate' AND '$endDate'
        ORDER BY attendance_date ASC";

$result = $conn->query($sql);
$attendance = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }
    echo json_encode($attendance);
} else {
    echo json_encode(["error" => $conn->error]);
}

$conn->close();
