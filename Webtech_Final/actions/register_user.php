<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../db/db.php';
$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Safely retrieve and sanitize inputs
    $email = filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_STRING);
    $password_confirm = filter_input(INPUT_POST, 'Password_Confirmation', FILTER_SANITIZE_STRING);
    $fname = filter_input(INPUT_POST, 'First_name', FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST, 'Last_name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'Username', FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($email) || empty($password) || empty($fname) || empty($lname) || empty($username)) {
        die('All fields are required. Please fill out all fields.');
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format.');
    }

    // Password confirmation check
    if ($password !== $password_confirm) {
        die('Passwords do not match.');
    }

    // Password strength validation
    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $password)) {
        die('Password must contain at least one number, one uppercase and lowercase letter, and be at least 8 characters long.');
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'regular';

    // Check if email already exists
    $checkQuery = "SELECT id FROM Users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        die('This email is already registered. Please use a different email.');
    }
    mysqli_stmt_close($stmt);

    // Prepare insertion query
    $query = "INSERT INTO Users (fname, lname, email, username, password_hash, userrole, created_at) 
              VALUES (?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssss", $fname, $lname, $email, $username, $hashed_password, $role);

    if (mysqli_stmt_execute($stmt)) {
        // Successful registration
        session_start();
        $_SESSION['signup_success'] = 'Account created successfully. Please log in.';
        header("Location: ./../view/login.php");
        exit();
    } else {
        // Registration failed
        $_SESSION['signup_error'] = 'Registration failed. Please try again.';
        header("Location: ./../view/signup.php");
        exit();
    }
    
    mysqli_stmt_close($stmt);
}
?>