<?php
session_start(); // This should be at the very beginning of each page.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Account</title>
    <link rel="stylesheet" href="../assets/css/SignUp.css">
    <script src="Signup.js" defer></script>
    
</head>
<body>
    <div class="signup-container">
        <div class="signup-header">
            <h1>Create Your Account</h1>
            <p>Join our community and unlock endless possibilities</p>
        </div>
        
        <form action="../actions/register_user.php" method="POST">
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="Email" class="form-control" placeholder="Enter your email" required>
    </div>

    <div class="form-group">
        <label for="fname">First Name</label>
        <input type="text" id="fname" name="First_name" class="form-control" placeholder="Your first name" required>
    </div>

    <div class="form-group">
        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="Last_name" class="form-control" placeholder="Your last name" required>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="Username" class="form-control" placeholder="Choose a unique username" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="Password" class="form-control" 
               placeholder="Create a strong password" 
               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
               title="Must contain at least one number, one uppercase and lowercase letter, and be at least 8 characters long"
               required>
    </div>

    <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="Password_Confirmation" class="form-control" placeholder="Repeat your password" required>
    </div>

            <div class="privacy-policy">
                <input type="checkbox" id="privacy-policy" name="privacy-policy" required>
                <label for="privacy-policy">I agree to the Terms of Service and Privacy Policy</label>
            </div>

            <button type="submit" class="btn-signup">Create Account</button>

            <div class="login-link">
                Already have an account? <a href="login.php">Log In</a>
            </div>
        </form>
    </div>
</body>
</html>