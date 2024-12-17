<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up</title>
    <link rel="stylesheet" href="../assets/css/SignUp.css">
    <script src="Signup.js" defer></script>
</head>
<body>
    <div class="container">
        <div class="overlay"></div>
        <form action="/full/path/to/actions/register_user.php" method="POST" id="signup" class="form-box">
            <fieldset>
                <h2>Step Into Your Story!</h2><br>
                
                <!-- Email Input -->
                <input type="email" id="email" placeholder="Email" name="Email" required><br><br>
                
                <!-- First Name Input -->
                <input type="text" id="fname" placeholder="First name" name="First name" required><br><br>
                
                <!-- Last Name Input -->
                <input type="text" id="lname" placeholder="Last name" name="Last name" required><br><br>
                
                <!-- Username Input -->
                <input type="text" id="user_name" placeholder="Username" name="Username" required><br><br>
                
                <!-- Password Input -->
                <input type="password" id="password1" placeholder="Password" name="Password" 
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                       title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" 
                       required><br><br>
                
                <!-- Password Confirmation Input -->
                <input type="password" id="password2" placeholder="Confirm Password" name="Password Confirmation" required><br><br>
                
                <!-- Privacy Policy Checkbox -->
                <div style="display: inline-block;">
                    <input type="checkbox" id="privacy-policy" name="privacy-policy" required>
                    <label for="privacy-policy">I accept the Privacy Policy</label>
                </div>
                <br><br><br>
                
                <!-- Submit Button -->
                <input type="submit" value="Create account"><br><br>
                
                <!-- Login Link -->
                <p>Already a Member? <a href="login.php" title="Log In">Log In</a></p>
            </fieldset>
        </form>
    </div>
</body>
</html>