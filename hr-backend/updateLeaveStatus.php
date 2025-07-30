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

include 'hr_database.php'; // Your DB connection, defines $conn

// Read the JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
$employee_id = $data['employee_id'] ?? null;
$leave_date = $data['leave_date'] ?? null;
$status = $data['status'] ?? null;

if (!$employee_id || !$leave_date || !$status) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields: employee_id, leave_date, or status"
    ]);
    exit();
}

// Validate status value (optional but recommended)
$validStatuses = ['Pending', 'Approved', 'Denied'];
if (!in_array($status, $validStatuses)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid status value"
    ]);
    exit();
}

// Check if the leave request exists
$checkSql = "SELECT * FROM leave_requests WHERE employee_id = ? AND leave_date = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("is", $employee_id, $leave_date);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "Leave request not found"
    ]);
    $checkStmt->close();
    $conn->close();
    exit();
}
$checkStmt->close();

// Update the status of the leave request
$updateSql = "UPDATE leave_requests SET status = ? WHERE employee_id = ? AND leave_date = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("sis", $status, $employee_id, $leave_date);

if ($updateStmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Leave status updated successfully"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to update leave status"
    ]);
}

$updateStmt->close();
$conn->close();
?>
