<?php
// Database connection
include('config.php');

// Check if the 'med_id' is passed in the URL (GET request)
if (isset($_GET['d_id'])) {
    $d_id = $_GET['d_id']; // Get the medicine ID from the URL
} else {
    echo "No ID provided!";
    exit;
}

// Initialize variables for form data, in case they aren't set yet
$compname = '';
$user_profile = '';
$ipv4_address = '';
$ipv4_status = '';
$physical_address_w = '';
$physical_address_e = '';
$domain = '';
$section = '';
$d_type = '';
$internet_access = '';
$computer_desc = '';
$motherboard = '';
$processor = '';
$storage = '';
$gpu = '';
$operating_system = '';
$os_license = '';
$memory = '';
$ms_os_p = '';
$osp_id = '';
$ms_office_pk = '';
$ms_office_pid = '';
$ms_office_cdk = '';
$ms_office_account_lr = '';
$ms_office_password = '';
$backup_key = '';
$spp_folder = '';
$noah_version = '';
$printer_model = '';
$printer_desc = '';
$scanner_model = '';
$barcode_scanner = '';
$special_application = '';
$client = '';
$remarks = '';



// Check if the form is submitted (POST request)


    // If it's not a POST request, fetch the existing data for the medicine
    try {
        $stmt = $conn->prepare("SELECT * FROM tbl_desktop WHERE d_id = :d_id");
        $stmt->bindParam(':d_id', $d_id);
        $stmt->execute();
        $desktop = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($desktop) {
            $d_id = $desktop['d_id'];
            $compname = $desktop['compname'];
            $user_profile = $desktop['user_profile'];
            $ipv4_address = $desktop['ipv4_address'];
            $ipv4_status = $desktop['ipv4_status'];
            $physical_address_w = $desktop['physical_address_w'];
            $physical_address_e = $desktop['physical_address_e'];
            $domain = $desktop['domain'];
            $section = $desktop['section'];
            $d_type = $desktop['d_type'];
            $internet_access = $desktop['internet_access'];
            $computer_desc = $desktop['computer_desc'];
            $motherboard = $desktop['motherboard'];
            $processor = $desktop['processor'];
            $storage = $desktop['storage'];
            $gpu = $desktop['gpu'];
            $operating_system = $desktop['operating_system'];
            $os_license = $desktop['os_license'];
            $memory = $desktop['memory'];
            $ms_os_p = $desktop['ms_os_p'];
            $osp_id = $desktop['osp_id'];
            $ms_office_pk = $desktop['ms_office_pk'];
            $ms_office = $desktop['ms_office'];
            $ms_office_pid = $desktop['ms_office_pid'];
            $ms_office_cdk = $desktop['ms_office_cdk'];
            $ms_office_account_lr = $desktop['ms_office_account_lr'];
            $ms_office_password = $desktop['ms_office_password'];
            $backup_key = $desktop['backup_key'];
            $spp_folder = $desktop['spp_folder'];
            $noah_version = $desktop['noah_version'];
            $printer_model = $desktop['printer_model'];
            $printer_desc = $desktop['printer_desc'];
            $scanner_model = $desktop['scanner_model'];
            $barcode_scanner = $desktop['barcode_scanner'];
            $special_application = $desktop['special_application'];
            $client = $desktop['client'];
            $remarks = $desktop['remarks'];

        } else {
            $message = "No license found with this ID.";
            $status = "error";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $status = "error";
    }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="photos/icon.jfif" type="image/png">
    <title>Edit Desktop</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            max-width: 1200px;
            background: #fff;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        h3 {
            color: #0066cc;
            margin-top: 40px;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-group {
            flex: 1 1 calc(33.333% - 20px);
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #0066cc;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            margin-top: 30px;
            font-size: 16px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
            font-weight: bold;
        }

        .submit-btn:hover {
            background-color: #004999;
        }

        @media (max-width: 768px) {
            .form-group {
                flex: 1 1 100%;
            }
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Edit Desktop</h2>
        <form id="addForm" action="update_desktop.php" method="POST">

            <!-- Basic Information -->
            <h3>Basic Information</h3>
            <div class="row">
                <input type="hidden" name="d_id" value="<?= htmlspecialchars($d_id) ?>">

                 <div class="form-group">
                    <label for="client">Client</label>
                    <input type="text" id="client" name="client" placeholder="Enter Client" value="<?= htmlspecialchars($client) ?>">
                </div>

                  <div class="form-group">
                    <label for="user_profile">User Profile</label>
                    <input type="text" id="user_profile" name="user_profile" placeholder="Enter User Profile" value="<?= htmlspecialchars($user_profile) ?>">
                </div>

                  <div class="form-group">
                    <label for="section">Section</label>
                    <input type="text" id="section" name="section" placeholder="Enter Section" value="<?= htmlspecialchars($section) ?>">
                </div>


                <div class="form-group">
                    <label for="compname">Computer Name</label>
                    <input type="text" id="compname" name="compname" placeholder="Enter Computer Name" value="<?= htmlspecialchars($compname) ?>">
                </div>
              
                <div class="form-group">
                    <label for="compname">Device Type</label>
                    <input type="text" id="d_type" name="d_type" placeholder="Enter Device Type" value="<?= htmlspecialchars($d_type) ?>">
                </div>

              
            </div>

            <!-- Network Details -->
            <h3>Network Details</h3>
            <div class="row">

              <div class="form-group">
                    <label for="ipv4_address">IPv4 Address</label>
                    <input type="text" id="ipv4_address" name="ipv4_address" placeholder="Enter IPv4 Address" value="<?= htmlspecialchars($ipv4_address) ?>">
                </div>
                <div class="form-group">
                    <label for="ipv4_status">IPv4 Status</label>
                    <input type="text" id="ipv4_status" name="ipv4_status" placeholder="Enter IPv4 Status" value="<?= htmlspecialchars($ipv4_status) ?>">
                </div>
                <div class="form-group">
                    <label for="physical_address_w">Physical Address [Wireless]</label>
                    <input type="text" id="physical_address_w" name="physical_address_w"
                        placeholder="Enter Wireless Address" value="<?= htmlspecialchars($physical_address_w) ?>">
                </div>
                <div class="form-group">
                    <label for="physical_address_e">Physical Address [Ethernet]</label>
                    <input type="text" id="physical_address_e" name="physical_address_e"
                        placeholder="Enter Ethernet Address" value="<?= htmlspecialchars($physical_address_e) ?>">
                </div>

                <div class="form-group">
                    <label for="domain">Domain</label>
                    <input type="text" id="domain" name="domain" placeholder="Enter Domain" value="<?= htmlspecialchars($domain) ?>">
                </div>

             

                <div class="form-group">
                    <label for="physical_address_e">Internet Access</label>
                    <input type="text" id="section" name="internet_access" placeholder="Enter Internet Access" value="<?= htmlspecialchars($internet_access) ?>">
                </div>
            </div>

            <!-- Hardware Details -->
            <h3>Hardware Details</h3>
            <div class="row">

                

                <div class="form-group">
                    <label for="computer_desc">Computer Description</label>
                    <input type="text" id="computer_desc" name="computer_desc"
                        placeholder="Enter Description" value="<?= htmlspecialchars($computer_desc) ?>">
                </div>

                <div class="form-group">
                    <label for="motherboard">Motherboard</label>
                    <input type="text" id="motherboard" name="motherboard" placeholder="Enter Motherboard" value="<?= htmlspecialchars($motherboard) ?>">
                </div>
                <div class="form-group">
                    <label for="processor">Processor</label>
                    <input type="text" id="processor" name="processor" placeholder="Enter Processor" value="<?= htmlspecialchars($processor) ?>">
                </div>
                <div class="form-group">
                    <label for="memory">Memory</label>
                    <input type="text" id="memory" name="memory" placeholder="Enter Memory" value="<?= htmlspecialchars($memory) ?>">
                </div>
                <div class="form-group">
                    <label for="storage">Storage</label>
                    <input type="text" id="storage" name="storage" placeholder="Enter Storage" value="<?= htmlspecialchars($storage) ?>">
                </div>
                <div class="form-group">
                    <label for="gpu">GPU</label>
                    <input type="text" id="gpu" name="gpu" placeholder="Enter GPU" value="<?= htmlspecialchars($gpu) ?>">
                </div>
                <div class="form-group">
                    <label for="operating_system">Operating System</label>
                    <input type="text" id="operating_system" name="operating_system"
                        placeholder="Enter Operating System" value="<?= htmlspecialchars($operating_system) ?>">
                </div>
                  <div class="form-group">
                    <label for="operating_system">OS License</label>
                    <input type="text" id="os_license" name="os_license"
                        placeholder="Enter Operating System" value="<?= htmlspecialchars($os_license) ?>">
                </div>
            </div>

            <!-- Software Details -->
            <h3>Software Details</h3>
            <div class="row">
                <div class="form-group">
                    <label for="ms_os_p">MS OS Product ID</label>
                    <input type="text" id="ms_os_p" name="ms_os_p" placeholder="Enter MS OS Product ID" value="<?= htmlspecialchars($ms_os_p) ?>"> 
                </div>
                <div class="form-group">
                    <label for="osp_id">Operating System Product Key</label>
                    <input type="text" id="osp_id" name="osp_id" placeholder="Enter OS Product Key" value="<?= htmlspecialchars($osp_id) ?>">
                </div>

                <div class="form-group">
                    <label for="osp_id">Microsoft Office</label>
                    <input type="text" id="ms_office" name="ms_office" placeholder="Enter OS Product Key" value="<?= htmlspecialchars($ms_office) ?>">
                </div>
                <div class="form-group">
                    <label for="ms_office_pk">Ms Office Product Key</label>
                    <input type="text" id="ms_office_pk" name="ms_office_pk" placeholder="Enter MS Office Product Key" value="<?= htmlspecialchars($ms_office_pk) ?>">
                </div>

                <div class="form-group">
                    <label for="ms_office_pid">Ms Office Product ID</label>
                    <input type="text" id="ms_office_pid" name="ms_office_pid" placeholder="Enter MS Office Product ID" value="<?= htmlspecialchars($ms_office_pid) ?>">
                </div>

                <div class="form-group">
                    <label for="ms_office_cdk">Ms Office CD Key</label>
                    <input type="text" id="ms_office_cdk" name="ms_office_cdk" placeholder="Enter MS Office CD Key" value="<?= htmlspecialchars($ms_office_cdk) ?>">
                </div>

                <div class="form-group">
                    <label for="ms_office_account_lr">Ms Office Account License Recovery</label>
                    <input type="text" id="ms_office_account_lr" name="ms_office_account_lr"
                        placeholder="Enter MS Office Account License Recovery" value="<?= htmlspecialchars($ms_office_account_lr) ?>">
                </div>

                <div class="form-group">
                    <label for="ms_office_account_lr">Ms Office Passsword License Recovery</label>
                    <input type="text" id="ms_office_password" name="ms_office_password"
                        placeholder="Enter MS Office Password License Recovery" value="<?= htmlspecialchars($ms_office_password) ?>">
                </div>

                  <div class="form-group">
                    <label for="ms_office_account_lr">Ms License Backup(SPP Folder)</label>
                    <input type="text" id="spp_folder" name="spp_folder"
                        placeholder="Enter MS License Backup(SPP Folder)" value="<?= htmlspecialchars($spp_folder) ?>">
                </div>

                <div class="form-group">
                    <label for="backup_key">Backup Key</label>
                    <input type="text" id="backup_key" name="backup_key" placeholder="Enter Backup Key" value="<?= htmlspecialchars($backup_key) ?>">
                </div>

                <div class="form-group">
                    <label for="noah_version">NOAH Key</label>
                    <input type="text" id="noah_version" name="noah_version" placeholder="Enter NOAH Key" value="<?= htmlspecialchars($noah_version) ?>">
                </div>


            </div>

            <!-- Additional Details -->
            <h3>Additional Details</h3>
            <div class="row">
                <div class="form-group">
                    <label for="printer_model">Printer Model</label>
                    <input type="text" id="printer_model" name="printer_model" placeholder="Enter Printer Model" value="<?= htmlspecialchars($printer_model) ?>">
                </div>
                <div class="form-group">
                    <label for="printer_desc">Printer Description</label>
                    <input type="text" id="printer_desc" name="printer_desc" placeholder="Enter Printer Description" value="<?= htmlspecialchars($printer_desc) ?>">
                </div>

                <div class="form-group">
                    <label for="scanner_model">Scanner Model</label>
                    <input type="text" id="scanner_model" name="scanner_model" placeholder="Enter Scanner Model" value="<?= htmlspecialchars($scanner_model) ?>">
                </div>

                <div class="form-group">
                    <label for="barcode_scanner">Barcode Scanner</label>
                    <input type="text" id="barcode_scanner" name="barcode_scanner" placeholder="Enter Scanner" value="<?= htmlspecialchars($barcode_scanner) ?>">
                </div>

                <div class="form-group">
                    <label for="special_application">Special Application with License</label>
                    <input type="text" id="special_application" name="special_application"
                        placeholder="Enter Application" value="<?= htmlspecialchars($special_application) ?>">
                </div>

               
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <input type="text" id="remarks" name="remarks" placeholder="Enter Remarks" value="<?= htmlspecialchars($remarks) ?>">
                </div>

            </div>

            <!-- Submit Button -->

            <div class="row">
                <div class="form-group">
                    <button type="submit" class="submit-btn">Save Desktop</button>
                </div>

                <div class="form-group">
                    <button class="submit-btn" type="button" onclick="window.location.href='inventory.php#desktop'"
                        style="background-color: red;">Cancel</button>
                </div>
            </div>

        </form>
    </div>

</body>

</html>