<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

include 'hr_database.php';

// Initialize default response
$response = [
    "success" => false,
    "message" => "Unknown error",
    "data" => []
];

try {
    // 1. Total Employees
    $result = $conn->query("SELECT COUNT(*) AS total_employees FROM employees");
    $totalEmployees = $result->fetch_assoc()['total_employees'];

    // 2. Attendance Count (current business week)
    $result = $conn->query("
        SELECT COUNT(DISTINCT employee_id) AS attendance_count
        FROM attendance
        WHERE YEARWEEK(attendance_date, 1) = YEARWEEK(CURDATE(), 1)
    ");
    $attendanceCount = $result->fetch_assoc()['attendance_count'];

    // 3. Average Salary
    $result = $conn->query("SELECT AVG(salary) AS avg_salary FROM employees");
    $avgSalary = round((float)$result->fetch_assoc()['avg_salary'], 2);

    // 4. Department Overview
    $departments = [];
    $result = $conn->query("
        SELECT department_name, COUNT(*) AS count
        FROM employees
        GROUP BY department
    ");
    while ($row = $result->fetch_assoc()) {
        $departments[] = [
            "department" => $row['department'],
            "count" => (int)$row['count']
        ];
    }

    // 5. Top Performers (dummy logic for now)
    $topPerformers = [];
    $result = $conn->query("
        SELECT employee_id, name, department
        FROM employees
        ORDER BY RAND() LIMIT 3
    ");
    while ($row = $result->fetch_assoc()) {
        $topPerformers[] = [
            "id" => $row['employee_id'],
            "name" => $row['name'],
            "department" => $row['department']
        ];
    }

    // 6. Employees on Leave This Week
    $result = $conn->query("
        SELECT COUNT(DISTINCT employee_id) AS leave_count
        FROM leave_requests
        WHERE YEARWEEK(leave_start, 1) = YEARWEEK(CURDATE(), 1)
           OR YEARWEEK(leave_end, 1) = YEARWEEK(CURDATE(), 1)
    ");
    $leaveCount = $result->fetch_assoc()['leave_count'];

    // Final JSON Response
    $response['success'] = true;
    $response['message'] = "Dashboard stats loaded successfully";
    $response['data'] = [
        "totalEmployees" => (int)$totalEmployees,
        "attendanceCount" => (int)$attendanceCount,
        "avgSalary" => $avgSalary,
        "leaveCount" => (int)$leaveCount,
        "departmentOverview" => $departments,
        "topPerformers" => $topPerformers
    ];

} catch (Exception $e) {
    $response['message'] = "Server error: " . $e->getMessage();
}

echo json_encode($response);
?>
