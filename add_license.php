<?php
// Database connection
$host = 'localhost';
$db   = 'license_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $type_of_license = $_POST['type_of_license'];
        $lisence = $_POST['lisence'];
        $license_key = $_POST['license_key'];
        $remark = $_POST['remark'];
        $computer_name = $_POST['computer_name'];
        $ms_account = $_POST['ms_account'];
        $ms_password = $_POST['ms_password'];

        // Insert data into the database
        $stmt = $pdo->prepare("INSERT INTO licenses (type_of_license, lisence, license_key, remark, computer_name, ms_account, ms_password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$type_of_license, $lisence, $license_key, $remark, $computer_name, $ms_account, $ms_password]);

        // Redirect back with success
        header('Location: inventory.php?message=' . urlencode('License added successfully') . '#license');
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

