<?php
header('Content-Type: application/json');
include dirname(dirname(dirname(__DIR__))) . '/config/database.php';

// Check database connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$date = $_GET['date'] ?? '';
$branch_id = $_GET['branch_id'] ?? 1;

if (empty($date)) {
    echo json_encode([]);
    exit;
}

// Validate date format
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    echo json_encode(['error' => 'Invalid date format']);
    exit;
}

// Get day of week for the selected date
$dateObj = new DateTime($date);
$dayOfWeek = $dateObj->format('l'); // Monday, Tuesday, etc.

// Check if there's a schedule for this day and branch
$schedule_sql = "SELECT available_from, available_to FROM schedule 
                 WHERE branch_id = ? AND day_of_week = ? AND status = 'active' LIMIT 1";
$schedule_stmt = $conn->prepare($schedule_sql);
if (!$schedule_stmt) {
    echo json_encode(['error' => 'Query error: ' . $conn->error]);
    exit;
}

$schedule_stmt->bind_param("is", $branch_id, $dayOfWeek);
if (!$schedule_stmt->execute()) {
    echo json_encode(['error' => 'Query execution error']);
    exit;
}

$schedule_result = $schedule_stmt->get_result();

// If no schedule found for this day, return empty
if ($schedule_result->num_rows === 0) {
    echo json_encode([]);
    exit;
}

$schedule = $schedule_result->fetch_assoc();
$available_from = $schedule['available_from'];
$available_to = $schedule['available_to'];

// Get existing timeslots for this date
$existing_sql = "SELECT timeslot_id, start_time, end_time, status 
                 FROM timeslot 
                 WHERE DATE(start_time) = ?
                 ORDER BY start_time ASC";
$existing_stmt = $conn->prepare($existing_sql);
$existing_stmt->bind_param("s", $date);
$existing_stmt->execute();
$existing_result = $existing_stmt->get_result();

$existing_timeslots = [];
while ($row = $existing_result->fetch_assoc()) {
    $existing_timeslots[$row['start_time']] = $row;
}

// Generate timeslots for this day (30-minute intervals)
$timeslots = [];
$current_time = new DateTime($date . ' ' . $available_from);
$end_time = new DateTime($date . ' ' . $available_to);
$interval = new DateInterval('PT30M'); // 30 minutes

while ($current_time < $end_time) {
    $slot_start = $current_time->format('Y-m-d H:i:s');
    $slot_key = $current_time->format('Y-m-d H:i:s');
    
    // Check if this slot already exists in database
    if (isset($existing_timeslots[$slot_key])) {
        $existing = $existing_timeslots[$slot_key];
        $timeslots[] = [
            'timeslot_id' => $existing['timeslot_id'],
            'start_time' => $existing['start_time'],
            'end_time' => $existing['end_time'],
            'status' => $existing['status']
        ];
    } else {
        // Generate a new timeslot and INSERT it into DB
        $slot_end = clone $current_time;
        $slot_end->add($interval);
        $slot_end_str = $slot_end->format('Y-m-d H:i:s');
        
        // Insert the new timeslot
        $insert_sql = "INSERT INTO timeslot (start_time, end_time, status) VALUES (?, ?, 'available')";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ss", $slot_start, $slot_end_str);
        if ($insert_stmt->execute()) {
            $timeslot_id = $conn->insert_id;
            $timeslots[] = [
                'timeslot_id' => $timeslot_id,
                'start_time' => $slot_start,
                'end_time' => $slot_end_str,
                'status' => 'available'
            ];
        }
    }
    
    $current_time->add($interval);
}

echo json_encode($timeslots);
?>
