<?php
// Database configuration
$host = 'localhost';      // Your database host (usually localhost)
$db = 'license_db';    // Your database name
$user = 'root';  // Your database username
$pass = '';  // Your database password

try {
    // Establishing a PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

    // Set the PDO error mode to exception to easily catch errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Success message (optional)

} catch (PDOException $e) {
    // Catch any errors and display an error message
    echo "Connection failed: " . $e->getMessage();
}
?>
