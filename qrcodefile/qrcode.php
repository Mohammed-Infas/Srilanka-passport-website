<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "passport_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to safely retrieve data from the database
function getApplicationData($conn, $formNumber) {
    $sql = "SELECT * FROM applications WHERE form_number = " . (int)$formNumber;  // Use integer type
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Get form number from URL parameter
$formNumber = isset($_GET['form_number']) ? (int)$_GET['form_number'] : 0;

// Get application data based on form number
$applicationData = getApplicationData($conn, $formNumber);

// Close database connection
$conn->close();

// Function to generate QR code
function generateQRCode($data) {
    $jsonData = json_encode($data);  // Encode data to JSON
    $url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($jsonData);
    return $url;
}

// Generate QR code URL if there's any application data
$qrCodeURL = $applicationData ? generateQRCode($applicationData) : null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code Generator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { padding: 20px; }
        #qrcode { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>QR Code Generator</h1>
        <?php if ($applicationData): ?>
            <p>Scan the QR code below to view your application details:</p>
            <img id="qrcode" src="<?php echo $qrCodeURL; ?>" alt="QR Code">
        <?php else: ?>
            <p>No application details found for this form.</p>
        <?php endif; ?>
    </div>
</body>
</html>
