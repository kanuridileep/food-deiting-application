<?php
if (isset($_GET['doctor_id'])) {
    $doctorId = $_GET['doctor_id'];
    echo "<h1>Book Appointment</h1>";
    echo "<p>Booking an appointment with Doctor ID: $doctorId</p>";
    // Here you can include form or booking logic
} else {
    echo "Invalid request!";
}
?>
