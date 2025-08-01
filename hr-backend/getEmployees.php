<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
include 'hr_database.php';

$sql = "SELECT e.employee_id, e.employee_name AS employee_name, e.position, d.department_name, 
               e.salary, e.employment_history, e.email
        FROM employees e
        LEFT JOIN departments d ON e.department_id = d.department_id";

$result = $conn->query($sql);
$employees = [];

while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

echo json_encode($employees);
$conn->close();
