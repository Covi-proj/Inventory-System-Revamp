<?php
// Database connection
$host = 'localhost';
$db = 'license_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $compname = $_POST['compname'];
        $user_profile = $_POST['user_profile'];
        $physical_address_w = $_POST['physical_address_w'];
        $domain = $_POST['domain'];
        $section = $_POST['section'];
        $d_type = $_POST['d_type'];
        $internet_access = $_POST['internet_access'];
        $motherboard = $_POST['motherboard'];
        $processor = $_POST['processor'];
        $storage = $_POST['storage'];
        $memory = $_POST['memory'];
        $osp_id = $_POST['osp_id'];
        $ms_office = $_POST['ms_office'];
        $ms_office_pk = $_POST['ms_office_pk'];
        $ms_office_pid = $_POST['ms_office_pid'];
        $noah_version = $_POST['noah_version'];
        $barcode_scanner = $_POST['barcode_scanner'];
        $client = $_POST['client'];
        $remarks = $_POST['remarks'];

        // Insert query
        $stmt = $pdo->prepare("INSERT INTO tbl_compute_stick (
            compname, user_profile, physical_address_w, domain, d_type, section, internet_access,
            motherboard, processor, memory, storage, osp_id, ms_office, ms_office_pk, ms_office_pid,
            noah_version, barcode_scanner, client, remarks
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $compname,
            $user_profile,
            $physical_address_w,
            $domain,
            $d_type,
            $section,
            $internet_access,
            $motherboard,
            $processor,
            $memory,
            $storage,
            $osp_id,
            $ms_office,
            $ms_office_pk,
            $ms_office_pid,
            $noah_version,
            $barcode_scanner,
            $client,
            $remarks
        ]);

        // ✅ Redirect after successful insert
        header("Location: inventory.php#compute_stick");
        exit();
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
