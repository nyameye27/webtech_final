<?php
session_start(); // This should be at the very beginning of each page.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../assets/css/Login.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="container"></div> <!-- Background container -->
    <div class="overlay"></div> <!-- Gradient overlay -->

    <form method="POST" action="../actions/login_user.php">
        <fieldset>
            <h2>Login</h2>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <div style="display: inline-block;">
                <input type="checkbox" id="remember-me" name="remember-me">
                <label for="remember-me">Remember me</label>
            </div>

            <input type="submit" value="Login">
            <p>Don't have an account? <a href="./register.php">Register here</a></p>
        </fieldset>
    </form>
</body>
</html>