<?php
// Database connection
include('config.php');

// Get parameters
$license_key = isset($_GET['license_key']) ? $_GET['license_key'] : null;
$lisence = isset($_GET['lisence']) ? $_GET['lisence'] : null;

if (!$license_key && !$lisence) {
    echo "Error: Neither 'license_key' nor 'lisence' is provided in the URL.";
    exit;
}

// Initialize variables
$results = [];
$message = '';
$status = '';

try {
    $stmt = $conn->prepare("SELECT * FROM licenses WHERE license_key = :license_key AND lisence = :lisence");
    $stmt->bindParam(':license_key', $license_key);
    $stmt->bindParam(':lisence', $lisence);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$results) {
        $message = "No licenses found with this key and ID.";
        $status = "error";
    }
} catch (PDOException $e) {
    $message = "Database error: " . $e->getMessage();
    $status = "error";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="photos/icon.jfif" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full License Details</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            max-width: 900px;
            width: 100%;
        }

        h1 {
            font-size: 28px;
            color: #212529;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        table th,
        table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        table th {
            background-color: #007bff;
            color: white;
            font-weight: 500;
        }

        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table tr:hover {
            background-color: #e2e6ea;
        }

        .message {
            color: #dc3545;
            text-align: center;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .info {
            text-align: center;
            font-size: 16px;
            color: #6c757d;
            margin-top: 15px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }

            table th,
            table td {
                padding: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>
            <?php
            if (!empty($license_key)) {
                echo "License Key: " . htmlspecialchars($license_key);
            } elseif (!empty($lisence)) {
                echo "License: " . htmlspecialchars($lisence);
            } else {
                echo "No License Key or Lisence provided.";
            }
            ?>
        </h1>

        <?php if ($status === 'error'): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <div class="info" style="margin-top: 20px; font-style: italic; color: #495057;">
            <?php if (!empty($results)): ?>
                <p>Type of License: <strong>
                        <?php
                        echo htmlspecialchars($results[0]['type_of_license'] ?? 'N/A');
                        ?>
                    </strong></p>
            <?php else: ?>
                <p style="color: #dc3545;">No license type information available.</p>
            <?php endif; ?>
        </div>


        <div style="max-height: 300px; overflow-y: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Computer Name</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results)): ?>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['computer_name'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['remark'] ?? ''); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" style="text-align: center;">No data available for this license.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>