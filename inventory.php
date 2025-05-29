<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not authenticated
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'license_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch user's name and password
    $stmt = $pdo->prepare("SELECT name, username, passwords FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Securely output the values
        $username = htmlspecialchars($user['name']); // Username
        $user_password = htmlspecialchars($user['passwords']); // User's password
    } else {
        $username = "Guest"; // Fallback if user not found
        $user_password = "";
    }
} catch (PDOException $e) {
    $username = "Error retrieving name."; // Handle error
    $user_password = ""; // Empty password on error
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Inventory</title>
    <link rel="icon" href="photos/icon.jfif" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!--table duplicate-->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

    <!--med duplicate -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!--Dashboard duplicate -->
    <style>
        /* General Styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;

            background-color: #f5f5f5;
            color: #2a2185;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Top Navigation Bar */
        .navbar {
            background-color: white;
            color: black;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            /* Space between left and right content */
            align-items: center;
            /* Align items vertically */

        }

        .navbar .logo {
            font-size: 30px;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .navbar .navbar-logo {
            width: 75px;
            height: auto;
            margin-right: 10px;
        }

        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            /* Adds space between text and image */
        }

        .navbar .user-name {
            font-weight: normal;
            color: black;
            margin: 0;
        }

        .navbar .user-image {
            width: 40px;
            /* Adjust size as needed */
            height: 40px;
            border-radius: 50%;
            /* Makes it a circular image */
            object-fit: cover;
        }

        /* Sidebar Styles */
        .container {
            display: flex;
            height: 100vh;
            flex-direction: row;
        }

        .sidebar {
            width: 180px;
            background-color: rgb(255, 255, 255);
            color: black;
            padding: 20px;

            font-size: 18px;
            transition: width 0.3s;
        }

        .sidebar.collapsed {
            width: 80px;
            /* Width when collapsed */
        }

        .sidebar h1 {
            color: white;
            font-size: 22px;
            margin-bottom: 20px;
            margin-left: 20px;
            text-align: left;
            display: flex;
            align-items: center;
        }

        .sidebar h1 i {
            margin-right: 10px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 15px;
            cursor: pointer;
            font-size: 15px;
            font-weight: light;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.6s;
            display: flex;
            align-items: center;
        }

        .sidebar ul li i {
            margin-right: 10px;
            display: block;
        }

        .sidebar ul li:hover,
        .sidebar ul li.active {
            background-color: black;
            color: white;
        }

        .sidebar ul li.active {
            border-left: 5px solid #fff;
        }

        .sidebar.collapsed ul li i {
            display: none;
            /* Hide icons when collapsed */
        }

        .sidebar .toggle-btn {
            display: none;
            /* Initially hidden */
        }

        /* Button for toggling the sidebar */
        @media (max-width: 768px) {
            .sidebar.collapsed {
                width: 0;
            }

            .sidebar .toggle-btn {
                display: block;
                position: absolute;
                top: 20px;
                left: 20px;
                font-size: 30px;
                background: none;
                color: white;
                border: none;
                cursor: pointer;
            }

            .sidebar h1 {
                justify-content: center;
            }
        }

        /* Content Styles */
        .content {
            flex: 1;
            padding: 20px;
            position: relative;
            overflow-y: auto;
        }

        .page {
            display: none;
        }

        .page.active {
            display: block;
        }

        /* Form Styles */
        form {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #2a2185;
            font-size: 1rem;
            width: 100%;
        }

        button {
            background-color: #3c2f9b;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #5243b4;
        }

        .link {
            text-decoration: none;
            padding: 12px 20px;
            background-color: royalblue;
            color: white;
            border-radius: 5px;
            margin-top: 10px;
            display: inline-block;
        }

        .link:hover {
            background-color: #3c2f9b;
        }

        /* Header Styles */
        header {
            background-color: #808080;
            color: white;
            padding: 15px;
            text-align: center;
        }

        /* Notification and Table Styles */
        .rounded-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .student-count {
            font-size: 18px;
            color: #333;
            margin-top: 20px;
        }

        /* Responsive Layout */
        @media screen and (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                box-shadow: none;
                padding: 10px;
            }

            .content {
                padding: 10px;
            }

            .sidebar ul li {
                font-size: 16px;
                margin-bottom: 10px;
            }

            input[type="text"],
            input[type="password"],
            input[type="date"] {
                width: 100%;
                margin-right: 0;
            }

            button {
                width: 100%;
            }

            .link {
                width: 100%;
            }
        }


        .logout {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: black;
            cursor: pointer;
            font-size: 18px;
            margin-left: 10px;
            transition: background-color 0.6s ease;
            font-weight: bold;
        }

        .logout:hover {
            background-color: black;
            padding: 10px;
            border-radius: 5px;
            color: white;
        }

        .ul {
            font-weight: light;
        }

        li i {
            margin-right: 8px;
            font-size: 20px;
            /* Adjust icon size as needed */
        }

        h1 i {
            margin-right: 10px;
            /* Space between the icon and the text */
            font-size: 24px;
            /* Adjust icon size to match the heading */
        }


        /*modal */

        .pop-up-modal {
            transform: scale(0.7);
            transition: transform 0.3s ease;
        }

        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
        }

        .modal.fade.show .modal-dialog {
            transform: scale(1);
        }


        /*end*/

        /* Modal Structure */
        /* Modal container */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            /* Centers the modal */
            width: 80%;
            max-width: 600px;

            animation: fadeIn 0.2s ease-out;
            /* Faster fade-in animation */
        }

        /* Modal content (the actual window) */
        .modal-content {
            background-color: #ffff;
            margin: 0;
            /* Remove margin for full-screen effect */
            padding: 40px;
            border-radius: 15px;
            width: 80%;
            /* You can adjust this width as needed */
            max-width: 800px;
            /* Optional: Limits the width */
            max-height: 90%;
            /* Prevents overflow vertically */

        }

        /* Modal header (title and close button) */
        .modal-header {
            background-color: #b11226;
            color: white;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        /* Close button */
        .modal-header .close {
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }



        .modal-header .close:hover {
            color: #f5f5f5;
            /* Light color when hovering */
        }

        /* Body of the modal (form fields) */
        .modal-body {
            padding-top: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            /* Increased gap for more space between fields */
            margin-bottom: 1.rem;
        }

        label {
            font-size: 1rem;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 1rem;
            /* Space between label and input */
        }

        input[type="text"],
        input[type="password"],
        select {
            padding: 0.875rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            width: 200px;
            margin-bottom: 1.5rem;
            /* Increased bottom margin for more space between inputs */
            margin-left: 5px;
            /* Space to the left of the textbox */
        }

        /* Layout for when form fields are next to each other */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            /* Allow the form to wrap when necessary */
            gap: 20px;
            /* Increased gap between the textboxes */
            justify-content: space-between;
        }

        .form-row .form-group {
            flex: 1;
            /* Allow form elements to be evenly spaced */
            min-width: 220px;
            /* Ensure the form elements don’t get too small */
        }

        .form-row .form-group {
            flex: 1;
            /* Allow form elements to be evenly spaced */
            min-width: 220px;
            /* Ensure the form elements don’t get too small */
        }

        /* Buttons */
        button[type="button"],
        button[type="submit"] {
            padding: 0.75rem 1.25rem;
            font-weight: bold;
            border-radius: 8px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="button"] {
            background-color: #9ca3af;
        }

        button[type="button"]:hover {
            background-color: #6b7280;
        }

        button[type="submit"] {
            background-color: #b11226;
        }

        button[type="submit"]:hover {
            background-color: #a00e23;
        }

        /* Animation for fading in the modal */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        /* Animation for sliding in the modal content */
        @keyframes slideIn {
            0% {
                transform: translateY(-30px);
                /* Start from above */
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                /* End at normal position */
                opacity: 1;
            }
        }

        /* Animation for closing the modal (fade and slide out) */
        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .modal .close.fade-out {

            animation: fadeOut 1s ease forwards;
        }

        /* Modal disappearing (close animation) */
        .modal.close-animation .modal-content {
            animation: fadeOut 0.2s ease-out forwards, slideOut 0.3s ease-out forwards;
        }

        /* Animation for sliding out the modal content */
        @keyframes slideOut {
            0% {
                transform: translateY(0);
                opacity: 1;
            }

            100% {
                transform: translateY(30px);
                /* Slide down */
                opacity: 0;
            }
        }

        /*end add modal*/


        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            font-size: 12px;
        }

        th {
            background-color: #000;
            color: #fff;
            font-weight: bold;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        tr:hover td {
            background-color: #e2e6ea;
        }

        .action-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .action-icons a {
            color: #007bff;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .action-icons a:hover {
            color: #0056b3;
        }

        .no-data {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 20px 0;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .status {
            font-size: 30px;
            margin: 2px 2px 0 0;
            display: inline-block;
            vertical-align: middle;
            line-height: 10px;
        }

        .text-success {
            color: #10c469;
        }

        .text-info {
            color: #62c9e8;
        }

        .text-warning {
            color: #FFC107;
        }

        .text-danger {
            color: #ff5b5b;
        }

        .pagination {
            float: right;
            margin: 0 0 5px;
        }

        .pagination li a {
            border: none;
            font-size: 13px;
            min-width: 30px;
            min-height: 30px;
            color: #999;
            margin: 0 2px;
            line-height: 30px;
            border-radius: 2px !important;
            text-align: center;
            padding: 0 6px;
        }

        .pagination li a:hover {
            color: #666;
        }

        .pagination li.active a {
            background: #03A9F4;
        }

        .pagination li.active a:hover {
            background: #0397d6;
        }

        .pagination li.disabled i {
            color: #ccc;
        }

        .pagination li i {
            font-size: 16px;
            padding-top: 6px;
        }

        .hint-text {
            float: left;
            margin-top: 10px;
            font-size: 13px;
        }

        button.edit,
        button.delete {
            padding: 4px 8px;
            /* Reduces padding */
            font-size: 12px;
            /* Reduces font size */
            height: 28px;
            /* Sets a fixed height */
            line-height: 1;
            border-radius: 3px;
            border: none;
            cursor: pointer;
            background-color: #f0f0f0;
            color: #333;

        }

        .editBtn {
            background-color: blue;
            color: white;
            margin-bottom: 5px;
            font-weight: bold;
            width: 100px;

        }

        .deleteBtn {
            background-color: red;
            color: white;
            margin-bottom: 5px;
            font-weight: bold;
            width: 100px;

        }

        button.edit:hover {
            background-color: #d0e9ff;
            color: #007bff;
        }

        button.delete:hover {
            background-color: #ffd1d1;
            color: #d9534f;

        }

        .searchbar-users {
            margin-top: 10px;
            /* Adds space above the search bar */
            padding: 8px;
            font-size: 16px;
            width: 100%;
            max-width: 300px;
            /* Adjust the width of the search bar */
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .success-alert {
            display: none;
            /* Hidden by default */
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            /* Green background */
            color: white;
            /* White text */
            padding: 15px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            font-family: Arial, sans-serif;
            z-index: 1000;
            animation: fadeInOut 5s ease-in-out;
        }

        /* Optional fade-in and fade-out animation */
        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            10% {
                opacity: 1;
                transform: translateY(0);
            }

            90% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translateY(-20px);
            }
        }


        .container-pmr {
            max-width: 1500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            color: black;
            font-weight: normal;
        }

        th {
            background-color: rgb(3, 0, 55);
            color: white;
            font-weight: bold;
            width: 150px;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .dataTables_paginate {
            margin-top: 20px;
            text-align: center;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 5px 10px;
            margin: 0 2px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            color: #333;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #4CAF50;
            color: white;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .search-container {
            margin-bottom: 10px;
        }

        .pagination {
            display: flex;
            list-style-type: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 5px;
            cursor: pointer;
        }

        .hidden {
            display: none;
        }

        .calendar-container {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 350px;
            text-align: center;
        }

        .calendar-header {
            font-size: 1.5em;
            font-weight: bold;
            color: #333333;
            margin-bottom: 20px;
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            font-weight: bold;
            color: #555555;
            margin-bottom: 10px;
        }

        .calendar-dates {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .calendar-dates div {
            height: 40px;
            line-height: 40px;
            text-align: center;
            border-radius: 4px;
            background-color: #f9f9f9;
            color: #333333;
            font-size: 0.9em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .calendar-dates div:hover {
            background-color: #007bff;
            /* Highlight color */
            color: #ffffff;
        }

        .calendar-dates .today {
            background-color: #28a745;
            /* Highlight today */
            color: #ffffff;
        }

        /*med*/


        .ten {
            text-align: center;
            color: #333;
            font-size: 32px;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 40px;
            gap: 30px;
            background-color: white;
            padding: 30px;
            /* Add padding inside the container */
            border-radius: 10px;
            /* Optional: gives a rounded corner effect */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            /* Optional: subtle shadow */
        }

        .profile-img,
        .profile-details {
            margin: 0 15px;
            /* Add spacing between profile image and details */
        }

        /* Optional: Add spacing between text elements in profile-details */
        .profile-details p {
            margin: 10px 0;
        }

        .profile-img img {
            border-radius: 50%;
            border: 4px solid #f4f6f9;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .profile-img img:hover {
            transform: scale(1.1);
        }

        .profile-details {
            flex: 1;
            font-size: 16px;
        }

        .profile-details h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .profile-details p {
            margin: 8px 0;
            color: #555;
        }

        .profile-details strong {
            color: #007BFF;
        }

        .profile-actions {
            text-align: center;
        }

        .action-btn {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            margin: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .action-btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-container {
                flex-direction: column;
                text-align: center;
            }

            .profile-img img {
                width: 120px;
                height: 120px;
            }

            .profile-details h2 {
                font-size: 24px;
            }

            .action-btn {
                width: 100%;
                padding: 14px 30px;
                font-size: 18px;
            }
        }

        .w3-bar {
            display: flex;
            justify-content: left;
            background-color: black;
            padding: 10px 0;
        }

        .w3-bar-item {
            padding: 10px 20px;
            color: white;
            border: none;
            outline: none;
            cursor: pointer;
            background-color: transparent;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-left: 10px;
        }

        .w3-bar-item:hover {
            background-color: #555;
        }

        .tablink.w3-red {
            background-color: #4CAF50;
            /* Active tab color */
            color: white;
            font-weight: bold;
        }

        .city {
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .city h2 {
            margin: 0 0 10px;
            color: #333;
        }

        .city p {
            color: #555;
        }

        /*med message*/
        .success-alert {
            background-color: #4CAF50;
            /* Success Green */
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .success-alert span {
            cursor: pointer;
            font-weight: bold;
            margin-left: 10px;
        }

        input[type="file"] {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            font-size: 14px;
            background-color: #fafafa;
            cursor: pointer;
        }

        input[type="file"]::-webkit-file-upload-button {
            padding: 8px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
    </style>

</head>

<body>

    <div class="navbar">
        <div class="left-content">
            <span class="logo">
                <img src="photos/unnamed.png" alt="Health-e Logo" class="navbar-logo">IT Inventory
            </span>
        </div>
        <div class="right-content">
            <div class="user-info">
                <p class="user-name"><?php echo $username; ?></p>
                <img src="photos/avatar.jpg" alt="User Profile" class="user-image">

            </div>
        </div>
    </div>


    <div class="container">
        <div class="sidebar">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

            <ul>
                <li onclick="showPage('dashboard')">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </li>

                <li onclick="showPage('license')">
                    <i class="fas fa-id-card"></i> License
                </li>

                <li onclick="showPage('desktop')">
                    <i class="fas fa-desktop"></i> Desktop
                </li>

                <li onclick="showPage('compute_stick')">
                    <i class="bi bi-usb-drive"></i> Compute Stick
                </li>

                <li onclick="showPage('laptop')">
                    <i class="fas fa-laptop"></i> Laptop
                </li>

                <li onclick="showPage('profile')">
                    <i class="fas fa-user"></i> User Profile
            </ul>
            <span id="logout" onclick="logout()" class="logout"> <i class="fas fa-sign-out-alt"
                    style="color:black;"></i> Sign Out</span>

        </div>

        <div class="content">

            <div id="profile" class="page">
                <h1 class="ten">User Profile</h1>

                <div class="profile-container">
                    <div class="profile-img">
                        <img src="photos/avatar.jpg" alt="User Avatar" width="150" height="150">
                    </div>

                    <div class="profile-details">
                        <h2><?php echo $username; ?></h2>
                        <label>User Name</p>
                            <p><?php echo $username; ?></p>
                            <label>Password</label>
                            <input type="password" id="password" value="<?php echo htmlspecialchars($user_password); ?>"
                                readonly>
                            <input type="checkbox" id="show-password" onclick="togglePassword()">
                    </div>
                </div>
                <script>
                    // Function to toggle password visibility
                    function togglePassword() {
                        var passwordField = document.getElementById('password');
                        var showPasswordCheckbox = document.getElementById('show-password');
                        if (showPasswordCheckbox.checked) {
                            passwordField.type = 'text'; // Show password
                        } else {
                            passwordField.type = 'password'; // Hide password
                        }
                    }
                </script>
                <div class="profile-actions">
                    <!-- 
                    <a href="edit_user_profile2.php?id=<?/*php echo $_SESSION['user_id']; */ ?>" class="action-btn"
                        style="font-weight: bold; text-decoration: none;">
                        Edit Profile
                    </a>
Button to edit user profile -->
                </div>
            </div>

            <!--dashboard-->
            <div id="dashboard" class="page active">
                <h1 style="color:black;">Dashboard</h1>

                <div class="modal-body">
                    <?php
                    // Database connection settings
                    $host = 'localhost';
                    $db = 'license_db';
                    $user = 'root';
                    $pass = '';

                    // Create PDO instance
                    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // SQL query to count the occurrences of each type_of_license
                    $sqloption = "SELECT type_of_license, COUNT(*) AS count FROM licenses GROUP BY type_of_license";

                    try {
                        $stmt = $pdo->prepare($sqloption);
                        $stmt->execute();
                    } catch (PDOException $e) {
                        echo 'Error: ' . $e->getMessage();
                    }
                    ?>

                    <div class="license-list">
                        <h5 class="text-center mb-4" style="font-size: 1.2rem; font-weight: 600; color: black;">License
                            Count by Type
                        </h5>
                        <div class="list-group"
                            style="max-height: 300px; overflow-y: auto; border-radius: 8px; background-color: #f7f7f7;">
                            <?php
                            // Display the data in a list format
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<div class='list-group-item' style='display: flex; justify-content: space-between; padding: 12px 16px; border: 1px solid #e1e1e1; border-radius: 6px; margin-bottom: 6px; background-color: white;'>";
                                echo "<span style='font-weight: 500; color: #333;'>" . htmlspecialchars($row['type_of_license']) . "</span>";
                                echo "<span style='font-weight: 500; color: #007bff;'>" . $row['count'] . "</span>";
                                echo "</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <!--End dashboard-->


            <!--license section-->
            <div id="license" class="page" style="max-width: 100%; padding: 20px; overflow: hidden;">
                <a class="right-content">

                    <h1 class="student-count" style="font-size: 35px; color:black;">License Inventory
                        <i class="fas fa-file-signature"></i>
                    </h1>

                    <p id="date-time" style="font-size: 20px; color: black; font-weight: bold;"></p>

                    <!-- License Type Dropdown Filter -->
                    <select id="companyFilter" class="form-select" required onchange="filterData()">
                        <option value="">--Select Type of License--</option>
                        <?php
                        // Database connection
                        $host = 'localhost';
                        $db = 'license_db';
                        $user = 'root';
                        $pass = '';

                        try {
                            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $sqloption = "SELECT DISTINCT type_of_license FROM licenses";
                            $stmt = $pdo->prepare($sqloption);
                            $stmt->execute();

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $selected = (isset($_GET['type_of_license']) && $_GET['type_of_license'] === $row['type_of_license']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($row['type_of_license']) . '" ' . $selected . '>' . htmlspecialchars($row['type_of_license']) . '</option>';
                            }
                        } catch (PDOException $e) {
                            echo '<option disabled>Error loading options</option>';
                        }
                        ?>
                    </select>

                    <script>
                        function filterData() {
                            const selectedType = document.getElementById('companyFilter').value;
                            const url = new URL(window.location.href);
                            if (selectedType) {
                                url.searchParams.set('type_of_license', selectedType);
                            } else {
                                url.searchParams.delete('type_of_license');
                            }
                            window.location.href = url.toString();
                        }
                    </script>

                    <!-- Add License Button -->
                    <button type="button" id="btnAddEmployee" class="btn btn-primary"
                        style="font-weight: bold; margin: 10px 0 10px 10px; background-color: #0056b3"
                        onclick="window.location.href='add_license_form.php';">
                        <i class="fa-solid fa-file-signature"></i> Add License
                    </button>

                    <!-- License Table -->
                    <table id="desktopTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Product ID</th>
                                <th style="width: 250px;">Type of License</th>
                                <th>License</th>
                                <th style="width: 300px;">Product ID | Activation Code | Request Code | License Key</th>
                                <th style="width: 250px;">Remarks</th>
                                <th>Computer Name</th>
                                <th>Account</th>
                                <th>Password</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $type_of_license = $_GET['type_of_license'] ?? '';
                                $sql = "SELECT * FROM licenses";
                                if (!empty($type_of_license)) {
                                    $sql .= " WHERE type_of_license = :type_of_license";
                                }

                                $stmt = $pdo->prepare($sql);
                                if (!empty($type_of_license)) {
                                    $stmt->bindParam(':type_of_license', $type_of_license, PDO::PARAM_STR);
                                }
                                $stmt->execute();
                                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($data) {
                                    foreach ($data as $item) {
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($item['id'] ?? 'N/A') . '</td>';
                                        echo '<td>' . htmlspecialchars($item['type_of_license'] ?? 'N/A') . '</td>';
                                        echo '<td>';
                                        if (isset($item['lisence'], $item['license_key'])) {
                                            echo '<a href="view_sum.php?lisence=' . htmlspecialchars($item['lisence']) . '&license_key=' . htmlspecialchars($item['license_key']) . '">'
                                                . htmlspecialchars($item['lisence']) . '</a>';
                                        } else {
                                            echo 'N/A';
                                        }
                                        echo '</td>';
                                        echo '<td>';
                                        if (isset($item['lisence'], $item['license_key'])) {
                                            echo '<a href="view_sum.php?lisence=' . htmlspecialchars($item['lisence']) . '&license_key=' . htmlspecialchars($item['license_key']) . '">'
                                                . htmlspecialchars($item['license_key']) . '</a>';
                                        } else {
                                            echo 'N/A';
                                        }
                                        echo '</td>';
                                        echo '<td>' . htmlspecialchars($item['remark'] ?? 'N/A') . '</td>';
                                        echo '<td>' . htmlspecialchars($item['computer_name'] ?? 'N/A') . '</td>';
                                        echo '<td>' . htmlspecialchars($item['ms_account'] ?? 'N/A') . '</td>';
                                        echo '<td>' . htmlspecialchars($item['ms_password'] ?? 'N/A') . '</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">';
                                        echo '<a href="edit_license_form.php?id=' . htmlspecialchars($item['id']) . '" class="btn btn-sm btn-primary" style="font-weight: bold; text-decoration: none;"><i class="fas fa-edit"></i> Edit</a> ';
                                        echo '<a href="delete_license.php?id=' . htmlspecialchars($item['id']) . '" class="btn btn-sm btn-danger" style="font-weight: bold; color: red; text-decoration: none;"><i class="fas fa-trash"></i> Delete</a>';
                                        echo '<a href="generate_pdf_license.php?id=' . htmlspecialchars($item['id']) . '" class="btn btn-sm btn-success btn-action" style="font-weight: bold; text-decoration: none; margin-left:10px; color:green;"><i class="fas fa-file-pdf"></i> Generate PDF</a>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="9" class="text-center">No records found</td></tr>';
                                }
                            } catch (PDOException $e) {
                                echo '<tr><td colspan="9" class="text-center">Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Optional No Data Message -->
                    <p id="noDataMessage" style="display:none; text-align: center; color: red;">No data found</p>

                    <!-- Scripts -->
                    <script>


                        $(document).ready(function () {
                            $('#desktopTable').DataTable({
                                paging: true,
                                searching: true,
                                lengthChange: true,
                                pageLength: 10,
                                ordering: true
                            });
                        });
                    </script>


            </div>
            <!-- End license section-->


            <!--Desktop section-->
            <div id="desktop" class="page">


                <h1 style="color: black;">Desktop Inventory
                    <i class="fas fa-desktop"></i>
                </h1>
                <link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" rel="stylesheet">


                <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: center;">
                    <div>
                        <label for="filterComputerName">Computer Name:</label>
                        <select id="filterComputerName" onchange="filterTable()">
                            <option value="">--Select Computer Name--</option>
                            <?php
                            $stmt = $pdo->prepare("SELECT DISTINCT compname FROM tbl_desktop");
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row['compname']) . '">' . htmlspecialchars($row['compname']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="filterUserProfile">User Profile:</label>
                        <select id="filterUserProfile" onchange="filterTable()">
                            <option value="">--Select User Profile--</option>
                            <?php
                            $stmt = $pdo->prepare("SELECT DISTINCT user_profile FROM tbl_desktop");
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row['user_profile']) . '">' . htmlspecialchars($row['user_profile']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="filterWindowsLicense">Windows License Key:</label>
                        <select id="filterWindowsLicense" onchange="filterTable()">
                            <option value="">--Select Windows License Key--</option>
                            <?php
                            $stmt = $pdo->prepare("SELECT DISTINCT osp_id FROM tbl_desktop");
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row['osp_id']) . '">' . htmlspecialchars($row['osp_id']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="filterMsOfficeProductId">MS Office Product ID:</label>
                        <select id="filterMsOfficeProductId" onchange="filterTable()">
                            <option value="">--Select MS Office Product ID--</option>
                            <?php
                            $stmt = $pdo->prepare("SELECT DISTINCT ms_office_pid FROM tbl_desktop");
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row['ms_office_pid']) . '">' . htmlspecialchars($row['ms_office_pid']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="filterMsOfficeAccount">MS Office Account:</label>
                        <select id="filterMsOfficeAccount" onchange="filterTable()">
                            <option value="">--Select MS Office Account--</option>
                            <?php
                            $stmt = $pdo->prepare("SELECT DISTINCT ms_office_account_lr FROM tbl_desktop");
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row['ms_office_account_lr']) . '">' . htmlspecialchars($row['ms_office_account_lr']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <button type="button" id="btnAddEmployee" class="btn btn-primary"
                    style="font-weight: bold; margin-bottom: 10px; margin-left: 10px; background-color: #0056b3"
                    onclick="window.location.href='add_desktop_form.php';">
                    <i class="fa-solid fa-file-signature"></i>
                    Add Dekstop
                </button>


                <div style="width: 100%; overflow-x: auto; max-height: 500px; overflow-y: auto;">
                    <table id="employeeTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Desktop Id</th>
                                <th>Action</th>
                                <th style="width: 150px;">Computer Name</th>
                                <th>User Profile</th>
                                <th>Windows License Key</th>
                                <th>MS Office Product ID</th>
                                <th>MS Office Account</th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $type_of_license = $_GET['type_of_license'] ?? '';
                                $sql = "SELECT * FROM tbl_desktop";
                                if (!empty($type_of_license)) {
                                    $sql .= " WHERE type_of_license = :type_of_license";
                                }

                                $stmt = $pdo->prepare($sql);
                                if (!empty($type_of_license)) {
                                    $stmt->bindParam(':type_of_license', $type_of_license, PDO::PARAM_STR);
                                }
                                $stmt->execute();
                                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($data) {
                                    foreach ($data as $item) {
                                        echo '<tr>';
                                        echo '<td>' . (!empty($item['d_id']) ? htmlspecialchars($item['d_id']) : 'N/A') . '</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">';
                                        echo '<a href="edit_desktop_form.php?d_id=' . htmlspecialchars($item['d_id']) . '" class="btn btn-sm btn-primary btn-action"  style="font-weight: bold; text-decoration: none;">
                                    <i class="fas fa-edit"></i> Edit/View Details
                                </a>';
                                echo '<a href="generate_pdf_desktop.php?d_id=' . htmlspecialchars($item['d_id']) . '" class="btn btn-sm btn-success btn-action" style="font-weight: bold; text-decoration: none; margin-left:10px; color:green;"><i class="fas fa-file-pdf"></i> Generate PDF</a>';

                                        echo '<a href="delete_desktop.php?d_id=' . htmlspecialchars($item['d_id']) . '" class="btn btn-sm btn-danger btn-action" style="font-weight: bold; text-decoration: none; margin-left:10px; color:red;"><i class="fas fa-trash"></i> Delete</a>';
                                        echo '</td>';
                                        echo '<td>' . (!empty($item['compname']) ? htmlspecialchars($item['compname']) : 'N/A') . '</td>';//keeps for the table and filters 
                                        echo '<td>' . (!empty($item['user_profile']) ? htmlspecialchars($item['user_profile']) : 'N/A') . '</td>'; //keep for the table 
                            
                                        echo '<td>' . (!empty($item['osp_id']) ? htmlspecialchars($item['osp_id']) : 'N/A') . '</td>'; //keep this as is
                            

                                        echo '<td>' . (!empty($item['ms_office_pid']) ? htmlspecialchars($item['ms_office_pid']) : 'N/A') . '</td>'; //keep this as is
                                        echo '<td>' . (!empty($item['ms_office_account_lr']) ? htmlspecialchars($item['ms_office_account_lr']) : 'N/A') . '</td>'; //keep this as is
                            
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="8" class="text-center">No records found</td></tr>';
                                }
                            } catch (PDOException $e) {
                                echo '<tr><td colspan="8" class="text-center">Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                    <script>
                        function filterTable() {
                            const compName = document.getElementById('filterComputerName').value.toLowerCase();
                            const userProfile = document.getElementById('filterUserProfile').value.toLowerCase();
                            const windowsLicense = document.getElementById('filterWindowsLicense').value.toLowerCase();
                            const msOfficePid = document.getElementById('filterMsOfficeProductId').value.toLowerCase();
                            const msOfficeAccount = document.getElementById('filterMsOfficeAccount').value.toLowerCase();

                            const table = document.getElementById('employeeTable');
                            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

                            for (let i = 0; i < rows.length; i++) {
                                const tdCompName = rows[i].cells[2].textContent.toLowerCase();
                                const tdUserProfile = rows[i].cells[3].textContent.toLowerCase();
                                const tdWindowsLicense = rows[i].cells[4].textContent.toLowerCase();
                                const tdMsOfficePid = rows[i].cells[5].textContent.toLowerCase();
                                const tdMsOfficeAccount = rows[i].cells[6].textContent.toLowerCase();

                                const matchesCompName = !compName || tdCompName.includes(compName);
                                const matchesUserProfile = !userProfile || tdUserProfile.includes(userProfile);
                                const matchesWindowsLicense = !windowsLicense || tdWindowsLicense.includes(windowsLicense);
                                const matchesMsOfficePid = !msOfficePid || tdMsOfficePid.includes(msOfficePid);
                                const matchesMsOfficeAccount = !msOfficeAccount || tdMsOfficeAccount.includes(msOfficeAccount);

                                if (matchesCompName && matchesUserProfile && matchesWindowsLicense && matchesMsOfficePid && matchesMsOfficeAccount) {
                                    rows[i].style.display = '';
                                } else {
                                    rows[i].style.display = 'none';
                                }
                            }
                        }
                    </script>


                    <script>
                        $(document).ready(function () {

                            $.fn.dataTable.ext.errMode = 'none';

                            $('#employeeTable').DataTable({
                                paging: true,
                                searching: true,
                                ordering: true,
                                info: true,
                                language: {
                                    emptyTable: "No data available in table"
                                }
                            });
                        });
                    </script>
                </div>

                <p id="noDataMessage" style="display:none; text-align: center; color: red;">No data found</p>


                <!-- Closing container-pmr -->

                <!-- Include jQuery and DataTables JS -->
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        // Set the current month as the default selected value

                        const dateSelect = document.getElementById('date');
                        dateSelect.value = all;
                        filterdate();  // Apply the filter by current month on page load
                    });

                    function filterdate() {
                        const selectedMonth = document.getElementById('date').value;
                        const rows = document.querySelectorAll('#example tbody tr');

                        rows.forEach(row => {
                            const dateCell = row.cells[3].textContent.trim(); // Date cell is in the 4th column
                            const rowMonth = new Date(dateCell).toLocaleString('default', { month: 'long' }).toLowerCase();

                            if (selectedMonth === 'all' || rowMonth === selectedMonth) {
                                row.style.display = '';  // Show the row
                            } else {
                                row.style.display = 'none';  // Hide the row
                            }
                        });
                    }

                </script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
            </div> <!-- Closing balances -->

            <!--End Desktop section-->


            <!--Compute Stick Section-->

            <div id="compute_stick" class="page">
                <h1 style="color: black;">Compute Stick
                    <i class="bi bi-usb-drive"></i>
                </h1>

                <link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" rel="stylesheet">

                <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: center;">
                    <div>
                        <label for="filterComputerName">Computer Name:</label>
                        <select id="filterComputerName2" onchange="filterTable2()">
                            <option value="">--Select Computer Name--</option>
                            <?php
                            $stmt = $pdo->prepare("SELECT DISTINCT compname FROM tbl_compute_stick");
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row['compname']) . '">' . htmlspecialchars($row['compname']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="filterUserProfile">User Profile:</label>
                        <select id="filterUserProfile2" onchange="filterTable2()">
                            <option value="">--Select User Profile--</option>
                            <?php
                            $stmt = $pdo->prepare("SELECT DISTINCT user_profile FROM tbl_compute_stick");
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row['user_profile']) . '">' . htmlspecialchars($row['user_profile']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="filterWindowsLicense">Windows License Key:</label>
                        <select id="filterWindowsLicense2" onchange="filterTable2()">
                            <option value="">--Select Windows License Key--</option>
                            <?php
                            $stmt = $pdo->prepare("SELECT DISTINCT osp_id FROM tbl_compute_stick");
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row['osp_id']) . '">' . htmlspecialchars($row['osp_id']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>


                </div>


                <button type="button" id="btnAddEmployee" class="btn btn-primary"
                    style="font-weight: bold; margin-bottom: 10px; margin-left: 10px; background-color: #0056b3"
                    onclick="window.location.href='add_compute_stick_form.php';">
                    <i class="fa-solid fa-file-signature"></i>
                    Add Compute Stick
                </button>


                <table id="new" class="display" style="width: 100%; margin-top: 20px;">
                    <thead>
                        <tr class="med">
                            <th>Compute Stick ID</th>
                            <th>Action</th>
                            <th style="width: 150px;">Computer Name</th>
                            <th>User Profile</th>
                            <th>Windows License Key</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $type_of_license = $_GET['type_of_license'] ?? '';
                            $sql = "SELECT * FROM tbl_compute_stick";
                            if (!empty($type_of_license)) {
                                $sql .= " WHERE type_of_license = :type_of_license";
                            }

                            $stmt = $pdo->prepare($sql);
                            if (!empty($type_of_license)) {
                                $stmt->bindParam(':type_of_license', $type_of_license, PDO::PARAM_STR);
                            }
                            $stmt->execute();
                            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if ($data) {
                                foreach ($data as $item) {
                                    echo '<tr>';
                                    echo '<td>' . (!empty($item['cs_id']) ? htmlspecialchars($item['cs_id']) : 'N/A') . '</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">';
                                    echo '<a href="edit_compute_stick_form.php?cs_id=' . htmlspecialchars($item['cs_id']) . '" class="btn btn-sm btn-primary btn-action"  style="font-weight: bold; text-decoration: none;">
                                    <i class="fas fa-edit"></i> Edit/View Details
                                </a>';
                                     echo '<a href="generate_pdf_compute_s.php?cs_id=' . htmlspecialchars($item['cs_id']) . '" class="btn btn-sm btn-success btn-action" style="font-weight: bold; text-decoration: none; margin-left:10px; color:green;"><i class="fas fa-file-pdf"></i> Generate PDF</a>';
                                    echo '<a href="delete_compute_stick.php?cs_id=' . htmlspecialchars($item['cs_id']) . '" class="btn btn-sm btn-danger btn-action" style="font-weight: bold; text-decoration: none; margin-left:10px; color:red;"><i class="fas fa-trash"></i> Delete</a>';
                                    echo '</td>';
                                    echo '<td>' . (!empty($item['compname']) ? htmlspecialchars($item['compname']) : 'N/A') . '</td>';//keeps for the table and filters 
                                    echo '<td>' . (!empty($item['user_profile']) ? htmlspecialchars($item['user_profile']) : 'N/A') . '</td>'; //keep for the table 
                        
                                    echo '<td>' . (!empty($item['osp_id']) ? htmlspecialchars($item['osp_id']) : 'N/A') . '</td>'; //keep this as is
                        



                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center">No records found</td></tr>';
                            }
                        } catch (PDOException $e) {
                            echo '<tr><td colspan="8" class="text-center">Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <script>
                    function filterTable2() {
                        const compName = document.getElementById('filterComputerName2').value.toLowerCase();
                        const userProfile = document.getElementById('filterUserProfile2').value.toLowerCase();
                        const windowsLicense = document.getElementById('filterWindowsLicense2').value.toLowerCase();

                        const table = document.getElementById('new');
                        const tbody = table.getElementsByTagName('tbody')[0];
                        const rows = tbody.getElementsByTagName('tr');

                        for (let i = 0; i < rows.length; i++) {
                            const cells = rows[i].getElementsByTagName('td');

                            // Skip rows that don't have enough cells (like "No records found")
                            if (cells.length < 5) continue;

                            const tdCompName = cells[2].textContent.trim().toLowerCase();
                            const tdUserProfile = cells[3].textContent.trim().toLowerCase();
                            const tdWindowsLicense = cells[4].textContent.trim().toLowerCase();

                            const matchesCompName = !compName || tdCompName === compName;
                            const matchesUserProfile = !userProfile || tdUserProfile === userProfile;
                            const matchesWindowsLicense = !windowsLicense || tdWindowsLicense === windowsLicense;

                            if (matchesCompName && matchesUserProfile && matchesWindowsLicense) {
                                rows[i].style.display = '';
                            } else {
                                rows[i].style.display = 'none';
                            }
                        }
                    }
                </script>



                <script>
                    $(document).ready(function () {
                        $('#new').DataTable({
                            responsive: true, // Makes the table responsive
                            paging: true,    // Enables pagination
                            searching: true, // Enables search bar
                            ordering: true,  // Enables column sorting
                            info: true       // Shows table information
                        });
                    });


                    document.addEventListener("DOMContentLoaded", function () {
                        // Set the current month as the default selected value

                        const dateSelect = document.getElementById('date2');
                        dateSelect.value = all;
                        filterdate2();  // Apply the filter by current month on page load
                    });

                    function filterdate2() {
                        const selectedMonth = document.getElementById('date2').value;
                        const rows = document.querySelectorAll('#new tbody tr');

                        rows.forEach(row => {
                            const dateCell = row.cells[0].textContent.trim(); // Date cell is in the 4th column
                            const rowMonth = new Date(dateCell).toLocaleString('default', { month: 'long' }).toLowerCase();

                            if (selectedMonth === 'all' || rowMonth === selectedMonth) {
                                row.style.display = '';  // Show the row
                            } else {
                                row.style.display = 'none';  // Hide the row
                            }
                        });
                    }

                </script>

            </div>

            <!--Compute Stick Section-->


            <!--Laptop Section-->
            <div id="laptop" class="page">
                <h2 style="color:black; font-size: 30px;">Laptop Inventory
                    <i class="fas fa-laptop"></i>
                </h2>


                <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: center;">
                    <select id="filterComputerNameLaptop" onchange="filterLaptopTable()">
                        <option value="">Select Computer Name</option>
                        <?php
                        try {
                            $stmt = $pdo->prepare("SELECT DISTINCT computer_name FROM tbl_laptop");
                            $stmt->execute();
                            $computers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($computers as $computer) {
                                echo '<option value="' . htmlspecialchars($computer['computer_name']) . '">' . htmlspecialchars($computer['computer_name']) . '</option>';
                            }
                        } catch (PDOException $e) {
                            echo '<option value="">Error loading data</option>';
                        }
                        ?>
                    </select>

                    <select id="filterUserProfileLaptop" onchange="filterLaptopTable()">
                        <option value="">Select User Profile</option>
                        <?php
                        try {
                            $stmt = $pdo->prepare("SELECT DISTINCT user_profile FROM tbl_laptop");
                            $stmt->execute();
                            $userProfiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($userProfiles as $profile) {
                                echo '<option value="' . htmlspecialchars($profile['user_profile']) . '">' . htmlspecialchars($profile['user_profile']) . '</option>';
                            }
                        } catch (PDOException $e) {
                            echo '<option value="">Error loading data</option>';
                        }
                        ?>
                    </select>

                    <select id="filterOspIdLaptop" onchange="filterLaptopTable()">
                        <option value="">Windows License</option>
                        <?php
                        try {
                            $stmt = $pdo->prepare("SELECT DISTINCT os_pk FROM tbl_laptop");
                            $stmt->execute();
                            $ospIds = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($ospIds as $ospId) {
                                echo '<option value="' . htmlspecialchars($ospId['os_pk']) . '">' . htmlspecialchars($ospId['os_pk']) . '</option>';
                            }
                        } catch (PDOException $e) {
                            echo '<option value="">Error loading data</option>';
                        }
                        ?>
                    </select>

                    <select id="filterMsOfficePidLaptop" onchange="filterLaptopTable()">
                        <option value="">Select MS Office PID</option>
                        <?php
                        try {
                            $stmt = $pdo->prepare("SELECT DISTINCT ms_office_pid FROM tbl_laptop");
                            $stmt->execute();
                            $msOfficePids = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($msOfficePids as $pid) {
                                echo '<option value="' . htmlspecialchars($pid['ms_office_pid']) . '">' . htmlspecialchars($pid['ms_office_pid']) . '</option>';
                            }
                        } catch (PDOException $e) {
                            echo '<option value="">Error loading data</option>';
                        }
                        ?>
                    </select>

                    <select id="filterMsOfficeAccountLaptop" onchange="filterLaptopTable()">
                        <option value="">Select MS Office Account</option>
                        <?php
                        try {
                            $stmt = $pdo->prepare("SELECT DISTINCT ms_office_lr FROM tbl_laptop");
                            $stmt->execute();
                            $msOfficeAccounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($msOfficeAccounts as $account) {
                                echo '<option value="' . htmlspecialchars($account['ms_office_lr']) . '">' . htmlspecialchars($account['ms_office_lr']) . '</option>';
                            }
                        } catch (PDOException $e) {
                            echo '<option value="">Error loading data</option>';
                        }
                        ?>
                    </select>


                </div>


                <button type="button" id="btnAddEmployee" class="btn btn-primary"
                    style="font-weight: bold; margin-bottom: 10px; margin-left: 10px; background-color: #0056b3"
                    onclick="window.location.href='add_laptop_form.php';">
                    <i class="fa-solid fa-file-signature"></i>
                    Add Laptop
                </button>


                <!-- Success Message -->
                <?php if (isset($_GET['msg'])): ?>
                    <div class="success-alert">
                        <?php echo htmlspecialchars($_GET['msg']); ?>
                    </div>
                <?php endif; ?>

                <!-- Medicine Table -->
                <table id="medicineTable" class="display">
                    <thead>
                        <tr>
                            <th>Laptop Id</th>
                            <th>Action</th>
                            <th style="width: 90px;">Computer Name</th>
                            <th>User Profile</th>
                            <th>Brand and Model</th>
                            <th>Windows License Key</th>
                            <th>MS Office Product ID</th>
                            <th>MS Office Account</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $type_of_license = $_GET['type_of_license'] ?? '';
                            $sql = "SELECT * FROM tbl_laptop";
                            if (!empty($type_of_license)) {
                                $sql .= " WHERE type_of_license = :type_of_license";
                            }

                            $stmt = $pdo->prepare($sql);
                            if (!empty($type_of_license)) {
                                $stmt->bindParam(':type_of_license', $type_of_license, PDO::PARAM_STR);
                            }
                            $stmt->execute();
                            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if ($data) {
                                foreach ($data as $item) {
                                    echo '<tr>';
                                    echo '<td>' . (!empty($item['l_id']) ? htmlspecialchars($item['l_id']) : 'N/A') . '</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">';
                                    echo '<a href="edit_laptop_form.php?l_id=' . htmlspecialchars($item['l_id']) . '" class="btn btn-sm btn-primary btn-action"  style="font-weight: bold; text-decoration: none;">
                                    <i class="fas fa-edit"></i> Edit/View Details
                                </a>';
                                 echo '<a href="generate_pdf_laptop.php?l_id=' . htmlspecialchars($item['l_id']) . '" class="btn btn-sm btn-success btn-action" style="font-weight: bold; text-decoration: none; margin-left:10px; color:green;"><i class="fas fa-file-pdf"></i> Generate PDF</a>';

                                    echo '<a href="delete_laptop.php?l_id=' . htmlspecialchars($item['l_id']) . '" class="btn btn-sm btn-danger btn-action" style="font-weight: bold; text-decoration: none; margin-left:10px; color:red;"><i class="fas fa-trash"></i> Delete</a>';
                                    echo '</td>';
                                    echo '<td>' . (!empty($item['computer_name']) ? htmlspecialchars($item['computer_name']) : 'N/A') . '</td>';//keeps for the table and filters 
                                    echo '<td>' . (!empty($item['user_profile']) ? htmlspecialchars($item['user_profile']) : 'N/A') . '</td>'; //keep for the table 
                                    echo '<td>' . (!empty($item['laptop_model']) ? htmlspecialchars($item['laptop_model']) : 'N/A') . '</td>';
                                    echo '<td>' . (!empty($item['os_pk']) ? htmlspecialchars($item['os_pk']) : 'N/A') . '</td>'; //keep this as is
                        

                                    echo '<td>' . (!empty($item['ms_office_pid']) ? htmlspecialchars($item['ms_office_pid']) : 'N/A') . '</td>'; //keep this as is
                                    echo '<td>' . (!empty($item['ms_office_lr']) ? htmlspecialchars($item['ms_office_lr']) : 'N/A') . '</td>'; //keep this as is
                        
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center">No records found</td></tr>';
                            }
                        } catch (PDOException $e) {
                            echo '<tr><td colspan="8" class="text-center">Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>


                <script>
                    $(document).ready(function () {
                        $('#medicineTable').DataTable({
                            responsive: true,
                            paging: true,
                            searching: true,
                            ordering: true,
                            info: true
                        });
                    });


                    function filterLaptopTable() {
                        const compName = document.getElementById('filterComputerNameLaptop').value.toLowerCase();
                        const userProfile = document.getElementById('filterUserProfileLaptop').value.toLowerCase();
                        const ospId = document.getElementById('filterOspIdLaptop').value.toLowerCase();
                        const msOfficePid = document.getElementById('filterMsOfficePidLaptop').value.toLowerCase();
                        const msOfficeAccount = document.getElementById('filterMsOfficeAccountLaptop').value.toLowerCase();

                        const table = document.getElementById('medicineTable');
                        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

                        for (let i = 0; i < rows.length; i++) {
                            const tdCompName = rows[i].cells[2].textContent.toLowerCase();
                            const tdUserProfile = rows[i].cells[3].textContent.toLowerCase();
                            const tdOspId = rows[i].cells[5].textContent.toLowerCase();
                            const tdMsOfficePid = rows[i].cells[6].textContent.toLowerCase();
                            const tdMsOfficeAccount = rows[i].cells[7].textContent.toLowerCase();

                            const matchesCompName = !compName || tdCompName.includes(compName);
                            const matchesUserProfile = !userProfile || tdUserProfile.includes(userProfile);
                            const matchesOspId = !ospId || tdOspId.includes(ospId);
                            const matchesMsOfficePid = !msOfficePid || tdMsOfficePid.includes(msOfficePid);
                            const matchesMsOfficeAccount = !msOfficeAccount || tdMsOfficeAccount.includes(msOfficeAccount);

                            if (matchesCompName && matchesUserProfile && matchesOspId && matchesMsOfficePid && matchesMsOfficeAccount) {
                                rows[i].style.display = '';
                            } else {
                                rows[i].style.display = 'none';
                            }
                        }
                    }

                </script>
            </div>
            <!--Laptop Section-->
        </div>


    </div>

    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Page Navigation
        function showPage(pageId) {
            $('.page').removeClass('active');
            $('#' + pageId).addClass('active');
        }

        // Toggle Form Visibility

        function logout() {

            window.location.replace("logout.php");

            // Alternatively, to ensure the history state is cleared:
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function () {
                window.history.go(1); // Prevent going back to the previous page
            };
        }

        //cancel
        function showPage(pageId) {
            // Hide all other sections (assuming all sections have the "page" class)
            document.querySelectorAll('.page').forEach(page => {
                page.style.display = 'none';
            });
            // Show the selected section
            document.getElementById(pageId).style.display = 'block';
        }

        // Check URL hash on page load


        window.onload = function () {
            const urlParams = new URLSearchParams(window.location.search);
            const hash = window.location.hash;

            if (urlParams.has('msg') || hash === '#payment') {
                showPage('payment');  // Show the payment section if `msg` is in the URL
            } else if (hash === '#license') {
                showPage('license'); // Show the license section
            } else if (hash === '#desktop') {
                showPage('desktop'); // Show the desktop section
            } else if (hash === '#compute_stick') {
                showPage('compute_stick'); // Show the compute stick section
            } else if (hash === '#laptop') {
                showPage('laptop'); // Show the laptop section
            } else if (hash === '#profile') {
                showPage('profile'); // Show the profile section
            }
        };

        $(document).ready(function () {
            // Handle form submission for adding medicine
            $('#addMedicineForm').submit(function (e) {
                e.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize(); // Serialize the form data

                $.ajax({
                    type: "POST",
                    url: "new_med.php", // The page that processes the form
                    data: formData,
                    success: function (response) {
                        if (response == 'success') {
                            // Show success message
                            $('#success-message').show();

                            // Update the table content by reloading #payment section
                            $('#payment').load('clinic_admin.php#payment');

                            // Scroll to the payment section
                            $('html, body').animate({
                                scrollTop: $('#payment').offset().top // Smooth scroll to payment section
                            }, 1000);
                        } else {
                            alert('Failed to add medicine. Please try again.');
                        }
                    }
                });
            });
        });
        $(document).ready(function () {
            // Initialize DataTable with pagination
            $('#example').DataTable({
                paging: true,
                searching: true,
                lengthChange: true, // Allows the user to choose the number of rows per page
                pageLength: 5, // Default rows per page
                info: true, // Show table info (e.g., "Showing 1 to 5 of 50 entries")
                responsive: true, // Make the table responsive on smaller screens
                language: {
                    paginate: {
                        previous: 'Prev',
                        next: 'Next'
                    }
                }
            });
        });


    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</body>

</html>