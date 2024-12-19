<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../db/db.php';

$conn = connectDB();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        die('Do not leave fields empty');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format');
    }

    $query = 'SELECT id, fname, lname, password_hash, userrole, username FROM Users WHERE email = ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $results = $stmt->get_result();

    if ($results->num_rows > 0) {
        $row = $results->fetch_assoc();

        $user_id = $row['id'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $user_password = $row['password_hash'];
        $user_role = $row['userrole'];
        $username = $row['username']; // Corrected variable name here

        if (password_verify($password, $user_password)) {
            $_SESSION['id'] = $user_id;
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['userrole'] = $user_role;
            $_SESSION['username'] = $username; // Corrected variable name here


          

            if ($user_role == "admin") {
                header('Location: ./../view/admin/admin_dashboard.php');
                exit(); // Ensure the script stops after redirection
            } elseif ($user_role == "regular") {
                header('Location: ./../view/new_entry.php');
                exit();
            } else {
                header('Location: ./../view/login.php');
                exit();
            }
        } else {
            // Incorrect password redirect
            echo "<script>alert('Incorrect password'); window.location.href = './../view/login.php';</script>";
            exit();
        }
    } else {
        // User not registered redirect
        echo "<script>alert('User not registered'); window.location.href = './../view/login.php';</script>";
        exit();
    }
}  
?>