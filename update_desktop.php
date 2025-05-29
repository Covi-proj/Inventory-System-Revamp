<?php
// --- Update Desktop Record ---

// Include database connection
include 'config.php'; // adjust path if needed

// Initialize message variables
$message = "";
$status = "";

// Check if both GET and POST requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['d_id'])) {
    $d_id = $_GET['d_id'];

    // Fetch existing data
    try {
        $stmt = $conn->prepare("SELECT * FROM tbl_desktop WHERE d_id = :d_id");
        $stmt->bindParam(':d_id', $d_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Load the existing values to variables
            $compname = $row['compname'];
            $user_profile = $row['user_profile'];
            $ipv4_address = $row['ipv4_address'];
            $ipv4_status = $row['ipv4_status'];
            $physical_address_w = $row['physical_address_w'];
            $physical_address_e = $row['physical_address_e'];
            $domain = $row['domain'];
            $section = $row['section'];
            $d_type = $row['d_type'];
            $internet_access = $row['internet_access'];
            $computer_desc = $row['computer_desc'];
            $motherboard = $row['motherboard'];
            $processor = $row['processor'];
            $storage = $row['storage'];
            $gpu = $row['gpu'];
            $operating_system = $row['operating_system'];
            $os_license = $row['os_license'];
            $memory = $row['memory'];
            $ms_os_p = $row['ms_os_p'];
            $osp_id = $row['osp_id'];
            $ms_office_pk = $row['ms_office_pk'];
            $ms_office_pid = $row['ms_office_pid'];
            $ms_office_cdk = $row['ms_office_cdk'];
            $ms_office_account_lr = $row['ms_office_account_lr'];
            $ms_office_password = $row['ms_office_password'];
            $backup_key = $row['backup_key'];
            $spp_folder = $row['spp_folder'];
            $noah_version = $row['noah_version'];
            $printer_model = $row['printer_model'];
            $printer_desc = $row['printer_desc'];
            $scanner_model = $row['scanner_model'];
            $barcode_scanner = $row['barcode_scanner'];
            $special_application = $row['special_application'];
            $client = $row['client'];
            $remarks = $row['remarks'];
        } else {
            $message = "No record found!";
            $status = "error";
        }
    } catch (PDOException $e) {
        $message = "Error fetching record: " . $e->getMessage();
        $status = "error";
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['d_id'])) {
    $d_id = $_POST['d_id'];

    // Get updated form data
    $compname = $_POST['compname'];
    $user_profile = $_POST['user_profile'];
    $ipv4_address = $_POST['ipv4_address'];
    $ipv4_status = $_POST['ipv4_status'];
    $physical_address_w = $_POST['physical_address_w'];
    $physical_address_e = $_POST['physical_address_e'];
    $domain = $_POST['domain'];
    $section = $_POST['section'];
    $d_type = $_POST['d_type'];
    $internet_access = $_POST['internet_access'];
    $computer_desc = $_POST['computer_desc'];
    $motherboard = $_POST['motherboard'];
    $processor = $_POST['processor'];
    $storage = $_POST['storage'];
    $gpu = $_POST['gpu'];
    $operating_system = $_POST['operating_system'];
    $os_license = $_POST['os_license'];
    $memory = $_POST['memory'];
    $ms_os_p = $_POST['ms_os_p'];
    $osp_id = $_POST['osp_id'];
    $ms_office_pk = $_POST['ms_office_pk'];
    $ms_office_pid = $_POST['ms_office_pid'];
    $ms_office_cdk = $_POST['ms_office_cdk'];
    $ms_office_account_lr = $_POST['ms_office_account_lr'];
    $ms_office_password = $_POST['ms_office_password'];
    $backup_key = $_POST['backup_key'];
    $spp_folder = $_POST['spp_folder'];
    $noah_version = $_POST['noah_version'];
    $printer_model = $_POST['printer_model'];
    $printer_desc = $_POST['printer_desc'];
    $scanner_model = $_POST['scanner_model'];
    $barcode_scanner = $_POST['barcode_scanner'];
    $special_application = $_POST['special_application'];
    $client = $_POST['client'];
    $remarks = $_POST['remarks'];

    // Update query
    try {
        $stmt = $conn->prepare("
            UPDATE tbl_desktop SET 
                compname = :compname,
                user_profile = :user_profile,
                ipv4_address = :ipv4_address,
                ipv4_status = :ipv4_status,
                physical_address_w = :physical_address_w,
                physical_address_e = :physical_address_e,
                domain = :domain,
                d_type = :d_type,
                section = :section,
                internet_access = :internet_access,
                computer_desc = :computer_desc,
                motherboard = :motherboard,
                processor = :processor,
                storage = :storage,
                gpu = :gpu,
                operating_system = :operating_system,
                os_license = :os_license,
                memory = :memory,
                ms_os_p = :ms_os_p,
                osp_id = :osp_id,
                ms_office_pk = :ms_office_pk,
                ms_office_pid = :ms_office_pid,
                ms_office_cdk = :ms_office_cdk,
                ms_office_account_lr = :ms_office_account_lr,
                ms_office_password = :ms_office_password,
                backup_key = :backup_key,
                spp_folder = :spp_folder,
                noah_version = :noah_version,
                printer_model = :printer_model,
                printer_desc = :printer_desc,
                scanner_model = :scanner_model,
                barcode_scanner = :barcode_scanner,
                special_application = :special_application,
                client = :client,
                remarks = :remarks
            WHERE d_id = :d_id
        ");

        // Bind parameters
        $stmt->bindParam(':compname', $compname);
        $stmt->bindParam(':user_profile', $user_profile);
        $stmt->bindParam(':ipv4_address', $ipv4_address);
        $stmt->bindParam(':ipv4_status', $ipv4_status);
        $stmt->bindParam(':physical_address_w', $physical_address_w);
        $stmt->bindParam(':physical_address_e', $physical_address_e);
        $stmt->bindParam(':domain', $domain);
        $stmt->bindParam(':section', $section);
        $stmt->bindParam(':d_type', $d_type);
        $stmt->bindParam(':internet_access', $internet_access);
        $stmt->bindParam(':computer_desc', $computer_desc);
        $stmt->bindParam(':motherboard', $motherboard);
        $stmt->bindParam(':processor', $processor);
        $stmt->bindParam(':storage', $storage);
        $stmt->bindParam(':gpu', $gpu);
        $stmt->bindParam(':operating_system', $operating_system);
        $stmt->bindParam(':os_license', $os_license);
        $stmt->bindParam(':memory', $memory);
        $stmt->bindParam(':ms_os_p', $ms_os_p);
        $stmt->bindParam(':osp_id', $osp_id);
        $stmt->bindParam(':ms_office_pk', $ms_office_pk);
        $stmt->bindParam(':ms_office_pid', $ms_office_pid);
        $stmt->bindParam(':ms_office_cdk', $ms_office_cdk);
        $stmt->bindParam(':ms_office_account_lr', $ms_office_account_lr);
        $stmt->bindParam(':ms_office_password', $ms_office_password);
        $stmt->bindParam(':backup_key', $backup_key);
        $stmt->bindParam(':spp_folder', $spp_folder);
        $stmt->bindParam(':noah_version', $noah_version);
        $stmt->bindParam(':printer_model', $printer_model);
        $stmt->bindParam(':printer_desc', $printer_desc);
        $stmt->bindParam(':scanner_model', $scanner_model);
        $stmt->bindParam(':barcode_scanner', $barcode_scanner);
        $stmt->bindParam(':special_application', $special_application);
        $stmt->bindParam(':client', $client);
        $stmt->bindParam(':remarks', $remarks);
        $stmt->bindParam(':d_id', $d_id);

        // Execute
        $stmt->execute();

        $message = "Record updated successfully!";
        $status = "success";

        // Optionally redirect after success
        header("Location: inventory.php#desktop");
        exit();

    } catch (PDOException $e) {
        $message = "Error updating record: " . $e->getMessage();
        $status = "error";
    }
}
?>