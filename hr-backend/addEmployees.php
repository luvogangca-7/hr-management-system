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

// Validate required fields including username and password
$required = ['name', 'position', 'department', 'salary', 'email', 'username', 'password'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "$field is required"]);
        exit();
    }
}

// Sanitize inputs
$name = trim($data['name']);
$position = trim($data['position']);
$department = trim($data['department']);
$salary = (float)$data['salary'];
$history = isset($data['history']) ? trim($data['history']) : '';
$email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
$username = trim($data['username']);
$password = password_hash(trim($data['password']), PASSWORD_DEFAULT); // Hash the password

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Invalid email format"]);
    exit();
}

// Check if username already exists
$checkUser = $conn->prepare("SELECT employee_id FROM employees WHERE username = ?");
$checkUser->bind_param("s", $username);
$checkUser->execute();
$userResult = $checkUser->get_result();

if ($userResult->num_rows > 0) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Username already exists"]);
    exit();
}

// Check if department exists
$deptCheck = $conn->prepare("SELECT department_id FROM departments WHERE department_name = ?");
$deptCheck->bind_param("s", $department);
$deptCheck->execute();
$deptResult = $deptCheck->get_result();

if ($deptResult->num_rows === 0) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Department does not exist"]);
    exit();
}

// Insert employee with hashed password
$stmt = $conn->prepare(
    "INSERT INTO employees (employee_name, username, password, position, department_id, salary, employment_history, email) 
    VALUES (?, ?, ?, ?, (SELECT department_id FROM departments WHERE department_name = ?), ?, ?, ?)"
);
$stmt->bind_param("sssssiss", $name, $username, $password, $position, $department, $salary, $history, $email);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "employee_id" => $stmt->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
