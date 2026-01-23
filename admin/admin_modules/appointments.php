<?php
include dirname(dirname(__DIR__)) . '/config/database.php';

$action = $_GET['action'] ?? '';
$search = $_GET['search'] ?? '';

// Fetch appointments
$appointments = [];
$appointments_sql = "SELECT a.*, p.first_name, p.last_name, p.email, p.phone_number FROM appointments a 
                     LEFT JOIN patients p ON a.patient_id = p.patient_id 
                     ORDER BY a.appointment_date DESC, a.created_at DESC";
$appointments_result = $conn->query($appointments_sql);
if ($appointments_result) {
    while ($row = $appointments_result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

// Fetch patients for dropdown/search
$patients_list = [];
$patients_sql = "SELECT patient_id, first_name, last_name, email, phone_number FROM patients ORDER BY first_name ASC";
$patients_result = $conn->query($patients_sql);
if ($patients_result) {
    while ($row = $patients_result->fetch_assoc()) {
        $patients_list[] = $row;
    }
}
?>

<div class="pagetitle">
    <h1>Manage Appointments</h1>
</div>

<!-- Alert Messages -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
<?php endif; ?>

<!-- Appointments List -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Appointments</h5>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createAppointmentModal">
            <i class="bi bi-plus-circle"></i> Create Appointment
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Branch</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Reason</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['appointment_id']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['first_name'] . ' ' . $appointment['last_name']); ?></td>
                            <td>
                                <?php 
                                    $branches = [1 => 'Main', 2 => 'Butuan', 3 => 'Surigao'];
                                    echo htmlspecialchars($branches[$appointment['branch_id']] ?? 'N/A');
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($appointment['email']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['reason']); ?></td>
                            <td>
                                <?php if ($appointment['is_online_appointment']): ?>
                                    <span class="badge bg-info">Online</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">In-Person</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo $appointment['status'] === 'completed' ? 'success' : ($appointment['status'] === 'cancelled' ? 'danger' : 'warning'); ?>">
                                    <?php echo htmlspecialchars(ucfirst($appointment['status'])); ?>
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                        data-bs-target="#editAppointmentModal" onclick="editAppointment(<?php echo htmlspecialchars(json_encode($appointment)); ?>)">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========== CREATE APPOINTMENT MODAL ========== -->
<div class="modal fade" id="createAppointmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createAppointmentForm">
                <div class="modal-body">
                    <div id="appointmentMessage"></div>
                    <div class="mb-3">
                        <label class="form-label">Search & Select Patient</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="patientSearchInput" 
                                   placeholder="Search by name, email, or phone...">
                            <button class="btn btn-outline-secondary" type="button" id="patientSearchBtn">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <div id="patientList" class="list-group mt-2" style="max-height: 300px; overflow-y: auto; display: none;">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Selected Patient</label>
                        <input type="text" class="form-control" id="selectedPatientDisplay" readonly placeholder="No patient selected">
                        <input type="hidden" name="patient_id" id="selectedPatientId">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Branch</label>
                        <select class="form-control" name="branch_id" id="branchSelect" required>
                            <option value="">-- Select a branch --</option>
                            <option value="1">Azucena Dental Clinic - Main</option>
                            <option value="2">Azucena Dental Clinic - Butuan</option>
                            <option value="3">Azucena Dental Clinic - Surigao</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Date</label>
                        <input type="date" class="form-control" id="appointmentDate" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Time Slot</label>
                        <select class="form-control" name="timeslot_id" id="timeslotSelect" required>
                            <option value="">-- Select a date first --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Appointment Type</label>
                        <select class="form-control" name="is_online_appointment" id="appointmentType">
                            <option value="0">In-Person</option>
                            <option value="1">Online</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Reason for Appointment</label>
                        <input type="text" class="form-control" name="reason" id="appointmentReason" 
                               placeholder="e.g., Regular Checkup, Tooth Cleaning">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status" id="appointmentStatus">
                            <option value="scheduled">Scheduled</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="checked_in">Checked In</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="no_show">No Show</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" id="appointmentNotes" rows="3" 
                                  placeholder="Additional notes about the appointment..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="createAppointment()">Create Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========== EDIT APPOINTMENT MODAL ========== -->
<div class="modal fade" id="editAppointmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="appointment_id" id="editAppointmentId">
                    <div class="mb-3">
                        <label class="form-label">Patient</label>
                        <input type="text" class="form-control" id="editPatientDisplay" readonly>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Appointment Date</label>
                            <input type="date" class="form-control" name="appointment_date" id="editAppointmentDate" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Appointment Type</label>
                            <select class="form-control" name="is_online_appointment" id="editAppointmentType">
                                <option value="0">In-Person</option>
                                <option value="1">Online</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Reason for Appointment</label>
                        <input type="text" class="form-control" name="reason" id="editAppointmentReason">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status" id="editAppointmentStatus">
                            <option value="scheduled">Scheduled</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="checked_in">Checked In</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="no_show">No Show</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" id="editAppointmentNotes" rows="3"></textarea>
                    </div>
                </div>
                <input type="hidden" name="action" value="update">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Create appointment function
function createAppointment() {
    const patientId = document.getElementById('selectedPatientId').value;
    const timeslotId = document.getElementById('timeslotSelect').value;
    const branchId = document.getElementById('branchSelect').value;
    const reason = document.getElementById('appointmentReason').value;
    const isOnline = document.getElementById('appointmentType').value;
    const status = document.getElementById('appointmentStatus').value;
    const notes = document.getElementById('appointmentNotes').value;
    const messageDiv = document.getElementById('appointmentMessage');

    if (!patientId || !timeslotId || !branchId) {
        messageDiv.innerHTML = '<div class="alert alert-danger">Please select a patient, branch, and time slot!</div>';
        return;
    }

    const formData = new FormData();
    formData.append('patient_id', patientId);
    formData.append('timeslot_id', timeslotId);
    formData.append('branch_id', branchId);
    formData.append('reason', reason);
    formData.append('is_online_appointment', isOnline);
    formData.append('status', status);
    formData.append('notes', notes);

    fetch('../assets/api/appointments/create_appointment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageDiv.innerHTML = '<div class="alert alert-success">Appointment created successfully!</div>';
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            messageDiv.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
        }
    })
    .catch(error => {
        messageDiv.innerHTML = '<div class="alert alert-danger">Error: ' + error + '</div>';
        console.error('Error:', error);
    });
}

// Load timeslots when date changes
const appointmentDate = document.getElementById('appointmentDate');
const timeslotSelect = document.getElementById('timeslotSelect');

appointmentDate.addEventListener('change', function() {
    const selectedDate = this.value;
    if (!selectedDate) {
        timeslotSelect.innerHTML = '<option value="">-- Select a date first --</option>';
        return;
    }

    // Fetch available timeslots for the selected date
    fetch('../assets/api/appointments/get_timeslots.php?date=' + selectedDate)
        .then(response => response.json())
        .then(data => {
            console.log('Timeslots loaded:', data);
            timeslotSelect.innerHTML = '<option value="">-- Select a time slot --</option>';
            if (data.length > 0) {
                data.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot.timeslot_id;
                    const startTime = slot.start_time.substring(11, 16);
                    const endTime = slot.end_time.substring(11, 16);
                    option.textContent = startTime + ' - ' + endTime + ' (' + slot.status + ')';
                    if (slot.status !== 'available') {
                        option.disabled = true;
                    }
                    timeslotSelect.appendChild(option);
                });
            } else {
                timeslotSelect.innerHTML = '<option value="">No available slots for this date</option>';
            }
        })
        .catch(error => {
            console.error('Error loading timeslots:', error);
            timeslotSelect.innerHTML = '<option value="">Error loading time slots</option>';
        });
});

// Patient search functionality
const patientSearchInput = document.getElementById('patientSearchInput');
const patientList = document.getElementById('patientList');
const patientSearchBtn = document.getElementById('patientSearchBtn');
const selectedPatientDisplay = document.getElementById('selectedPatientDisplay');
const selectedPatientId = document.getElementById('selectedPatientId');

const allPatients = <?php echo json_encode($patients_list); ?>;

patientSearchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    if (searchTerm.length === 0) {
        patientList.style.display = 'none';
        return;
    }

    const filtered = allPatients.filter(patient => 
        patient.first_name.toLowerCase().includes(searchTerm) ||
        patient.last_name.toLowerCase().includes(searchTerm) ||
        patient.email.toLowerCase().includes(searchTerm) ||
        patient.phone_number.includes(searchTerm)
    );

    patientList.innerHTML = '';
    if (filtered.length > 0) {
        filtered.forEach(patient => {
            const div = document.createElement('a');
            div.href = '#';
            div.className = 'list-group-item list-group-item-action';
            div.innerHTML = `<strong>${patient.first_name} ${patient.last_name}</strong><br>
                            <small>${patient.email} | ${patient.phone_number}</small>`;
            div.onclick = (e) => {
                e.preventDefault();
                selectedPatientDisplay.value = `${patient.first_name} ${patient.last_name}`;
                selectedPatientId.value = patient.patient_id;
                patientList.style.display = 'none';
                patientSearchInput.value = '';
            };
            patientList.appendChild(div);
        });
        patientList.style.display = 'block';
    } else {
        patientList.innerHTML = '<div class="list-group-item">No patients found</div>';
        patientList.style.display = 'block';
    }
});

// Hide patient list when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.input-group') && !event.target.closest('#patientList')) {
        patientList.style.display = 'none';
    }
});

function editAppointment(appointment) {
    document.getElementById('editAppointmentId').value = appointment.appointment_id;
    document.getElementById('editPatientDisplay').value = appointment.first_name + ' ' + appointment.last_name;
    document.getElementById('editAppointmentDate').value = appointment.appointment_date;
    document.getElementById('editAppointmentType').value = appointment.is_online_appointment;
    document.getElementById('editAppointmentReason').value = appointment.reason;
    document.getElementById('editAppointmentStatus').value = appointment.status;
    document.getElementById('editAppointmentNotes').value = appointment.notes;
}
</script>
