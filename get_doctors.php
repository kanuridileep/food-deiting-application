<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DoctorConsultation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$specialization = $_GET['specialization'];
$sql = "SELECT * FROM Doctors WHERE specialization = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $specialization);
$stmt->execute();
$result = $stmt->get_result();

$doctors = [];
while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
}

header('Content-Type: application/json');
echo json_encode($doctors);

$stmt->close();
$conn->close();
?>
