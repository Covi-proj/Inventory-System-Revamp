<?php
// Database connection
include('config.php');

if (isset($_POST['id'])) {
    $id = $_POST['id']; // Get the medicine ID from the URL
} else {
    echo "No ID provided!";
    exit;
}

// Initialize variables for form data, in case they aren't set yet
$type_of_license = '';
$lisence = '';
$license_key = '';
$remark = '';
$computer_name = '';
$ms_account = '';
$ms_password = '';


// Check if the form is submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the med_id is available in POST data
    if (isset($_POST['id'])) {
        $id = $_POST['id']; // Ensure we have the med_id in the POST data
    }
    $type_of_license = $_POST['type_of_license']; // Example post data from the form
    $lisence = $_POST['lisence'];
    $license_key = $_POST['license_key'];
    $remark = $_POST['remark'];
    $computer_name = $_POST['computer_name'];
    $ms_account = $_POST['ms_account'];
    $ms_password = $_POST['ms_password'];

    try {
        // Prepare your SQL query to update the medicine record
        $stmt = $conn->prepare("UPDATE licenses SET type_of_license = :type_of_license, lisence = :lisence, license_key = :license_key, remark = :remark, computer_name = :computer_name, ms_account = :ms_account, ms_password = :ms_password WHERE id = :id");


        // Bind parameters to the prepared statement
        $stmt->bindParam(':type_of_license', $type_of_license);
        $stmt->bindParam(':lisence', $lisence);
        $stmt->bindParam(':license_key', $license_key);
        $stmt->bindParam(':remark', $remark);
        $stmt->bindParam(':computer_name', $computer_name);
        $stmt->bindParam(':ms_account', $ms_account);
        $stmt->bindParam(':ms_password', $ms_password);
        $stmt->bindParam(':id', $id); // Bind the ID parameter
        
        // Execute the query
        $stmt->execute();
        $message = "Medicine updated successfully!";
        $status = "success";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $status = "error";
    }
} else {
    // If it's not a POST request, fetch the existing data for the medicine
    try {
        $stmt = $conn->prepare("SELECT * FROM licenses WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $license = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($license) {
            $type_of_license = $license['type_of_license'];
            $lisence = $license['lisence'];
            $license_key = $license['license_key'];
            $remark = $license['remark'];
            $computer_name = $license['computer_name'];
            $ms_account = $license['ms_account'];
            $ms_password = $license['ms_password'];
        } else {
            $message = "No data found with this ID.";
            $status = "error";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $status = "error";
    }
}
header('location: inventory.php#license');
?>