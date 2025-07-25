<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:8080"); // More secure than *
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include '../hr_database.php'; // Adjusted path based on your working solution

$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (empty($data['name']) || empty($data['position']) || empty($data['department']) || 
    empty($data['salary']) || empty($data['email'])) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "error" => "All fields except employment history are required"
    ]);
    exit();
}

// Sanitize data
$name = trim($data['name']);
$position = trim($data['position']);
$department = trim($data['department']);
$salary = (float)$data['salary'];
$history = isset($data['history']) ? trim($data['history']) : '';
$email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "error" => "Invalid email format"
    ]);
    exit();
}

// Check if department exists
$deptCheck = $conn->prepare("SELECT department_id FROM departments WHERE department_name = ?");
$deptCheck->bind_param("s", $department);
$deptCheck->execute();
$deptResult = $deptCheck->get_result();

if ($deptResult->num_rows === 0) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "error" => "Department does not exist"
    ]);
    exit();
}

// Insert employee
$stmt = $conn->prepare("INSERT INTO employees (employee_name, position, department_id, salary, employment_history, email) 
                        VALUES (?, ?, (SELECT department_id FROM departments WHERE department_name = ?), ?, ?, ?)");
$stmt->bind_param("sssiss", $name, $position, $department, $salary, $history, $email);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "employee_id" => $stmt->insert_id
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => $stmt->error,
        "sqlstate" => $stmt->sqlstate
    ]);
}

$stmt->close();
$conn->close();