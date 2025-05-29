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
        $computer_name = $_POST['computer_name'];
        $client = $_POST['client'];
        $user_profile = $_POST['user_profile'];
        $d_type = $_POST['d_type'];
        $mac_address = $_POST['mac_address'];
        $ipv4_address = $_POST['ipv4_address'];
        $ipv4_status = $_POST['ipv4_status'];
        $physical_address = $_POST['physical_address'];
        $domain = $_POST['domain'];
        $section = $_POST['section'];
        $laptop_model = $_POST['laptop_model'];
        $motherboard = $_POST['motherboard'];
        $processor = $_POST['processor'];
        $memory = $_POST['memory'];
        $storage = $_POST['storage'];
        $gpu = $_POST['gpu'];
        $operating_system = $_POST['operating_system'];
        $os_license = $_POST['os_license'];
        $ms_os_product_id = $_POST['ms_os_product_id'];
        $os_id = $_POST['os_pk'];
        $ms_office = $_POST['ms_office'];
        $ms_office_pk = $_POST['ms_office_pk'];
        $ms_office_pid = $_POST['ms_office_pid'];
        $ms_office_lr = $_POST['ms_office_lr'];
        $ms_office_p = $_POST['ms_office_p'];
        $spp_folder = $_POST['spp_folder'];
        $backup_key = $_POST['backup_key'];
        $noah = $_POST['noah'];
        $special_app = $_POST['special_app'];
        $date_purchase = $_POST['date_purchase'];
        $warranty_card = $_POST['warranty_card'];
        $printer_model = $_POST['printer_model'];
        $barcode_scanner = $_POST['barcode_scanner'];
        $remarks = $_POST['remarks'];

        // Insert data into the database (32 fields and 32 placeholders)
        $stmt = $pdo->prepare("INSERT INTO tbl_laptop (
            computer_name, client, user_profile, d_type, mac_address, ipv4_address, ipv4_status, physical_address,
            domain, section, laptop_model, motherboard, processor, memory, storage, gpu, operating_system,
            os_license, ms_os_product_id, os_pk, ms_office, ms_office_pk, ms_office_pid, ms_office_lr, ms_office_p,
            spp_folder, backup_key, noah, special_app, date_purchase, warranty_card, printer_model, barcode_scanner, remarks
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt->execute([
            $computer_name,
            $client,
            $user_profile,
            $d_type,
            $mac_address,
            $ipv4_address,
            $ipv4_status,
            $physical_address,
            $domain,
            $section,
            $laptop_model,
            $motherboard,
            $processor,
            $memory,
            $storage,
            $gpu,
            $operating_system,
            $os_license,
            $ms_os_product_id,
            $os_id,
            $ms_office,
            $ms_office_pk,
            $ms_office_pid,
            $ms_office_lr,
            $ms_office_p,
            $spp_folder,
            $backup_key,
            $noah,
            $special_app,
            $date_purchase,
            $warranty_card,
            $printer_model,
            $barcode_scanner,
            $remarks
        ]);

        // Redirect back with success
        header('Location: inventory.php?message=' . urlencode('Record added successfully') . '#laptop');
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
