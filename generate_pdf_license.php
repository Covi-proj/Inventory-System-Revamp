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

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid or missing ID.");
}

$id = $_GET['id'];

$sql = "SELECT * FROM licenses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
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
        font-size: 12pt;
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
        font-size: 12pt;
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
        ' . ($imageSrc ? '<img src="' . $imageSrc . '" alt="Company Logo" class="logo" style="height:70px;width:auto;">' : '') . '
        <div class="title-block">
            <h1>IT Inventory Report</h1>
            <p>License Asset Details</p>
        </div>
    </div>

    <div class="content">
        <table>
            <tr><th style="font-size:14pt;">Field</th><th style="font-size:14pt;">Information</th></tr>
              <tr><td>Type Of License</td><td>' . htmlspecialchars($data['type_of_license']) . '</td></tr>
                <tr><td>License</td><td>' . htmlspecialchars($data['lisence']) . '</td></tr>
                <tr><td>Product ID | Activation Code | Request Code | License Key</td><td>' . htmlspecialchars($data['license_key']) . '</td></tr>
                <tr><td>Remarks</td><td>' . htmlspecialchars($data['remark']) . '</td></tr>
                <tr><td>Computer Name</td><td>' . htmlspecialchars($data['computer_name']) . '</td></tr>
                <tr><td>Account</td><td>' . htmlspecialchars($data['ms_account']) . '</td></tr>
                <tr><td>Password</td><td>' . htmlspecialchars($data['ms_password']) . '</td></tr>
          
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
$dompdf->stream("inventory_item_" . $data['id'] . ".pdf", ["Attachment" => false]);

$conn = null;
?>