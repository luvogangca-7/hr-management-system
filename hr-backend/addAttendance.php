<?php
// Set headers for JSON and CORS
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Include database connection
include 'hr_database.php'; // Make sure this file sets up $conn

// Read raw JSON body
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Validate required fields
$employee_id = $data['employee_id'] ?? null;
$attendance_date = $data['attendance_date'] ?? null;
$status = $data['status'] ?? 'Present'; // Default to "Present" if not provided

if (!$employee_id || !$attendance_date) {
    echo json_encode([
        "success" => false,
        "message" => "Missing employee ID or attendance date"
    ]);
    exit();
}

// Check if already checked in on the same date
$checkSql = "SELECT id FROM attendance WHERE employee_id = ? AND attendance_date = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("is", $employee_id, $attendance_date);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Already checked in today"
    ]);
    $checkStmt->close();
    $conn->close();
    exit();
}
$checkStmt->close();

// Insert new attendance record
$insertSql = "INSERT INTO attendance (employee_id, attendance_date, status) VALUES (?, ?, ?)";
$insertStmt = $conn->prepare($insertSql);
$insertStmt->bind_param("iss", $employee_id, $attendance_date, $status);

if ($insertStmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Check-in successful"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to insert attendance"
    ]);
}

$insertStmt->close();
$conn->close();
