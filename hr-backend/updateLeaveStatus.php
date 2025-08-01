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

if (!$request) {
    echo json_encode(["success" => false, "message" => "Request not found"]);
    exit();
}

$startDate = $request['leave_date'];
$endDate = $request['end_date'];
$reason = $request['reason'];

// 2. If status is Approved, calculate days and update leave balance
if ($status === 'Approved') {
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $daysRequested = $start->diff($end)->days + 1;

    // Get current leave balance
    $stmtBalance = $conn->prepare("SELECT leave_balance FROM employees WHERE employee_id = ?");
    $stmtBalance->bind_param("i", $employeeId);
    $stmtBalance->execute();
    $balanceResult = $stmtBalance->get_result();
    $balanceData = $balanceResult->fetch_assoc();

    if ($balanceData && $balanceData['leave_balance'] >= $daysRequested) {
        // Deduct leave days
        $stmtDeduct = $conn->prepare("UPDATE employees SET leave_balance = leave_balance - ? WHERE employee_id = ?");
        $stmtDeduct->bind_param("ii", $daysRequested, $employeeId);
        $stmtDeduct->execute();
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Insufficient leave balance for approval"
        ]);
        exit();
    }
}

// 3. Insert into history
$stmt = $conn->prepare("
    INSERT INTO leave_history 
    (employee_id, leave_date, end_date, reason, status, processed_at)
    VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
    "isssss", 
    $employeeId,
    $startDate,
    $endDate,
    $reason,
    $status,
    $processedAt
);
$stmt->execute();

// 4. Delete from requests
$stmt = $conn->prepare("DELETE FROM leave_requests WHERE employee_id = ? AND leave_date = ?");
$stmt->bind_param("is", $employeeId, $leaveDate);
$stmt->execute();

echo json_encode(["success" => true]);
$conn->close();
?>
