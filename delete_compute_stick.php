<?php
// Include configuration and utilities
include('config.php');

// Initialize variable
$message = '';

// Check if the ID is provided and valid
if (isset($_GET['cs_id']) && is_numeric($_GET['cs_id'])) {
    $cs_id = (int) $_GET['cs_id']; // Sanitize the ID

    try {
        // Get the database connection
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

        // Prepare and execute the DELETE query
        $stmt = $conn->prepare("DELETE FROM tbl_compute_stick WHERE cs_id = :cs_id");
        $stmt->bindParam(':cs_id', $cs_id, PDO::PARAM_INT);
        $stmt->execute();

        // Check the result
        if ($stmt->rowCount() > 0) {
            $message = "Record deleted successfully!";
        } else {
            $message = "No user found with this ID!";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
} else {
    $message = "Invalid or missing user ID!";
}

// Redirect to inventory.php#compute_stick with a message
header("Location: inventory.php?message=" . urlencode($message) . "#compute_stick");
exit;
?>
