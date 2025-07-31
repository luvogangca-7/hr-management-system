<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include 'hr_database.php';

$data = json_decode(file_get_contents("php://input"), true);

$employeeId = $data["employeeId"] ?? '';
$punctuality = $data["punctuality"] ?? 0;
$taskCompletion = $data["taskCompletion"] ?? 0;
$teamwork = $data["teamwork"] ?? 0;
$comments = $data["comments"] ?? '';

if (!$employeeId || !$punctuality || !$taskCompletion || !$teamwork) {
    echo json_encode(["success" => false, "message" => "Missing required fields."]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO performance_reviews (employee_id, punctuality, task_completion, teamwork, comments) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiiss", $employeeId, $punctuality, $taskCompletion, $teamwork, $comments);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Database error."]);
}

$stmt->close();
$conn->close();
