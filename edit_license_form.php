<?php
// Database connection
include('config.php');

// Check if the 'med_id' is passed in the URL (GET request)
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Get the medicine ID from the URL
} else {
    echo "No ID provided!";
    exit;
}

// Initialize variables for form data, in case they aren't set yet
$type_of_license = '';
$lisence = '';
$license_key = '';
$remark = '';
$computer_name = '';
$ms_account = '';
$ms_password = '';

// Check if the form is submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type_of_license = $_POST['type_of_license']; // Example post data from the form
    $lisence = $_POST['lisence'];
    $license_key = $_POST['license_key'];
    $remark = $_POST['remark'];
    $computer_name = $_POST['computer_name'];
    $ms_account = $_POST['ms_account'];
    $ms_password = $_POST['ms_password'];
    $id = $_POST['id']; // Get the ID from the form data


    try {
        // Prepare your SQL query to update the medicine record
        $stmt = $conn->prepare("UPDATE licenses SET type_of_license = :type_of_license, license = :license, license_key = :license_key, remark =:remark, computer_name = :computer_name, ms_account = :ms_account, ms_password = :ms_password  WHERE id = :id");

        // Bind parameters to the prepared statement
        $stmt->bindParam(':type_of_license', $type_of_license);
        $stmt->bindParam(':license', $lisence);
        $stmt->bindParam(':license_key', $license_key);
        $stmt->bindParam(':remark', $remark);
        $stmt->bindParam(':computer_name', $computer_name);
        $stmt->bindParam(':ms_account', $ms_account);
        $stmt->bindParam(':ms_password', $ms_password);
        $stmt->bindParam(':id', $id); // Bind the ID parameter
     
        // Execute the query
        $stmt->execute();
        $message = "License updated successfully!";
        $status = "success";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $status = "error";
    }
} else {
    // If it's not a POST request, fetch the existing data for the medicine
    try {
        $stmt = $conn->prepare("SELECT * FROM licenses WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $license = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($license) {
            $type_of_license = $license['type_of_license'];
            $lisence = $license['lisence'];
            $license_key = $license['license_key'];
            $remark = $license['remark'];
            $computer_name = $license['computer_name'];
            $ms_account = $license['ms_account'];
            $ms_password = $license['ms_password'];
        } else {
            $message = "No license found with this ID.";
            $status = "error";
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $status = "error";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="photos/icon.jfif" type="image/png">
    <title>Edit License Modal</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        .modal-content {
            background-color: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #343a40;
            color: white;
            border-bottom: 1px solid #ddd;
            border-radius: 8px 8px 0 0;
        }

        .modal-title {
            font-weight: 600;
            font-size: 1.25rem;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #fff;
            opacity: 0.8;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 20px;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .form-control {
            border-radius: 4px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #5c9ded;
            box-shadow: 0 0 5px rgba(92, 157, 237, 0.5);
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        h6.text-muted {
            margin-top: 20px;
            font-weight: 600;
            font-size: 1rem;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            font-weight: 600;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-lg {
            padding: 12px 20px;
        }

        .modal-dialog {
            max-width: 600px;
        }

        .modal-body {
            background-color: #fff;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <!-- Modal HTML content displayed immediately -->
    <div class="modal fade show" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New License</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="addForm" action="update_license.php" method="POST">
                        <div class="mb-4">
                        <input type="hidden" class="form-control" id="id" name="id" placeholder="Enter Type of License"   value="<?= htmlspecialchars($id) ?>">
                            <label for="type_of_license" class="form-label">Type of License</label>
                            <input type="text" class="form-control" id="type_of_license" name="type_of_license" placeholder="Enter Type of License"   value="<?= htmlspecialchars($type_of_license) ?>">
                        </div>

                        <div class="mb-4">
                            <label for="license" class="form-label">License</label>
                            <input type="text" class="form-control" id="license" name="lisence" placeholder="Enter License" value="<?= htmlspecialchars($lisence ) ?>">
                        </div>

                        <div class="mb-4">
                            <label for="license_key" class="form-label">Product ID | Activation Code | Request Code | License Key</label>
                            <input type="text" class="form-control" id="license_key" name="license_key" placeholder="Enter License Key" value="<?= htmlspecialchars($license_key) ?>">
                        </div>

                        <div class="mb-4">
                            <label for="computer_name" class="form-label">Computer Name</label>
                            <input type="text" class="form-control" id="computer_name" name="computer_name" placeholder="Enter Computer Name" value="<?= htmlspecialchars($computer_name) ?>">
                        </div>

                        <div class="mb-4">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Remarks" value="<?= htmlspecialchars($remark) ?>">
                        </div>

                        <hr class="my-4">

                        <h6 class="text-muted">Require Account & Password (Optional)</h6>

                        <div class="mb-4">
                            <label for="ms_account" class="form-label">Account</label>
                            <input type="text" class="form-control" id="ms_account" name="ms_account" placeholder="Enter Account" value="<?= htmlspecialchars($ms_account) ?>">
                        </div>

                        <div class="mb-4">
                            <label for="ms_password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="ms_password" name="ms_password" placeholder="Enter Password" value="<?= htmlspecialchars($ms_password) ?>">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">Save</button>
                        </div>
                        <div class="d-grid gap-2 mt-2">
                            <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal" onclick="window.location.href='inventory.php#license';">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (Required for modal functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
