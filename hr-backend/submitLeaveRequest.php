<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

include 'hr_database.php';

$data = json_decode(file_get_contents("php://input"), true);

$employeeId = $data['employeeId'] ?? null;
$startDate = $data['startDate'] ?? null;
$endDate = $data['endDate'] ?? null;
$reason = $data['reason'] ?? null;

if (!$employeeId || !$startDate || !$endDate || !$reason) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$sql = "INSERT INTO leave_requests (employee_id, leave_date, end_date, reason, status)
        VALUES (?, ?, ?, ?, 'Pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $employeeId, $startDate, $endDate, $reason);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Leave request submitted successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
