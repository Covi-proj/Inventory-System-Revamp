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
        $ipv4_address = $_POST['ipv4_address'];
        $ipv4_status = $_POST['ipv4_status'];
        $physical_address_w = $_POST['physical_address_w'];
        $physical_address_e = $_POST['physical_address_e'];
        $domain = $_POST['domain'];
        $section = $_POST['section'];//new
        $d_type = $_POST['d_type'];//new
        $internet_access = $_POST['internet_access'];
        $computer_desc = $_POST['computer_desc'];
        $motherboard = $_POST['motherboard'];
        $processor = $_POST['processor'];
        $storage = $_POST['storage'];
        $gpu = $_POST['gpu'];
        $operating_system = $_POST['operating_system'];
        $os_license = $_POST['os_license'];//new
        $memory = $_POST['memory'];
        $ms_os_p = $_POST['ms_os_p'];
        $osp_id = $_POST['osp_id'];
        $ms_office = $_POST['ms_office'];//new
        $ms_office_pk = $_POST['ms_office_pk'];
        $ms_office_pid = $_POST['ms_office_pid'];
        $ms_office_cdk = $_POST['ms_office_cdk'];
        $ms_office_account_lr = $_POST['ms_office_account_lr'];
        $ms_office_password = $_POST['ms_office_password'];
        $backup_key = $_POST['backup_key'];
        $spp_folder = $_POST['spp_folder'];//new
        $noah_version = $_POST['noah_version'];
        $printer_model = $_POST['printer_model'];
        $printer_desc = $_POST['printer_desc'];
        $scanner_model = $_POST['scanner_model'];
        $barcode_scanner = $_POST['barcode_scanner'];
        $special_application = $_POST['special_application'];
        $client = $_POST['client'];//new
        $remarks = $_POST['remarks'];

        // Insert data into the database
        $stmt = $pdo->prepare("INSERT INTO tbl_desktop (compname, user_profile, ipv4_address, ipv4_status, physical_address_w, physical_address_e, domain, section, d_type, internet_access, computer_desc, motherboard, processor, memory, storage, gpu, operating_system, os_license, ms_os_p, osp_id, ms_office, ms_office_pk, ms_office_pid, ms_office_cdk, ms_office_account_lr, ms_office_password, backup_key, spp_folder,noah_version, printer_model, printer_desc, scanner_model, barcode_scanner, special_application, client, remarks) VALUES (?,?,?,?,?,?, ? , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $compname,
            $user_profile,
            $ipv4_address,
            $ipv4_status,
            $physical_address_w,
            $physical_address_e,
            $domain,
            $section,
            $d_type,
            $internet_access,
            $computer_desc,
            $motherboard,
            $processor,
            $memory,
            $storage,
            $gpu,
            $operating_system,
            $os_license,
            $ms_os_p,
            $osp_id,
            $ms_office,
            $ms_office_pk,
            $ms_office_pid,
            $ms_office_cdk,
            $ms_office_account_lr,
            $ms_office_password,
            $backup_key,
            $spp_folder,
            $noah_version,
            $printer_model,
            $printer_desc,
            $scanner_model,
            $barcode_scanner,
            $special_application,
            $client,
            $remarks
        ]);

        // Redirect back with success
        header('Location: inventory.php?message=' . urlencode('Desktop added successfully') . '#desktop');
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>