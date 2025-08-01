<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'hr_database.php';

$data = json_decode(file_get_contents("php://input"));

if (!$conn) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

$id = intval($data->id);
$name = $conn->real_escape_string($data->name ?? '');
$position = $conn->real_escape_string($data->position ?? '');
$department_name = $conn->real_escape_string($data->department ?? '');
$salary = floatval($data->salary ?? 0);
$employment_history = $conn->real_escape_string($data->history ?? '');
$email = $conn->real_escape_string($data->email ?? '');

// Step 1: Get department_id from department_name
$dept_result = $conn->query("SELECT department_id FROM departments WHERE department_name = '$department_name'");

if (!$dept_result || $dept_result->num_rows === 0) {
    echo json_encode(["error" => "Invalid department name"]);
    exit();
}

$dept_row = $dept_result->fetch_assoc();
$department_id = $dept_row['department_id'];

// Step 2: Update employee row
$sql = "UPDATE employees SET 
            employee_name = '$name',
            position = '$position',
            department_id = $department_id,
            salary = $salary,
            employment_history = '$employment_history',
            email = '$email'
        WHERE employee_id = $id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Update failed: " . $conn->error]);
}

$conn->close();
