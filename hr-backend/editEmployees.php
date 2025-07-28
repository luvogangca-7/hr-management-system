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

if (empty($data['id'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Employee ID is required"]);
    exit();
}

$id = (int)$data['id'];
$name = trim($data['name'] ?? '');
$position = trim($data['position'] ?? '');
$department = trim($data['department'] ?? '');
$salary = isset($data['salary']) ? (float)$data['salary'] : 0;
$history = trim($data['history'] ?? '');
$email = filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$username = trim($data['username'] ?? '');

// Extended details
$dob = trim($data['dob'] ?? null);  // expects YYYY-MM-DD or null
$gender = trim($data['gender'] ?? null);
$marital_status = trim($data['marital_status'] ?? null);
$phone = trim($data['phone'] ?? null);
$address = trim($data['address'] ?? null);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Invalid email format"]);
    exit();
}

// Check if username is unique for others
$checkUser = $conn->prepare("SELECT employee_id FROM employees WHERE username = ? AND employee_id != ?");
$checkUser->bind_param("si", $username, $id);
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
$deptRow = $deptResult->fetch_assoc();
$department_id = $deptRow['department_id'];

// Optional password update (hash if present)
$password = null;
if (isset($data['password']) && $data['password'] !== '') {
    $password = password_hash(trim($data['password']), PASSWORD_DEFAULT);
}

// Build the employees update query dynamically (include password only if present)
if ($password !== null) {
    $sql = "UPDATE employees SET employee_name=?, username=?, password=?, position=?, department_id=?, salary=?, employment_history=?, email=? WHERE employee_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssdssi", $name, $username, $password, $position, $department_id, $salary, $history, $email, $id);
} else {
    $sql = "UPDATE employees SET employee_name=?, username=?, position=?, department_id=?, salary=?, employment_history=?, email=? WHERE employee_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdssi", $name, $username, $position, $department_id, $salary, $history, $email, $id);
}

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => $stmt->error]);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// Now update or insert employee_details using upsert
$upsertSql = "INSERT INTO employee_details (employee_id, dob, gender, marital_status, phone, address) VALUES (?, ?, ?, ?, ?, ?)
              ON DUPLICATE KEY UPDATE dob=VALUES(dob), gender=VALUES(gender), marital_status=VALUES(marital_status), phone=VALUES(phone), address=VALUES(address)";
$stmtDetails = $conn->prepare($upsertSql);
$stmtDetails->bind_param("isssss", $id, $dob, $gender, $marital_status, $phone, $address);

if (!$stmtDetails->execute()) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => $stmtDetails->error]);
    $stmtDetails->close();
    $conn->close();
    exit();
}

$stmtDetails->close();
$conn->close();

echo json_encode(["success" => true]);
