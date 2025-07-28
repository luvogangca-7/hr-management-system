<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include 'hr_database.php'; // adjust if needed

$sql = "SELECT pr.employee_id, e.employee_name, pr.punctuality, pr.task_completion, pr.teamwork, pr.comments
        FROM performance_reviews pr
        JOIN employees e ON pr.employee_id = e.employee_id";

$result = $conn->query($sql);

$reviews = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = [
            "id" => $row["employee_id"],
            "name" => $row["employee_name"],
            "punctuality" => (int)$row["punctuality"],
            "taskCompletion" => (int)$row["task_completion"],
            "teamwork" => (int)$row["teamwork"],
            "comments" => $row["comments"]
        ];
    }
}

echo json_encode($reviews);
$conn->close();
?>
