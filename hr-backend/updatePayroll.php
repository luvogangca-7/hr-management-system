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
$hours_worked = $data['hours_worked'] ?? null;
$leave_deductions = $data['leave_deductions'] ?? null;

if (!$employee_id || $hours_worked === null || $leave_deductions === null) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit();
}

// Adjust these rates as necessary
$hourly_rate = 500;
$deduction_rate = 200;

$final_salary = ($hours_worked * $hourly_rate) - ($leave_deductions * $deduction_rate);

$stmt = $conn->prepare("UPDATE payroll SET hours_worked = ?, leave_deductions = ?, final_salary = ?, recorded_at = NOW() WHERE employee_id = ?");
$stmt->bind_param("iidi", $hours_worked, $leave_deductions, $final_salary, $employee_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Payroll updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update payroll"]);
}

$stmt->close();
$conn->close();
