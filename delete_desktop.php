<?php
// Include configuration and utilities
include('config.php');

// Initialize variable
$message = '';

// Check if the ID is provided and valid
if (isset($_GET['d_id']) && is_numeric($_GET['d_id'])) {
    $d_id = (int) $_GET['d_id']; // Sanitize the ID

    try {
        // Get the database connection
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

        // Prepare and execute the DELETE query
        $stmt = $conn->prepare("DELETE FROM tbl_desktop WHERE d_id = :d_id");
        $stmt->bindParam(':d_id', $d_id, PDO::PARAM_INT);
        $stmt->execute();

        // Check the result
        if ($stmt->rowCount() > 0) {
            $message = "Desktop deleted successfully!";
        } else {
            $message = "No user found with this ID!";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
} else {
    $message = "Invalid or missing user ID!";
}

// Redirect to inventory.php#desktop with a message
header("Location: inventory.php#desktop&message=" . urlencode($message));
exit;
?>
