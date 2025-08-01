<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

include 'hr_database.php';

// Add error logging for debugging
error_log("Received request: " . print_r($_GET, true));

$employeeId = $_GET['id'] ?? '';

if (!$employeeId) {
    error_log("Missing employee ID in request");
    echo json_encode([
        "success" => false, 
        "message" => "Missing employee ID.",
        "received_id" => $employeeId
    ]);
    exit;
}

try {
    // Get basic employee info
    $stmt = $conn->prepare("
        SELECT e.salary, e.position, d.department_name 
        FROM employees e
        JOIN departments d ON e.department_id = d.department_id
        WHERE e.employee_id = ?
    ");
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();
    $employeeInfo = $stmt->get_result()->fetch_assoc();
    
    if (!$employeeInfo) {
        echo json_encode(["success" => false, "message" => "Employee not found"]);
        exit;
    }
    
    // Get attendance count for last 3 weeks (21 days)
    $stmt = $conn->prepare("
        SELECT COUNT(*) as attendance_count
        FROM attendance 
        WHERE employee_id = ?
        AND status = 'Present'
    ");
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();
    $attendanceData = $stmt->get_result()->fetch_assoc();
    
    // Get recent attendance records (last 5 days)
    $stmt = $conn->prepare("
        SELECT d.attendance_date, a.status
FROM (
    SELECT DISTINCT attendance_date
    FROM attendance
    ORDER BY attendance_date DESC
    LIMIT 5
) d
LEFT JOIN attendance a
  ON d.attendance_date = a.attendance_date
 AND a.employee_id = ?
ORDER BY d.attendance_date DESC;

    ");
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();
    $recentAttendance = [];
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
    $recentAttendance[] = [
        'attendance_date' => $row['attendance_date'],
        'status' => $row['status'] ?? 'No Record'
    ];
}

    
    // Get performance data (latest review)
    $stmt = $conn->prepare("
        SELECT 
            (punctuality + task_completion + teamwork) / 3 as performance_score,
            comments as last_feedback
        FROM performance_reviews
        WHERE employee_id = ?
        LIMIT 1
    ");
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();
    $performanceData = $stmt->get_result()->fetch_assoc();
    
    echo json_encode([
        "success" => true,
        "attendance_count" => (int)$attendanceData['attendance_count'],
        "position" => $employeeInfo['position'],
        "salary" => (int)$employeeInfo['salary'],
        "department" => $employeeInfo['department_name'],
        "recent_attendance" => $recentAttendance,
        "performance_score" => round($performanceData['performance_score'] ?? 0, 1),
        "last_feedback" => $performanceData['last_feedback'] ?? 'No feedback yet'
    ]);
    
} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}

$conn->close();
?>