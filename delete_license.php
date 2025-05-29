<?php
// Include configuration and utilities
include('config.php');

// Initialize variables
$message = '';
$status = '';

// Check if the ID is provided and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id']; // Sanitize the ID

    try {
        // Get the database connection
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Debugging: Check if the ID exists
        $stmt = $conn->prepare("SELECT * FROM licenses WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Record exists, proceed with delete
            $stmt = $conn->prepare("DELETE FROM licenses WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Check if deletion was successful
            if ($stmt->rowCount() > 0) {
                $message = "User deleted successfully!";
            } else {
                $message = "No user found with this ID!";
            }
        } else {
            $message = "ID does not exist in the database!";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
} else {
    $message = "Invalid or missing user ID!";
}

// Redirect with the correct message
header('Location: inventory.php?message=' . urlencode($message) . '#license');
exit;
?>
