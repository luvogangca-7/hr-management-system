<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'hr-backend/hr_database.php';

// Get the input data
$input = json_decode(file_get_contents('php://input'), true);
$employeeId = isset($input['employee_id']) ? $input['employee_id'] : null;

if (!$employeeId) {
    echo json_encode(['error' => 'Employee ID is required']);
    exit();
}

// Query to get combined data from employees and employees_info tables
$query = "";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employeeId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $employeeData = $result->fetch_assoc();
    echo json_encode($employeeData);
} else {
    echo json_encode(['error' => 'Employee not found']);
}

$stmt->close();
$conn->close();
?>