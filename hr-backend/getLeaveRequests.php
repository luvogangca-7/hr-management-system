<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET");

include 'hr_database.php';

$employee_id = $_GET['employee_id'] ?? null;

$sql = "
    SELECT 
        lr.id,
        lr.employee_id,
        e.employee_name AS employee_name,
        d.department_name,
        lr.leave_date,
        lr.end_date,
        lr.reason,
        lr.status
    FROM leave_requests lr
    JOIN employees e ON lr.employee_id = e.employee_id
    JOIN departments d ON e.department_id = d.department_id
    WHERE lr.status = 'Pending'
";

if ($employee_id) {
    $sql .= " AND lr.employee_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
} else {
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$leaveRequests = [];
while ($row = $result->fetch_assoc()) {
    $leaveRequests[] = $row;
}

echo json_encode([
    "success" => true,
    "leaveRequests" => $leaveRequests
]);

$stmt->close();
$conn->close();
?>