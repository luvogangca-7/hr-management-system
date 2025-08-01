<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Important for CORS!
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

include 'hr_database.php';

$employeeId = $_GET['id'] ?? '';

if (!$employeeId) {
    echo json_encode(["success" => false, "message" => "Missing employee ID."]);
    exit;
}

$sql = "SELECT pr.punctuality, pr.task_completion, pr.teamwork, pr.comments, e.employee_name
        FROM performance_reviews pr
        JOIN employees e ON pr.employee_id = e.employee_id
        WHERE pr.employee_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employeeId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "review" => [
            "name" => $row["employee_name"],
            "punctuality" => (int)$row["punctuality"],
            "taskCompletion" => (int)$row["task_completion"],
            "teamwork" => (int)$row["teamwork"],
            "comments" => $row["comments"]
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "No performance review found."]);
}

$stmt->close();
$conn->close();

