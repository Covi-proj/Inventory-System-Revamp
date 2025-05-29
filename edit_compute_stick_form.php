<?php
// Database connection
include('config.php');

// Check if the 'med_id' is passed in the URL (GET request)
if (isset($_GET['cs_id'])) {
    $cs_id = $_GET['cs_id']; // Get the medicine ID from the URL
} else {
    echo "No ID provided!";
    exit;
}

// Initialize variables for form data, in case they aren't set yet
$compname = '';
$user_profile = '';

$physical_address_w = '';
$physical_address_e = '';
$ipv4_address = '';
$ipv4_status = '';
$d_type = '';

$domain = '';
$section = '';
$internet_access = '';
$computer_desc = '';
$motherboard = '';
$processor = '';
$storage = '';

$operating_system = '';
$memory = '';
$ms_os_p = '';
$osp_id = '';
$ms_office_pk = '';
$ms_office_pid = '';
$ms_office_cdk = '';
$ms_office_account_lr = '';
$ms_office_password = '';
$backup_key = '';
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
    $stmt = $conn->prepare("SELECT * FROM tbl_compute_stick WHERE cs_id = :cs_id");
    $stmt->bindParam(':cs_id', $cs_id);
    $stmt->execute();
    $desktop = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($desktop) {
        $cs_id = $desktop['cs_id'];
        $compname = $desktop['compname'];
        $user_profile = $desktop['user_profile'];

        $physical_address_w = $desktop['physical_address_w'];
        $physical_address_e = $desktop['physical_address_e'];
        $ipv4_address = $desktop['ipv4_address'];
        $ipv4_status = $desktop['ipv4_status'];

        $domain = $desktop['domain'];
        $section = $desktop['section'];
        $d_type = $desktop['d_type'];
        $internet_access = $desktop['internet_access'];
        $computer_desc = $desktop['computer_desc'];
        $motherboard = $desktop['motherboard'];
        $processor = $desktop['processor'];
        $storage = $desktop['storage'];

        $operating_system = $desktop['operating_system'];
        $memory = $desktop['memory'];
        $ms_os_p = $desktop['ms_os_p'];
        $osp_id = $desktop['osp_id'];
        $ms_office = $desktop['ms_office'];
        $ms_office_pk = $desktop['ms_office_pk'];
        $ms_office_pid = $desktop['ms_office_pid'];
        $ms_office_cdk = $desktop['ms_office_cdk'];
        $ms_office_account_lr = $desktop['ms_office_account_lr'];
        $ms_office_password = $desktop['ms_office_password'];
        $backup_key = $desktop['backup_key'];
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
    <title>Edit Compute Stick</title>
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
        <h2>Edit Compute Stick</h2>
        <form id="addForm" action="update_compute_stick.php" method="POST">

            <!-- Basic Information -->
            <h3>Basic Information</h3>
            <div class="row">
                <input type="hidden" name="cs_id" value="<?= htmlspecialchars($cs_id) ?>">
                <div class="form-group">
                    <label for="compname">Computer Name</label>
                    <input type="text" id="compname" name="compname" placeholder="Enter Computer Name"
                        value="<?= htmlspecialchars($compname) ?>">
                </div>
                <div class="form-group">
                    <label for="user_profile">User Profile</label>
                    <input type="text" id="user_profile" name="user_profile" placeholder="Enter User Profile"
                        value="<?= htmlspecialchars($user_profile) ?>">
                </div>

                <div class="form-group">
                    <label for="section">Section</label>
                    <input type="text" id="section" name="section" placeholder="Enter Section" value="<?= htmlspecialchars($section) ?>">
                </div>

                <div class="form-group">
                    <label for="section">Device Type</label>
                    <input type="text" id="d_type" name="d_type" placeholder="Enter Device Type" value="<?= htmlspecialchars($d_type) ?>">
                </div>


            </div>

            <!-- Network Details -->
            <h3>Network Details</h3>
            <div class="row">

                <div class="form-group">
                    <label for="physical_address_w">Physical Address [Wireless]</label>
                    <input type="text" id="physical_address_w" name="physical_address_w"
                        placeholder="Enter Wireless Address" value="<?= htmlspecialchars($physical_address_w) ?>">
                </div>

                  

                


                <div class="form-group">
                    <label for="domain">Domain</label>
                    <input type="text" id="domain" name="domain" placeholder="Enter Domain"
                        value="<?= htmlspecialchars($domain) ?>">
                </div>



                <div class="form-group">
                    <label for="physical_address_e">Internet Access</label>
                    <input type="text" id="section" name="internet_access" placeholder="Enter Internet Access"
                        value="<?= htmlspecialchars($internet_access) ?>">
                </div>
            </div>

            <!-- Hardware Details -->
            <h3>Hardware Details</h3>
            <div class="row">

                
                <div class="form-group">
                    <label for="motherboard">Motherboard</label>
                    <input type="text" id="motherboard" name="motherboard" placeholder="Enter Motherboard"
                        value="<?= htmlspecialchars($motherboard) ?>">
                </div>
                <div class="form-group">
                    <label for="processor">Processor</label>
                    <input type="text" id="processor" name="processor" placeholder="Enter Processor"
                        value="<?= htmlspecialchars($processor) ?>">
                </div>
                <div class="form-group">
                    <label for="memory">Memory</label>
                    <input type="text" id="memory" name="memory" placeholder="Enter Memory"
                        value="<?= htmlspecialchars($memory) ?>">
                </div>
                <div class="form-group">
                    <label for="storage">Storage</label>
                    <input type="text" id="storage" name="storage" placeholder="Enter Storage"
                        value="<?= htmlspecialchars($storage) ?>">
                </div>

                <div class="form-group">
                    <label for="operating_system">Operating System</label>
                    <input type="text" id="operating_system" name="operating_system"
                        placeholder="Enter Operating System" value="<?= htmlspecialchars($operating_system) ?>">
                </div>
            </div>

            <!-- Software Details -->
            <h3>Software Details</h3>
            <div class="row">
              
                <div class="form-group">
                    <label for="osp_id">Operating System Product Key</label>
                    <input type="text" id="osp_id" name="osp_id" placeholder="Enter OS Product Key"
                        value="<?= htmlspecialchars($osp_id) ?>">
                </div>
                <div class="form-group">
                    <label for="ms_office">MS Office</label>
                    <input type="text" id="ms_office" name="ms_office" placeholder="Enter MS Office"
                        value="<?= htmlspecialchars($ms_office) ?>">
                </div>

                <div class="form-group">
                    <label for="ms_office_pk">Ms Office Product Key</label>
                    <input type="text" id="ms_office_pk" name="ms_office_pk" placeholder="Enter MS Office Product Key"
                        value="<?= htmlspecialchars($ms_office_pk) ?>">
                </div>

                <div class="form-group">
                    <label for="ms_office_pid">Ms Office Product ID</label>
                    <input type="text" id="ms_office_pid" name="ms_office_pid" placeholder="Enter MS Office Product ID"
                        value="<?= htmlspecialchars($ms_office_pid) ?>">
                </div>

               

                <div class="form-group">
                    <label for="ms_office_account_lr">Ms Office Account License Recovery</label>
                    <input type="text" id="ms_office_account_lr" name="ms_office_account_lr"
                        placeholder="Enter MS Office Account License Recovery"
                        value="<?= htmlspecialchars($ms_office_account_lr) ?>">
                </div>


               
                <div class="form-group">
                    <label for="noah_version">NOAH Version</label>
                    <input type="text" id="noah_version" name="noah_version" placeholder="Enter NOAH Key"
                        value="<?= htmlspecialchars($noah_version) ?>">
                </div>


            </div>

            <!-- Additional Details -->
            <h3>Additional Details</h3>
            <div class="row">
              
                <div class="form-group">
                    <label for="barcode_scanner">Barcode Scanner</label>
                    <input type="text" id="barcode_scanner" name="barcode_scanner" placeholder="Enter Scanner"
                        value="<?= htmlspecialchars($barcode_scanner) ?>">
                </div>

               
                <div class="form-group">
                    <label for="client">Client</label>
                    <input type="text" id="client" name="client" placeholder="Enter Client"
                        value="<?= htmlspecialchars($client) ?>">
                </div>

                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <input type="text" id="remarks" name="remarks" placeholder="Enter Remarks"
                        value="<?= htmlspecialchars($remarks) ?>">
                </div>

            </div>

            <!-- Submit Button -->

            <div class="row">
                <div class="form-group">
                    <button type="submit" class="submit-btn">Save</button>
                </div>

                <div class="form-group">
                    <button class="submit-btn" type="button"
                        onclick="window.location.href='inventory.php#compute_stick'"
                        style="background-color: red;">Cancel</button>
                </div>
            </div>

        </form>
    </div>

</body>

</html>