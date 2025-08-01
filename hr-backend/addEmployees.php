<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");
include 'hr_database.php';

$data = json_decode(file_get_contents("php://input"));

$name = $conn->real_escape_string($data->name);
$username = $conn->real_escape_string($data->username);
$password = password_hash($data->password, PASSWORD_DEFAULT);
$position = $conn->real_escape_string($data->position);
$department = $conn->real_escape_string($data->department);
$salary = floatval($data->salary);
$history = $conn->real_escape_string($data->history ?? '');
$email = $conn->real_escape_string($data->email);

// Get department_id
$deptQuery = $conn->query("SELECT department_id FROM departments WHERE department_name = '$department'");
if ($deptQuery->num_rows > 0) {
    $department_id = $deptQuery->fetch_assoc()['department_id'];
} else {
    echo json_encode(["error" => "Invalid department"]);
    exit();
}

$sql = "INSERT INTO employees (employee_name, username, password, position, department_id, salary, employment_history, email)
        VALUES ('$name', '$username', '$password', '$position', $department_id, $salary, '$history', '$email')";

if ($conn->query($sql)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => $conn->error]);
}

$conn->close();
