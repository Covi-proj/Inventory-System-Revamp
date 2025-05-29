<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // In a real application, you should use proper password hashing
    // This is just for demonstration purposes
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = 'Admin';
        header('Location: inventory.php');
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IT Inventory System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="photos/icon.jfif" type="image/png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #2e59d9;
            --accent-color: #858796;
        }

        body {
            background: linear-gradient(135deg, #f8f9fc 0%, #e3e6f0 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .card-login {
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
            background: white;
        }

        .card-login:hover {
            transform: translateY(-5px);
        }

        .login-image {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-image img {
            max-width: 100%;
            height: auto;
        }

        .card-body {
            padding: 3rem;
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d3e2;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(78, 115, 223, 0.25);
        }

        .btn-secondary {
            background: #f8f9fc;
            color: var(--accent-color);
            border: 1px solid #d1d3e2;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #e3e6f0;
            color: var(--primary-color);
        }

        .login-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 2rem;
        }

        .login-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .loading {
            display: none;
        }

        .loading.active {
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .card-login {
                margin: 1rem;
            }

            .card-body {
                padding: 2rem;
            }

            .login-image {
                display: none;
            }
        }

        footer {
            margin-top: auto;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card-login o-hidden border-0 shadow-lg my-5">
                    <div class="row">
                        <!-- Image Section -->
                        <div class="col-lg-6 d-none d-lg-block login-image">
                            <div class="w-100 d-flex justify-content-center align-items-center" style="height:100%;">
                                <img src="photos/hepc.jpg" alt="Inventory Management" class="img-fluid" style="max-height: 450px; width: 100%; object-fit: contain; display: block; margin: 0 auto;">
                            </div>
                        </div>
                        <!-- Form Section -->
                        <div class="col-lg-6">
                            <div class="card-body">
                                <div class="text-center">
                                    <i class="fas fa-box login-icon"></i>
                                    <h1 class="h4 text-gray-900 mb-4 login-title">IT Inventory System</h1>
                                </div>
                                <div id="messageContainer"></div>
                                <form id="loginForm">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" id="username" class="form-control" placeholder="Enter your username" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" id="password" class="form-control" placeholder="Enter your password" required>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <span class="spinner-border spinner-border-sm loading" role="status"></span>
                                            Log In
                                        </button>
                                    </div>
                                </form>
                                <div class="text-center mt-3">
                                    <!--
                                    <button class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#registerModal">
                                        Create an Account
                                    </button>
                                    -->
                                    <a href="usersguide/it_guide.pdf" style="text-decoration: none; margin-top: 30px; font-weight: bold; display: inline-block;">
                                        <i class="fas fa-book"></i> Users Manual
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Create Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm">
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" id="fullName" class="form-control" placeholder="Enter your full name" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="registerUsername" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                                <input type="text" id="registerUsername" class="form-control" placeholder="Enter your username" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="registerPassword" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" id="registerPassword" class="form-control" placeholder="Enter your password" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm your password" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100">
                                <span class="spinner-border spinner-border-sm loading" role="status"></span>
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-white text-center py-4">
        <p class="mb-0">© <span id="currentYear"></span> Hayakawa Electronics (Phil.s). Corp. All rights reserved. Version 1.1</p>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            const yearElement = document.getElementById('currentYear');
            const currentYear = new Date().getFullYear();
            yearElement.textContent = currentYear;
            });
        </script>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            // Login form submission
            $('#loginForm').submit(function (e) {
                e.preventDefault();
                const submitBtn = $(this).find('button[type="submit"]');
                const loadingSpinner = submitBtn.find('.loading');
                
                submitBtn.prop('disabled', true);
                loadingSpinner.addClass('active');

                var username = $('#username').val();
                var password = $('#password').val();

                $.ajax({
                    url: 'login_request.php',
                    method: 'POST',
                    data: {
                        username: username,
                        password: password
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            window.location.replace(response.redirect);
                        } else {
                            $('#messageContainer').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#messageContainer').html('<div class="alert alert-danger">Error occurred: ' + (xhr.responseText || 'Please try again later') + '</div>');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false);
                        loadingSpinner.removeClass('active');
                    }
                });
            });

            // Register form submission
            $('#registerForm').submit(function (e) {
                e.preventDefault();
                const submitBtn = $(this).find('button[type="submit"]');
                const loadingSpinner = submitBtn.find('.loading');
                
                submitBtn.prop('disabled', true);
                loadingSpinner.addClass('active');

                let fullName = $('#fullName').val();
                let username = $('#registerUsername').val();
                let passwords = $('#registerPassword').val();
                let confirmPassword = $('#confirmPassword').val();

                if (passwords !== confirmPassword) {
                    alert('Passwords do not match!');
                    submitBtn.prop('disabled', false);
                    loadingSpinner.removeClass('active');
                    return;
                }

                $.ajax({
                    url: 'register_request.php',
                    type: 'POST',
                    data: { fullName, username, passwords },
                    success: function (response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            $('#registerModal').modal('hide');
                            $('#registerForm')[0].reset();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function () {
                        alert('An error occurred. Please try again.');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false);
                        loadingSpinner.removeClass('active');
                    }
                });
            });
        });
    </script>
</body>

</html>