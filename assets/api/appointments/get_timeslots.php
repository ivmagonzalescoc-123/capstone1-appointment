<?php
header('Content-Type: application/json');
include dirname(dirname(dirname(__DIR__))) . '/config/database.php';

// Check database connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$date = $_GET['date'] ?? '';

if (empty($date)) {
    echo json_encode([]);
    exit;
}

// Get all timeslots for the selected date, showing only available and booked ones
$sql = "SELECT timeslot_id, start_time, end_time, status 
        FROM timeslot 
        WHERE DATE(start_time) = ?
        ORDER BY start_time ASC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Database query error: ' . $conn->error]);
    exit;
}

$stmt->bind_param("s", $date);
if (!$stmt->execute()) {
    echo json_encode(['error' => 'Query execution error: ' . $stmt->error]);
    exit;
}

$result = $stmt->get_result();

$timeslots = [];
while ($row = $result->fetch_assoc()) {
    $timeslots[] = $row;
}

echo json_encode($timeslots);
?>
