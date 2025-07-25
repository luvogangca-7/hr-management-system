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

include '../hr_database.php';  // Go up one directory to find hr_database.php

// Check if connection exists
if (!$conn) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Use your original query but add employee_id
$result = $conn->query("SELECT employees.employee_id, employees.employee_name, employees.position, departments.department_name, employees.salary, employees.employment_history, employees.email 
FROM employees 
JOIN departments ON employees.department_id = departments.department_id");

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
?>