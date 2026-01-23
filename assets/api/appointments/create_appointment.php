<?php
session_start();
include dirname(dirname(dirname(__DIR__))) . '/config/database.php';

$patient_id = $_POST['patient_id'] ?? 0;
$timeslot_id = $_POST['timeslot_id'] ?? 0;
$branch_id = $_POST['branch_id'] ?? 0;
$reason = $_POST['reason'] ?? '';
$is_online_appointment = $_POST['is_online_appointment'] ?? 0;
$notes = $_POST['notes'] ?? '';
$status = $_POST['status'] ?? 'scheduled';
$user_id = $_SESSION['user_id'] ?? NULL;

header('Content-Type: application/json');

if (empty($patient_id) || empty($timeslot_id) || empty($branch_id)) {
    echo json_encode(['success' => false, 'message' => 'Patient, branch, and timeslot are required!']);
    exit;
}

// Get the timeslot date/time
$timeslot_sql = "SELECT start_time, status FROM timeslot WHERE timeslot_id = ?";
$timeslot_stmt = $conn->prepare($timeslot_sql);
$timeslot_stmt->bind_param("i", $timeslot_id);
$timeslot_stmt->execute();
$timeslot_result = $timeslot_stmt->get_result();

if ($timeslot_result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid timeslot selected!']);
    exit;
}

$timeslot = $timeslot_result->fetch_assoc();

// Check if slot is already booked
if ($timeslot['status'] !== 'available') {
    echo json_encode(['success' => false, 'message' => 'This timeslot is no longer available!']);
    exit;
}

// Extract date from start_time
$appointment_date = date('Y-m-d', strtotime($timeslot['start_time']));

// Insert appointment and mark timeslot as booked
$sql = "INSERT INTO appointments (patient_id, appointment_date, timeslot_id, branch_id, reason, is_online_appointment, notes, status, user_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isisisssi", $patient_id, $appointment_date, $timeslot_id, $branch_id, $reason, $is_online_appointment, $notes, $status, $user_id);

if ($stmt->execute()) {
    // Update timeslot status to booked
    $update_sql = "UPDATE timeslot SET status = 'booked' WHERE timeslot_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $timeslot_id);
    $update_stmt->execute();
    
    echo json_encode(['success' => true, 'message' => 'Appointment created successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error creating appointment: ' . $stmt->error]);
}

$stmt->close();
?>
