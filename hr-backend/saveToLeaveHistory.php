<?php
header("Content-Type: application/json");
include 'hr_database.php';

$data = json_decode(file_get_contents("php://input"), true);

$employee_id = $data['employee_id'] ?? null;
$leave_date = $data['leave_date'] ?? null;
$reason = $data['reason'] ?? '';
$status = $data['status'] ?? null;

if (!$employee_id || !$leave_date || !$status) {
    echo json_encode(['success' => false, 'message' => 'Missing fields']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO leave_history (employee_id, leave_date, reason, status) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $employee_id, $leave_date, $reason, $status);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}
