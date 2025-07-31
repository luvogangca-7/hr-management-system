<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include 'hr_database.php';

try {
    $data = [];

    // Total employees
    $totalEmpQuery = "SELECT COUNT(*) as total FROM employees";
    $result = $conn->query($totalEmpQuery);
    $data['totalEmployees'] = $result->fetch_assoc()['total'];

    // Total attendance for today
    $today = date('Y-m-d');
    $attQuery = "SELECT COUNT(*) as total FROM attendance WHERE attendance_date = '$today'";
    $result = $conn->query($attQuery);
    $data['attendanceCount'] = $result->fetch_assoc()['total'];

    // Average salary
    $avgSalaryQuery = "SELECT AVG(salary) as avg FROM employees";
    $result = $conn->query($avgSalaryQuery);
    $data['averageSalary'] = round($result->fetch_assoc()['avg'], 2);

    // Department overview
    $deptQuery = "SELECT department_name, COUNT(*) as count FROM employees JOIN departments ON departments.department_id = employees.department_id GROUP BY department_name";
    $result = $conn->query($deptQuery);
    $departments = [];
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
    $data['departments'] = $departments;

    // Top performers
    $topQuery = "SELECT 
    e.employee_id,
    e.employee_name,
    ROUND(AVG((IFNULL(pr.punctuality, 0) + IFNULL(pr.task_completion, 0) + IFNULL(pr.teamwork, 0)) / 3), 2) AS performance_score
FROM employees e
JOIN performance_reviews pr ON e.employee_id = pr.employee_id
GROUP BY e.employee_id, e.employee_name
ORDER BY performance_score DESC
LIMIT 3
";
    $result = $conn->query($topQuery);
    $topPerformers = [];
    while ($row = $result->fetch_assoc()) {
        $topPerformers[] = $row;
    }
    $data['topPerformers'] = $topPerformers;

    echo json_encode(['success' => true, 'data' => $data]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}
?>
