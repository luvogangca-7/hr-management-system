<?php
// Add proper CORS headers
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'hr_database.php';  // Go up one directory to find hr_database.php

// Check if connection exists
if (!$conn) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Use your original query but add employee_id
$result = $conn->query("SELECT 
  e.*, 
  d.dob, d.gender, d.marital_status, d.phone, d.address,
  dp.department_name
FROM employees e
LEFT JOIN employee_details d ON e.employee_id = d.employee_id
LEFT JOIN departments dp ON e.department_id = dp.department_id;
");

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
