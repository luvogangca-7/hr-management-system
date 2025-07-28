<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'hr_database.php'; // Ensure this includes $conn

// Validate and sanitize employee_id
if (!isset($_GET['employee_id']) || !is_numeric($_GET['employee_id'])) {
    echo json_encode(["success" => false, "message" => "Missing or invalid employee ID"]);
    exit();
}

$employee_id = intval($_GET['employee_id']);

$sql = "SELECT attendance_date, status FROM attendance WHERE employee_id = ? ORDER BY attendance_date DESC";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    exit();
}

$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();

$records = [];
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

echo json_encode([
    "success" => true,
    "attendance" => $records
]);

$stmt->close();
$conn->close();
