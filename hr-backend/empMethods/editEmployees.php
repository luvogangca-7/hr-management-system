<?php

header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include '../hr_database.php';  

$data = json_decode(file_get_contents("php://input"), true);

// Debug: Log the received data
error_log('Received data: ' . print_r($data, true));

// Add validation to ensure ID is provided
if (!isset($data['id']) || empty($data['id'])) {
    echo json_encode([
        "success" => false,
        "error" => "Employee ID is required for update"
    ]);
    exit();
}

$id = $data['id'];
$name = $data['name'];
$position = $data['position'];
$department = $data['department'];
$salary = $data['salary'];
$history = $data['history'];
$email = $data['email'];

// Fixed the parameter binding - was "sssissi", should be "sssissi" (7 parameters)
$stmt = $conn->prepare(
    "UPDATE employees SET employee_name=?, position=?, department_id=(SELECT department_id FROM departments WHERE department_name=?), salary=?, employment_history=?, email=? WHERE employee_id=?"
);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "error" => "Prepare failed: " . $conn->error
    ]);
    exit();
}

$stmt->bind_param("sssissi", $name, $position, $department, $salary, $history, $email, $id);

$result = $stmt->execute();

echo json_encode([
    "success" => $result,
    "error" => $result ? null : $stmt->error,
    "affected_rows" => $stmt->affected_rows,
    "debug_info" => [
        "id" => $id,
        "name" => $name,
        "position" => $position,
        "department" => $department,
        "salary" => $salary,
        "history" => $history,
        "email" => $email
    ]
]);

$stmt->close();
$conn->close();