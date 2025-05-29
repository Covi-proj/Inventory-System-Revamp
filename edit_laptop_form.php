<?php
// Database connection
include('config.php');

// Check if the 'med_id' is passed in the URL (GET request)
if (isset($_GET['l_id'])) {
    $l_id = $_GET['l_id']; // Get the medicine ID from the URL
} else {
    echo "No ID provided!";
    exit;
}

// Initialize variables for form data, in case they aren't set yet
$client = '';
$section = '';
$d_type = '';
$mac_address = '';
$ipv4_address = '';
$ipv4_status = '';
$physical_address = '';
$domain = '';
$os_license = '';
$ms_office = '';
$spp_folder = '';
$special_app = '';
$bavkup_key = '';
$noah = '';

$computer_name = '';
$user_profile = '';
$laptop_model = '';
$mac_address = '';
$motherboard = '';
$processor = '';
$memory = '';
$storage = '';
$gpu = '';
$operating_system = '';
$ms_os_product_id = '';
$os_pk = '';
$ms_office = '';
$ms_office_pid = '';
$ms_office_pk = '';
$ms_office_lr = '';
$ms_office_p = '';
$backup_key = '';
$date_purchase = '';
$warranty_card = '';
$printer_model = '';
$barcode_scanner = '';
$remarks = '';



// Check if the form is submitted (POST request)


    // If it's not a POST request, fetch the existing data for the medicine
    try {
        $stmt = $conn->prepare("SELECT * FROM tbl_laptop WHERE l_id = :l_id");
        $stmt->bindParam(':l_id', $l_id);
        $stmt->execute();
        $desktop = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($desktop) {
            $l_id = $desktop['l_id'];
            $computer_name = $desktop['computer_name'];
            $client = $desktop['client'];
            $section = $desktop['section'];
            $d_type = $desktop['d_type'];
            $ipv4_address = $desktop['ipv4_address'];
            $ipv4_status = $desktop['ipv4_status'];
            $physical_address = $desktop['physical_address'];
            $domain = $desktop['domain'];
            $spp_folder = $desktop['spp_folder'];
            $special_app = $desktop['special_app'];
            $noah = $desktop['noah'];
            $user_profile = $desktop['user_profile'];
            $laptop_model = $desktop['laptop_model'];
            $mac_address = $desktop['mac_address'];
            $motherboard = $desktop['motherboard'];
            $processor = $desktop['processor'];
            $memory = $desktop['memory'];
            $storage = $desktop['storage'];
            $os_license = $desktop['os_license'];
            $gpu = $desktop['gpu'];
            $operating_system = $desktop['operating_system'];
            $ms_os_product_id = $desktop['ms_os_product_id'];
            $os_pk = $desktop['os_pk'];
            $ms_office = $desktop['ms_office'];
            $ms_office_pid = $desktop['ms_office_pid'];
            $ms_office_pk = $desktop['ms_office_pk'];
            $ms_office_lr = $desktop['ms_office_lr'];
            $ms_office_p = $desktop['ms_office_p'];
            $backup_key = $desktop['backup_key'];
            $date_purchase = $desktop['date_purchase'];
            $warranty_card = $desktop['warranty_card'];
            $printer_model = $desktop['printer_model'];
            $barcode_scanner = $desktop['barcode_scanner'];
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
    <title>Edit Laptop</title>
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
        <h2>Edit Laptop</h2>
        <form id="addForm" action="update_laptop.php" method="POST">

            <!-- Basic Information -->
            <h3>Basic Information</h3>
            <div class="row">
            <input type="hidden" id="l_id" name="l_id" value="<?php echo $l_id; ?>">
                <div class="form-group">
                    <label for="compname">Computer Name</label>
                    <input type="text" id="computer_name" name="computer_name" placeholder="Enter Computer Name" value="<?php echo $computer_name; ?>">
                </div>
                <div class="form-group">
                    <label for="user_profile">User Profile</label>
                    <input type="text" id="user_profile" name="user_profile" placeholder="Enter User Profile" value="<?php echo $user_profile; ?>">
                </div>

                <div class="form-group">
                    <label for="user_profile">Client</label>
                    <input type="text" id="user_profile" name="client" placeholder="Enter User Profile" value="<?php echo $client; ?>">
                </div>

                <div class="form-group">
                    <label for="user_profile">Section</label>
                    <input type="text" id="section" name="section" placeholder="Enter User Profile" value="<?php echo $section; ?>">
                </div>

                <div class="form-group">
                    <label for="laptop_model">Brand and Model</label>
                    <input type="text" id="laptop_model" name="laptop_model" placeholder="Enter Brand and Model" value="<?php echo $laptop_model; ?>">
                </div>

                <div class="form-group">
                    <label for="user_profile">Type of Device</label>
                    <input type="text" id="d_type" name="d_type" placeholder="Enter User Profile" value="<?php echo $user_profile; ?>">
                </div>

                
            </div>

            <!-- Network Details -->
            <h3>Network Details</h3>
            <div class="row">
                
                <div class="form-group">
                    <label for="physical_address_w">Mac Address</label>
                    <input type="text" id="mac_address" name="mac_address" placeholder="Enter Wireless Address" value="<?php echo $mac_address; ?>">
                </div>

                  <div class="form-group">
                    <label for="physical_address_w">IPV4 Address</label>
                    <input type="text" id="ipv4_address" name="ipv4_address" placeholder="Enter IPV4 Address" value="<?php echo $ipv4_address; ?>">
                </div>

                <div class="form-group">
                    <label for="physical_address_w">IPV4 Status</label>
                    <input type="text" id="ipv4_status" name="ipv4_status" placeholder="Enter IPV4 Status" value="<?php echo $ipv4_status; ?>">
                </div>

                <div class="form-group">
                    <label for="physical_address_w">Physical Address [Enthernet]</label>
                    <input type="text" id="ipv4_status" name="physical_address" placeholder="Enter IPV4 Status" value="<?php echo $physical_address; ?>"> 
                </div>

                <div class="form-group">
                    <label for="physical_address_w">Domain</label>
                    <input type="text" id="domain" name="domain" placeholder="Enter Domain" value="<?php echo $domain; ?>">
                </div>
                
            </div>

            <!-- Hardware Details -->
            <h3>Hardware Details</h3>
            <div class="row">

               
                <div class="form-group">
                    <label for="motherboard">Motherboard</label>
                    <input type="text" id="motherboard" name="motherboard" placeholder="Enter Motherboard" value="<?php echo $motherboard; ?>">
                </div>
                <div class="form-group">
                    <label for="processor">Processor</label>
                    <input type="text" id="processor" name="processor" placeholder="Enter Processor" value="<?php echo $processor; ?>">
                </div>
                <div class="form-group">
                    <label for="memory">Memory</label>
                    <input type="text" id="memory" name="memory" placeholder="Enter Memory" value="<?php echo $memory; ?>">
                </div>
                <div class="form-group">
                    <label for="storage">Storage</label>
                    <input type="text" id="storage" name="storage" placeholder="Enter Storage" value="<?php echo $storage; ?>">
                </div>

                <div class="form-group">
                    <label for="storage">Graphic Processing Unit</label>
                    <input type="text" id="gpu" name="gpu" placeholder="Enter GPU" value="<?php echo $gpu; ?>">
                </div>
               
                <div class="form-group">
                    <label for="operating_system">Operating System</label>
                    <input type="text" id="operating_system" name="operating_system"
                        placeholder="Enter Operating System" value="<?php echo $operating_system; ?>">
                </div>
            </div>

            <!-- Software Details -->
            <h3>Software Details</h3>
            <div class="row">
                <div class="form-group">
                    <label for="ms_os_p">OS License</label>
                    <input type="text" id="os_license" name="os_license" placeholder="Enter MS OS Product ID" value="<?php echo $os_license; ?>">
                </div>

                <div class="form-group">
                    <label for="ms_os_p">MS OS Product ID</label>
                    <input type="text" id="ms_os_product_id" name="ms_os_product_id" placeholder="Enter MS OS Product ID" value="<?php echo $ms_os_product_id; ?>">
                </div>

                <div class="form-group">
                    <label for="os_pk">Operating System Product Key</label>
                    <input type="text" id="os_pk" name="os_pk" placeholder="Enter OS Product Key" value="<?php echo $os_pk; ?>">
                </div>

                 <div class="form-group">
                    <label for="ms_office">Microsoft Office</label>
                    <input type="text" id="ms_office" name="ms_office" placeholder="Enter Microsoft Office" value="<?php echo $ms_office; ?>">
                </div>

                <div class="form-group">
                    <label for="ms_office">Microsoft Office</label>
                    <input type="text" id="ms_office" name="ms_office" placeholder="Enter Microsoft Office" value="<?php echo $ms_office; ?>">
                </div>

                <div class="form-group">
                    <label for="ms_office_pid">Ms Office Product ID</label>
                    <input type="text" id="ms_office_pid" name="ms_office_pid" placeholder="Enter MS Office Product ID" value="<?php echo $ms_office_pid; ?>">
                </div>

                
                <div class="form-group">
                    <label for="physical_address_w">MS License Backup(SPP Folder)</label>
                    <input type="text" id="spp_folder" name="spp_folder" placeholder="Enter IPV4 Status" value="<?php echo $spp_folder; ?>">
                </div>



                <div class="form-group">
                    <label for="ms_office_pk">Ms Office Product Key</label>
                    <input type="text" id="ms_office_pk" name="ms_office_pk" placeholder="Enter MS Office Product Key" value="<?php echo $ms_office_pk; ?>">
                </div>

                <div class="form-group">
                    <label for="ms_office_lr">Ms Office Account License Recovery</label>
                    <input type="text" id="ms_office_lr" name="ms_office_lr"
                        placeholder="Enter MS Office Account License Recovery" value="<?php echo $ms_office_lr; ?>">
                </div>

                <div class="form-group">
                    <label for="ms_office_p">Ms Office Passsword License Recovery</label>
                    <input type="text" id="ms_office_p" name="ms_office_p"
                        placeholder="Enter MS Office Password License Recovery" value="<?php echo $ms_office_p; ?>">
                </div>

                <div class="form-group">
                    <label for="backup_key">MS License Backup Email(Backup Key)</label>
                    <input type="text" id="backup_key" name="backup_key" placeholder="Enter Backup Key" value="<?php echo $backup_key; ?>">
                </div>

            

            </div>

            <!-- Additional Details -->
            <h3>Additional Details</h3>
            <div class="row">

            
                <div class="form-group">
                    <label for="special_app">Special Application with License</label>
                    <input type="text" id="special_app" name="special_app" placeholder="Enter Special Application" value="<?php echo $special_app; ?>">
                </div>

            <div class="form-group">
                    <label for="date_purchase">Date Purchase</label>
                    <input type="date" id="date_purchase" name="date_purchase" value="<?php echo $date_purchase; ?>">
                </div>

                <div class="form-group">
                    <label for="warranty_card">Warranty Card</label>
                    <input type="text" id="warranty_card" name="warranty_card" placeholder="Enter Remarks" value="<?php echo $warranty_card; ?>">
                </div>

                  <div class="form-group">
                    <label for="warranty_card">Printer Model</label>
                    <input type="text" id="printel_model" name="printer_model" placeholder="Enter Printer Model" value="<?php echo $printer_model; ?>">
                </div>

                <div class="form-group">
                    <label for="warranty_card">Barcode Scanner</label>
                    <input type="text" id="barcode_scanner" name="barcode_scanner" placeholder="Enter Barcode Scanner" value="<?php echo $barcode_scanner; ?>">
                </div>

                   <div class="form-group">
                    <label for="warranty_card">Noah</label>
                    <input type="text" id="noah" name="noah" placeholder="Enter Remarks" value="<?php echo $noah; ?>">
                </div>

                
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <input type="text" id="remarks" name="remarks" placeholder="Enter Remarks" value="<?php echo $remarks; ?>">
                </div>

            </div>

            <!-- Submit Button -->

            <div class="row">
                <div class="form-group">
                    <button type="submit" class="submit-btn">Save</button>
                </div>

                <div class="form-group">
                    <button class="submit-btn" type="button" onclick="window.location.href='inventory.php#laptop'" 
                        style="background-color: red;">Cancel</button>
                </div>
            </div>

        </form>
    </div>

</body>

</html>