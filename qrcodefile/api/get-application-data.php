<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "passport_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$formNumber = isset($_GET['form_number']) ? intval($_GET['form_number']) : 0;

if ($formNumber <= 0) {
  die(json_encode(['error' => 'Invalid form number']));
}

$sql = "SELECT * FROM applications WHERE form_number = " . $formNumber;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $data = $result->fetch_assoc();
  echo json_encode($data);
} else {
  echo json_encode(['error' => 'No application data found for this form number']);
}

$conn->close();
?>
