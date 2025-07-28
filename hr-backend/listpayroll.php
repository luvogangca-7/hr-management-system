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
        p.employee_id,
        e.employee_name,
        p.hours_worked,
        p.leave_deductions,
        p.final_salary,
        p.recorded_at
    FROM payroll p
    LEFT JOIN employees e ON p.employee_id = e.employee_id
";

if ($employee_id) {
    $sql .= " WHERE p.employee_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
} else {
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$payrollData = [];
while ($row = $result->fetch_assoc()) {
    $payrollData[] = $row;
}

echo json_encode([
    "success" => true,
    "payrollData" => $payrollData
]);

$stmt->close();
$conn->close();
