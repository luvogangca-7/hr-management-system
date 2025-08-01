<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include 'hr_database.php';

$employeeId = $_GET['id'] ?? '';

if (!$employeeId) {
    echo json_encode(['success' => false, 'message' => 'Missing employee ID']);
    exit;
}

$query = "SELECT leave_balance FROM employees WHERE employee_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employeeId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $balance = $result->fetch_assoc();
    echo json_encode(['success' => true, 'leaveBalance' => $balance['leave_balance']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Employee not found']);
}
?>
