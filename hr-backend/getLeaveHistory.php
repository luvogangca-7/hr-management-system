<?php
header("Content-Type: application/json");
include 'hr_database.php';

$result = $conn->query("SELECT * FROM leave_history ORDER BY processed_at DESC");

$history = [];
while ($row = $result->fetch_assoc()) {
    $history[] = $row;
}

echo json_encode(['success' => true, 'history' => $history]);
