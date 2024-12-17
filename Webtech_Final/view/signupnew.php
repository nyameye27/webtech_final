<?php
session_start(); // This should be at the very beginning of each page.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Account</title>
    <script src="Signup.js" defer></script>
    <style>
        :root {
            --primary-color: #6a5acd;
            --secondary-color: #4b0082;
            --background-color: #f4f4f9;
            --text-color: #333;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .signup-container {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .signup-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }

        .signup-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .signup-header h1 {
            color: var(--secondary-color);
            font-size: 24px;
            margin-bottom: 10px;
        }

        .signup-header p {
            color: #777;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-color);
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(106, 90, 205, 0.1);
        }

        .btn-signup {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: var(--white);
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-signup:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .privacy-policy {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .privacy-policy input {
            margin-right: 10px;
        }

        .privacy-policy label {
            font-size: 12px;
            color: #777;
        }

        @media (max-width: 480px) {
            .signup-container {
                padding: 20px;
                margin: 0 10px;
            }
        }

        /* Add this to your existing CSS */
input.focused {
    border-color: #6a5acd;
    box-shadow: 0 0 0 3px rgba(106, 90, 205, 0.1);
}

input.invalid {
    border-color: #ff4136;
}

#password-strength {
    margin-top: 5px;
    border-radius: 2px;
    transition: width 0.3s ease;
}
    </style>
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