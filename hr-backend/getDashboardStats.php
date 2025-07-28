<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include 'hr_database.php';

$response = [];

// 1. Total employees
$empResult = $conn->query("SELECT COUNT(*) AS total FROM employees");
$response['employeeCount'] = $empResult->fetch_assoc()['total'];

// 2. Attendance count (e.g. today’s present)
$attResult = $conn->query("SELECT COUNT(*) AS present FROM attendance WHERE status = 'Present' AND attendance_date = '2025-07-28'");
$response['attendanceCount'] = $attResult->fetch_assoc()['present'];


// 4. Average salary
$salResult = $conn->query("SELECT AVG(final_salary) AS avgSalary FROM payroll");
$response['avgSalary'] = round($salResult->fetch_assoc()['avgSalary']);

// 5. Departments overview
$deptResult = $conn->query("SELECT department_name, COUNT(*) AS count FROM employees GROUP BY department");
$departments = [];
while ($row = $deptResult->fetch_assoc()) {
    $departments[] = [
        'name' => $row['department'],
        'count' => (int)$row['count']
    ];
}
$response['departments'] = $departments;

// 6. Top 3 performers based on average score
$perfResult = $conn->query("SELECT e.name, e.position, ROUND((p.punctuality + p.taskCompletion + p.teamwork) / 3, 1) AS score 
                            FROM performance_reviews p 
                            JOIN employees e ON p.employeeId = e.employeeId 
                            ORDER BY score DESC 
                            LIMIT 3");
$top = [];
while ($row = $perfResult->fetch_assoc()) {
    $top[] = [
        'name' => $row['name'],
        'score' => $row['score'],
        'position' => $row['position']
    ];
}
$response['topPerformers'] = $top;

echo json_encode($response);
$conn->close();
?>
