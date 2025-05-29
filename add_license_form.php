<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="photos/icon.jfif" type="image/png">
    <title>Add License Modal</title>
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
                    <form id="addForm" action="add_license.php" method="POST">
                        <div class="mb-4">
                            <label for="type_of_license" class="form-label">Type of License</label>
                            <input type="text" class="form-control" id="type_of_license" name="type_of_license" placeholder="Enter Type of License" >
                        </div>

                        <div class="mb-4">
                            <label for="license" class="form-label">License</label>
                            <input type="text" class="form-control" id="license" name="license" placeholder="Enter License" >
                        </div>

                        <div class="mb-4">
                            <label for="license_key" class="form-label">Product ID | Activation Code | Request Code | License Key</label>
                            <input type="text" class="form-control" id="license_key" name="license_key" placeholder="Enter License Key" >
                        </div>

                        <div class="mb-4">
                            <label for="computer_name" class="form-label">Computer Name</label>
                            <input type="text" class="form-control" id="computer_name" name="computer_name" placeholder="Enter Computer Name" >
                        </div>

                        <div class="mb-4">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Remarks">
                        </div>

                        <hr class="my-4">

                        <h6 class="text-muted">Require Account & Password (Optional)</h6>

                        <div class="mb-4">
                            <label for="ms_account" class="form-label">Account</label>
                            <input type="text" class="form-control" id="ms_account" name="ms_account" placeholder="Enter Account">
                        </div>

                        <div class="mb-4">
                            <label for="ms_password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="ms_password" name="ms_password" placeholder="Enter Password">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">Add License</button>
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
