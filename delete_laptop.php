<?php
// Include configuration
include('config.php');

// Initialize variable
$message = '';

if (isset($_GET['l_id']) && is_numeric($_GET['l_id'])) {
    $l_id = (int) $_GET['l_id'];

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("DELETE FROM tbl_laptop WHERE l_id = :l_id");
        $stmt->bindParam(':l_id', $l_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $message = "Laptop deleted successfully!";
        } else {
            $message = "No laptop found with this ID!";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
} else {
    $message = "Invalid or missing laptop ID!";
}

// Redirect (fix &amp;)
header("Location: inventory.php#laptop&message=" . urlencode($message));
exit;
?>
