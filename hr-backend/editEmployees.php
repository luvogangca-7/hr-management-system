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

$employee_id = intval($data->id);
$dob = $conn->real_escape_string($data->dob ?? '');
$gender = $conn->real_escape_string($data->gender ?? '');
$marital_status = $conn->real_escape_string($data->marital_status ?? '');
$phone = $conn->real_escape_string($data->phone ?? '');
$address = $conn->real_escape_string($data->address ?? '');

// Check if employee_details already exists for this user
$check = $conn->query("SELECT * FROM employee_details WHERE employee_id = $employee_id");
if ($check && $check->num_rows > 0) {
    // Update
    $sql = "UPDATE employee_details SET 
                dob = '$dob',
                gender = '$gender',
                marital_status = '$marital_status',
                phone = '$phone',
                address = '$address'
            WHERE employee_id = $employee_id";
} else {
    // Insert
    $sql = "INSERT INTO employee_details (employee_id, dob, gender, marital_status, phone, address)
            VALUES ($employee_id, '$dob', '$gender', '$marital_status', '$phone', '$address')";
}

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Update failed: " . $conn->error]);
}

$conn->close();
