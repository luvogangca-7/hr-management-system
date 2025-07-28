<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'hr_database.php';

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Missing employee ID"]);
    exit();
}

$employee_id = intval($_GET['id']);

$sql = "SELECT 
          e.*, 
          d.dob, d.gender, d.marital_status, d.phone, d.address,
          dp.department_name
        FROM employees e
        LEFT JOIN employee_details d ON e.employee_id = d.employee_id
        LEFT JOIN departments dp ON e.department_id = dp.department_id
        WHERE e.employee_id = $employee_id";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => "Query failed: " . $conn->error]);
    exit();
}

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);
$conn->close();
