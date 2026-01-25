<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', dirname(__FILE__) . '/error.log');

session_start();
header('Content-Type: application/json');

try {
    include dirname(dirname(dirname(__DIR__))) . '/config/database.php';
    
    if (!$conn) {
        throw new Exception('Database connection failed');
    }

    $patient_id = isset($_POST['patient_id']) ? (int)$_POST['patient_id'] : 0;
    $timeslot_id = isset($_POST['timeslot_id']) ? (int)$_POST['timeslot_id'] : 0;
    $branch_id = isset($_POST['branch_id']) ? (int)$_POST['branch_id'] : 0;
    $reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';
    $is_online_appointment = isset($_POST['is_online_appointment']) ? (int)$_POST['is_online_appointment'] : 0;
    $notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : 'scheduled';
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

    if (empty($patient_id) || empty($timeslot_id) || empty($branch_id)) {
        echo json_encode(['success' => false, 'message' => 'Patient, branch, and timeslot are required!']);
        exit;
    }

    // Get the timeslot date/time
    $timeslot_sql = "SELECT start_time, end_time, status FROM timeslot WHERE timeslot_id = ?";
    $timeslot_stmt = $conn->prepare($timeslot_sql);
    
    if (!$timeslot_stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    if (!$timeslot_stmt->bind_param("i", $timeslot_id)) {
        throw new Exception('Bind failed: ' . $timeslot_stmt->error);
    }
    
    if (!$timeslot_stmt->execute()) {
        throw new Exception('Execute failed: ' . $timeslot_stmt->error);
    }
    
    $timeslot_result = $timeslot_stmt->get_result();

    if ($timeslot_result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid timeslot selected!']);
        exit;
    }

    $timeslot = $timeslot_result->fetch_assoc();
    $timeslot_stmt->close();

    // Check if slot is already booked
    if ($timeslot['status'] !== 'available') {
        echo json_encode(['success' => false, 'message' => 'This timeslot is no longer available!']);
        exit;
    }

    // Extract date from start_time
    $appointment_date = date('Y-m-d', strtotime($timeslot['start_time']));

    // Insert appointment
    $sql = "INSERT INTO appointments (patient_id, appointment_date, timeslot_id, branch_id, reason, is_online_appointment, notes, status, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Prepare insert failed: ' . $conn->error);
    }

    // Type string: i, s, i, i, s, i, s, s, i
    if (!$stmt->bind_param("isiisissi", $patient_id, $appointment_date, $timeslot_id, $branch_id, $reason, $is_online_appointment, $notes, $status, $user_id)) {
        throw new Exception('Bind insert failed: ' . $stmt->error);
    }

    if (!$stmt->execute()) {
        throw new Exception('Insert failed: ' . $stmt->error);
    }

    $appointment_id = $conn->insert_id;
    $stmt->close();

    // Update timeslot status to booked
    $update_sql = "UPDATE timeslot SET status = 'booked' WHERE timeslot_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    
    if ($update_stmt) {
        if ($update_stmt->bind_param("i", $timeslot_id)) {
            $update_stmt->execute();
        }
        $update_stmt->close();
    }
    
    echo json_encode(['success' => true, 'message' => 'Appointment created successfully!', 'appointment_id' => $appointment_id]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
