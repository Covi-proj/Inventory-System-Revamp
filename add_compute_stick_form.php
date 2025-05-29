<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="photos/icon.jfif" type="image/png">
    <title>Add New Compute Stick</title>
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
        <h2>Add New Compute Stick</h2>
        <form id="addForm" action="add_compute_stick.php" method="POST">

            <!-- Basic Information -->
            <h3>Basic Information</h3>
            <div class="row">
                <div class="form-group">
                    <label for="compname">Computer Name</label>
                    <input type="text" id="compname" name="compname" placeholder="Enter Computer Name">
                </div>
                <div class="form-group">
                    <label for="user_profile">User Profile</label>
                    <input type="text" id="user_profile" name="user_profile" placeholder="Enter User Profile">
                </div>

                <div class="form-group">
                    <label for="client">Client</label>
                    <input type="text" id="client" name="client" placeholder="Enter Client">
                </div>

                <div class="form-group">
                    <label for="section">Section</label>
                    <input type="text" id="section" name="section" placeholder="Enter Section">
                </div>

                <div class="form-group">
                    <label for="section">Device Type</label>
                    <input type="text" id="d_type" name="d_type" placeholder="Enter Device Type">
                </div>

            </div>

            <!-- Network Details -->
            <h3>Network Details</h3>
            <div class="row">

                <div class="form-group">
                    <label for="physical_address_w">Physical Address [Wireless]</label>
                    <input type="text" id="physical_address_w" name="physical_address_w"
                        placeholder="Enter Wireless Address">
                </div>

             
                <div class="form-group">
                    <label for="domain">Domain</label>
                    <input type="text" id="domain" name="domain" placeholder="Enter Domain">
                </div>



                <div class="form-group">
                    <label for="physical_address_e">Internet Access</label>
                    <input type="text" id="section" name="internet_access" placeholder="Enter Internet Access">
                </div>
            </div>

            <!-- Hardware Details -->
            <h3>Hardware Details</h3>
            <div class="row">

                <div class="form-group">
                    <label for="motherboard">Motherboard</label>
                    <input type="text" id="motherboard" name="motherboard" placeholder="Enter Motherboard">
                </div>
                <div class="form-group">
                    <label for="processor">Processor</label>
                    <input type="text" id="processor" name="processor" placeholder="Enter Processor">
                </div>
                <div class="form-group">
                    <label for="memory">Memory</label>
                    <input type="text" id="memory" name="memory" placeholder="Enter Memory">
                </div>
                <div class="form-group">
                    <label for="storage">Storage</label>
                    <input type="text" id="storage" name="storage" placeholder="Enter Storage">
                </div>

               
            </div>

            <!-- Software Details -->
            <h3>Software Details</h3>
            <div class="row">

                  <div class="form-group">
                    <label for="osp_id">Operating System</label>
                    <input type="text" id="operating_system" name="operating_system," placeholder="Enter OS Product Key">
                </div>
            
                <div class="form-group">
                    <label for="osp_id">Operating System Product Key</label>
                    <input type="text" id="osp_id" name="osp_id" placeholder="Enter OS Product Key">
                </div>
                <div class="form-group">
                    <label for="section">Microsoft Office</label>
                    <input type="text" id="ms_office" name="ms_office" placeholder="Enter Microsoft Office">
                </div>
                <div class="form-group">
                    <label for="ms_office_pk">OS License</label>
                    <input type="text" id="ms_office_pk" name="ms_office_pk" placeholder="Enter OS License">
                </div>

                <div class="form-group">
                    <label for="ms_office_pid">OS Product ID</label>
                    <input type="text" id="ms_office_pid" name="ms_office_pid" placeholder="Enter MS Office Product ID">
                </div>

        
               


            </div>

            <!-- Additional Details -->
            <h3>Additional Details</h3>
            <div class="row">


             <div class="form-group">
                    <label for="noah_version">NOAH Key</label>
                    <input type="text" id="noah_version" name="noah_version" placeholder="Enter NOAH Key">
                </div>
            
             
                <div class="form-group">
                    <label for="barcode_scanner">Barcode Scanner</label>
                    <input type="text" id="barcode_scanner" name="barcode_scanner" placeholder="Enter Scanner">
                </div>

         

                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <input type="text" id="remarks" name="remarks" placeholder="Enter Remarks">
                </div>

            </div>

            <!-- Submit Button -->

            <div class="row">
                <div class="form-group">
                    <button type="submit" class="submit-btn">Add Compute Stick</button>
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