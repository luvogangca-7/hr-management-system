<?php
// Set headers for JSON response and CORS
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'hr_database.php';

$data = json_decode(file_get_contents("php://input"), true);

$employeeId = $data['employee_id'];
$leaveDate = $data['leave_date'];
$status = $data['status'];
$processedAt = date('Y-m-d H:i:s'); // Current timestamp

// 1. Get the request details
$stmt = $conn->prepare("SELECT * FROM leave_requests WHERE employee_id = ? AND leave_date = ?");
$stmt->bind_param("is", $employeeId, $leaveDate);
$stmt->execute();
$result = $stmt->get_result();
$request = $result->fetch_assoc();

if ($request) {
    // 2. Insert into history
    $stmt = $conn->prepare("
        INSERT INTO leave_history 
        (employee_id, leave_date, end_date, reason, status, processed_at)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "isssss", 
        $request['employee_id'],
        $request['leave_date'],
        $request['end_date'],
        $request['reason'],
        $status,
        $processedAt
    );
    $stmt->execute();

    // 3. Delete from requests
    $stmt = $conn->prepare("DELETE FROM leave_requests WHERE employee_id = ? AND leave_date = ?");
    $stmt->bind_param("is", $employeeId, $leaveDate);
    $stmt->execute();

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Request not found"]);
}

$conn->close();
?>