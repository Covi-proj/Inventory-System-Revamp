<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$host = 'localhost';
$db = 'license_db';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (!isset($_GET['cs_id']) || !is_numeric($_GET['cs_id'])) {
    die("Invalid or missing ID.");
}

$cs_id = $_GET['cs_id'];

$sql = "SELECT * FROM tbl_compute_stick WHERE cs_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$cs_id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("No data found.");
}

$imagePath = __DIR__ . '/photos/icon.jfif';
if (file_exists($imagePath)) {
    $imageData = base64_encode(file_get_contents($imagePath));
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;
} else {
    $imageSrc = '';
}

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>IT Inventory Report</title>
<style>
    @page {
        margin: 10px 20px;
    }
    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        font-size: 7pt;
        color: #333;
        line-height: 1.3;
        margin: 0;
        padding: 0;
    }
    .header {
        display: flex;
        align-items: center;
        border-bottom: 2px solid #004085;
        padding-bottom: 5px;
        margin-bottom: 15px;
    }
    .logo {
        height: 40px;
        margin-right: 10px;
    }
    .title-block h1 {
        margin: 0;
        font-size: 14pt;
        font-weight: bold;
        color: #004085;
    }
    .title-block p {
        margin: 2px 0 0;
        font-size: 8pt;
        color: #6c757d;
        font-style: italic;
    }
    .content {
        border: 1px solid #ccc;
        padding: 10px;
        background-color: #fff;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
        table-layout: fixed;
        word-wrap: break-word;
    }
    th, td {
        padding: 4px 6px;
        border-bottom: 1px solid #ccc;
        text-align: left;
        vertical-align: top;
    }
    th {
        background-color: #004085;
        color: white;
        font-size: 7pt;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    tr:last-child td {
        border-bottom: none;
    }
    .footer {
        margin-top: 20px;
        font-size: 7pt;
        color: #6c757d;
        border-top: 1px solid #ddd;
        padding-top: 5px;
        text-align: center;
        font-style: italic;
    }
</style>

</head>
<body>
    <div class="header">
        ' . ($imageSrc ? '<img src="' . $imageSrc . '" alt="Company Logo" class="logo">' : '') . '
        <div class="title-block">
            <h1>IT Inventory Report</h1>
            <p>Compute Stick Asset Details</p>
        </div>
    </div>

    <div class="content">
        <table>
            <tr><th>Field</th><th>Information</th></tr>
            <tr><td>Client Name</td><td>' . htmlspecialchars($data['client']) . '</td></tr>
            <tr><td>Computer Name</td><td>' . htmlspecialchars($data['compname']) . '</td></tr>
            <tr><td>User Profile</td><td>' . htmlspecialchars($data['user_profile']) . '</td></tr>
            <tr><td>Section</td><td>' . htmlspecialchars($data['section']) . '</td></tr>
            <tr><td>Device Type</td><td>' . htmlspecialchars($data['d_type']) . '</td></tr>

            <tr><th>Network Details</th><th>Information</th></tr>       
     
            <tr><td>Physical Address [Wireless]</td><td>' . htmlspecialchars($data['physical_address_w']) . '</td></tr>
      
          
            <tr><td>Domain</td><td>' . htmlspecialchars($data['domain']) . '</td></tr>
            <tr><td>Internet Access</td><td>' . htmlspecialchars($data['internet_access']) . '</td></tr>


            <tr><th>Hardware Details</th><th>Information</th></tr>

           
            <tr><td>Motherboard</td><td>' . htmlspecialchars($data['motherboard']) . '</td></tr>
            <tr><td>Processor</td><td>' . htmlspecialchars($data['processor']) . '</td></tr>
            <tr><td>Memory [RAM]</td><td>' . htmlspecialchars($data['memory']) . '</td></tr>
            <tr><td>Storage [SSD / HDD]</td><td>' . htmlspecialchars($data['storage']) . '</td></tr>
    
     

            <tr><th>Software Details</th><th>Information</th></tr>

            <tr><td>Operating System</td><td>' . htmlspecialchars($data['operating_system']) . '</td></tr>
            <tr><td>OS License</td><td>' . htmlspecialchars($data['ms_office_pk']) . '</td></tr>
            <tr><td>OS Product ID</td><td>' . htmlspecialchars($data['ms_office_pid']) . '</td></tr>
            <tr><td>Microsoft Office </td><td>' . htmlspecialchars($data['ms_office']) . '</td></tr>
     

            <tr><th>Additional Details</th><th>Information</th></tr>
            <tr><td>Noah Version</td><td>' . htmlspecialchars($data['noah_version']) . '</td></tr>
         
            <tr><td>Barcode Scanner<td>' . htmlspecialchars($data['scanner_model']) . '</td></tr>

            <tr><td>Remarks</td><td>' . htmlspecialchars($data['remarks']) . '</td></tr>
          
        </table>
    </div>

</body>
</html>
';

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("inventory_item_" . $data['cs_id'] . ".pdf", ["Attachment" => false]);

$conn = null;
?>