<?php
// --- Update Desktop Record ---

// Include database connection
include 'config.php'; // adjust path if needed

// Initialize message variables
$message = "";
$status = "";

// Check if both GET and POST requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['l_id'])) {
    $l_id = $_GET['l_id'];

    // Fetch existing data
    try {
        $stmt = $conn->prepare("SELECT * FROM tbl_laptop WHERE l_id = :l_id");
        $stmt->bindParam(':l_id', $l_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Load the existing values to variables
            $client = $row['client'];
            $d_type = $row['d_type'];
            $section = $row['section'];
            $ipv4_address = $row['ipv4_address'];
            $ipv4_status = $row['ipv4_status'];
            $physical_address = $row['physical_address'];
            $domain = $row['domain'];
            $section = $row['section'];
            $os_license = $row['os_license'];
            $ms_office = $row['ms_office'];
            $spp_folder = $row['spp_folder'];
            $backup_key = $row['backup_key'];
            $noah = $row['noah'];
            $special_app = $row['special_app'];

            $computer_name = $row['computer_name'];
            $user_profile = $row['user_profile'];
            $mac_address = $row['mac_address'];
            $laptop_model = $row['laptop_model'];
            $motherboard = $row['motherboard'];
            $processor = $row['processor'];
            $storage = $row['storage'];
            $gpu = $row['gpu'];
            $operating_system = $row['operating_system'];
            $memory = $row['memory'];
            $ms_os_product_id = $row['ms_os_product_id'];
            $os_pk = $row['os_pk'];
            $ms_office = $row['ms_office'];
            $ms_office_pid = $row['ms_office_pid'];
            $ms_office_pk = $row['ms_office_pk'];
            $ms_office_lr = $row['ms_office_lr'];
            $ms_office_p = $row['ms_office_p'];
            $backup_key = $row['backup_key'];
            $date_purchased = $row['date_purchased'];
            $warranty = $row['warranty'];
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['l_id'])) {
    $l_id = $_POST['l_id'];
    $client = $_POST['client'];
    $d_type = $_POST['d_type'];
    $section = $_POST['section'];
    $ipv4_address = $_POST['ipv4_address'];
    $ipv4_status = $_POST['ipv4_status'];
    $physical_address = $_POST['physical_address'];
    $domain = $_POST['domain'];
    $section = $_POST['section'];
    $os_license = $_POST['os_license'];
    $ms_office = $_POST['ms_office'];
    $spp_folder = $_POST['spp_folder'];
    $noah = $_POST['noah'];
    $special_app = $_POST['special_app'];
    $computer_name = $_POST['computer_name'];
    $user_profile = $_POST['user_profile'];
    $mac_address = $_POST['mac_address'];
    $laptop_model = $_POST['laptop_model'];
    $motherboard = $_POST['motherboard'];
    $processor = $_POST['processor'];
    $storage = $_POST['storage'];
    $gpu = $_POST['gpu'];
    $operating_system = $_POST['operating_system'];
    $memory = $_POST['memory'];
    $ms_os_product_id = $_POST['ms_os_product_id'];
    $os_pk = $_POST['os_pk'];
    $ms_office = $_POST['ms_office'];
    $ms_office_pid = $_POST['ms_office_pid'];
    $ms_office_pk = $_POST['ms_office_pk'];
    $ms_office_lr = $_POST['ms_office_lr'];
    $ms_office_p = $_POST['ms_office_p'];
    $backup_key = $_POST['backup_key'];
    $date_purchase = $_POST['date_purchase'];
    $warranty_card = $_POST['warranty_card'];
    $printer_model = $_POST['printer_model'];
    $barcode_scanner = $_POST['barcode_scanner'];
    $remarks = $_POST['remarks'];

    // Get updated form data
   

    // Update query
    try {
        $stmt = $conn->prepare("
            UPDATE tbl_laptop SET 
                client = :client,
                d_type = :d_type,
                section = :section,
                ipv4_address = :ipv4_address,
                ipv4_status = :ipv4_status,
                physical_address = :physical_address,
                domain = :domain,
                os_license = :os_license,
                ms_office = :ms_office,
                spp_folder = :spp_folder,
                noah = :noah,
                special_app = :special_app,
              computer_name = :computer_name,
                user_profile = :user_profile,
                mac_address = :mac_address,
                laptop_model = :laptop_model,
                motherboard = :motherboard,
                processor = :processor,
                storage = :storage,
                gpu = :gpu,
                operating_system = :operating_system,
                memory = :memory,
                ms_os_product_id = :ms_os_product_id,
                os_pk = :os_pk,
                os_license = :os_license,
                ms_office = :ms_office,
                ms_office_pid = :ms_office_pid,
                ms_office_pk = :ms_office_pk,
                ms_office_lr = :ms_office_lr,
                ms_office_p = :ms_office_p,
                backup_key = :backup_key,
                date_purchase = :date_purchase,
                warranty_card = :warranty_card,
                printer_model = :printer_model,
                barcode_scanner = :barcode_scanner,
                remarks = :remarks

            WHERE l_id = :l_id
        ");

        // Bind parameters
        $stmt->bindParam(':client', $client);
        $stmt->bindParam(':d_type', $d_type);
        $stmt->bindParam(':section', $section);
        $stmt->bindParam(':ipv4_address', $ipv4_address);
        $stmt->bindParam(':ipv4_status', $ipv4_status);

        $stmt->bindParam(':physical_address', $physical_address);
        $stmt->bindParam(':domain', $domain);
        $stmt->bindParam(':os_license', $os_license);
        $stmt->bindParam(':ms_office', $ms_office);
        $stmt->bindParam(':spp_folder', $spp_folder);
        $stmt->bindParam(':noah', $noah);
        $stmt->bindParam(':special_app', $special_app);
        $stmt->bindParam(':computer_name', $computer_name);
        $stmt->bindParam(':os_license', $os_license);
        $stmt->bindParam(':user_profile', $user_profile);
        $stmt->bindParam(':mac_address', $mac_address);
        $stmt->bindParam(':laptop_model', $laptop_model);
        $stmt->bindParam(':motherboard', $motherboard);
        $stmt->bindParam(':processor', $processor);
        $stmt->bindParam(':storage', $storage);
        $stmt->bindParam(':gpu', $gpu);
        $stmt->bindParam(':operating_system', $operating_system);
        $stmt->bindParam(':memory', $memory);
        $stmt->bindParam(':ms_os_product_id', $ms_os_product_id);
        $stmt->bindParam(':os_pk', $os_pk);
        $stmt->bindParam(':ms_office', $ms_office);
        $stmt->bindParam(':ms_office_pid', $ms_office_pid);
        $stmt->bindParam(':ms_office_pk', $ms_office_pk);
        $stmt->bindParam(':ms_office_lr', $ms_office_lr);
        $stmt->bindParam(':ms_office_p', $ms_office_p);
        $stmt->bindParam(':backup_key', $backup_key);
        $stmt->bindParam(':date_purchase', $date_purchase);
        $stmt->bindParam(':warranty_card', $warranty_card);
        $stmt->bindParam(':printer_model', $printer_model);
        $stmt->bindParam(':barcode_scanner', $barcode_scanner);
        $stmt->bindParam(':remarks', $remarks);
        // Bind the l_id parameter
        // Ensure l_id is bound last to avoid confusion with other parameters
        
        $stmt->bindParam(':l_id', $l_id);

        // Execute
        $stmt->execute();

        $message = "Record updated successfully!";
        $status = "success";

        // Optionally redirect after success
        header("Location: inventory.php#laptop"); exit();

    } catch (PDOException $e) {
        $message = "Error updating record: " . $e->getMessage();
        $status = "error";
    }
}
?>