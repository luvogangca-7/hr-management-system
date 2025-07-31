<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET");

include 'hr_database.php';

$sql = "
    SELECT 
        lh.id,
        lh.employee_id,
        e.employee_name,
        d.department_name,
        lh.leave_date,
        lh.end_date,
        lh.reason,
        lh.status,
        lh.processed_at
    FROM leave_history lh
    JOIN employees e ON lh.employee_id = e.employee_id
    JOIN departments d ON e.department_id = d.department_id
    ORDER BY lh.processed_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$history = [];
while ($row = $result->fetch_assoc()) {
    $history[] = $row;
}

echo json_encode([
    'success' => true, 
    'history' => $history
]);

$stmt->close();
$conn->close();
?>