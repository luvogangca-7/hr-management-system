<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'hr_database.php';

$data = json_decode(file_get_contents("php://input"), true);

$employee_id = $data['employee_id'] ?? null;

if (!$employee_id) {
    echo json_encode(["success" => false, "message" => "Missing employee ID"]);
    exit();
}

$stmt = $conn->prepare("DELETE FROM payroll WHERE employee_id = ?");
$stmt->bind_param("i", $employee_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Payroll record deleted"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to delete payroll record"]);
}

$stmt->close();
$conn->close();
