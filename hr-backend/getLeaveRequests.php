<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'hr_database.php';

$employee_id = $_GET['employee_id'] ?? null;

$sql = "
    SELECT 
        l.employee_id,
        e.employee_name,
        l.leave_date,
        l.reason,
        l.status,
        l.recorded_at
    FROM leaverequest l
    JOIN employees e ON l.employee_id = e.employee_id
";

if ($employee_id) {
    $sql .= " WHERE l.employee_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
} else {
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$leaveRequests = [];
while ($row = $result->fetch_assoc()) {
    $leaveRequests[] = $row;
}

echo json_encode([
    "success" => true,
    "leaveRequests" => $leaveRequests
]);

$stmt->close();
$conn->close();
