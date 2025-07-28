<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'hr_database.php';  // Adjust path to your db connection

// Corrected alias in SQL query
$sql = "SELECT e.employee_id AS employeeId, e.employee_name AS name, a.attendance_date, a.status
        FROM employees e
        LEFT JOIN attendance a ON e.employee_id = a.employee_id
        ORDER BY e.employee_id, a.attendance_date";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Failed to prepare statement"]);
    exit();
}

$stmt->execute();

$result = $stmt->get_result();

$attendanceData = [];

while ($row = $result->fetch_assoc()) {
    $empId = $row['employeeId'];
    if (!isset($attendanceData[$empId])) {
        $attendanceData[$empId] = [
            'name' => $row['name'],
            'attendance' => []
        ];
    }

    if ($row['attendance_date'] !== null) {
        $attendanceData[$empId]['attendance'][] = [
            'date' => $row['attendance_date'],
            'status' => $row['status']
        ];
    }
}

$stmt->close();
$conn->close();

echo json_encode([
    "success" => true,
    "attendanceAndLeave" => array_values($attendanceData)
]);
