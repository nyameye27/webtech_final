document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const emailInput = document.getElementById('email');
    const fnameInput = document.getElementById('fname');
    const lnameInput = document.getElementById('lname');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const privacyPolicyCheckbox = document.getElementById('privacy-policy');

    // Validation functions
    function validateEmail(email) {
        const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return re.test(String(email).toLowerCase());
    }

    function validatePassword(password) {
        // At least 8 characters, one uppercase, one lowercase, one number
        const re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
        return re.test(password);
    }

    function validateUsername(username) {
        // Alphanumeric, 3-16 characters
        const re = /^[a-zA-Z0-9_]{3,16}$/;
        return re.test(username);
    }

    // Real-time validation
    function addRealtimeValidation(input, validationFunction, errorMessage) {
        input.addEventListener('input', function() {
            const value = input.value.trim();
            if (value && !validationFunction(value)) {
                input.setCustomValidity(errorMessage);
                input.classList.add('invalid');
            } else {
                input.setCustomValidity('');
                input.classList.remove('invalid');
            }
        });
    }

    // Add real-time validations
    addRealtimeValidation(emailInput, validateEmail, 'Please enter a valid email address');
    addRealtimeValidation(usernameInput, validateUsername, 'Username must be 3-16 characters long and can only contain letters, numbers, and underscores');
    addRealtimeValidation(passwordInput, validatePassword, 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number');

    // Password confirmation validation
    confirmPasswordInput.addEventListener('input', function() {
        if (passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordInput.setCustomValidity('Passwords do not match');
        } else {
            confirmPasswordInput.setCustomValidity('');
        }
    });

    // Form submission validation
    form.addEventListener('submit', function(event) {
        // Reset previous validations
        emailInput.setCustomValidity('');
        usernameInput.setCustomValidity('');
        passwordInput.setCustomValidity('');
        confirmPasswordInput.setCustomValidity('');

        // Perform validations
        let isValid = true;

        if (!validateEmail(emailInput.value)) {
            emailInput.setCustomValidity('Please enter a valid email address');
            isValid = false;
        }

        if (!validateUsername(usernameInput.value)) {
            usernameInput.setCustomValidity('Username must be 3-16 characters long and can only contain letters, numbers, and underscores');
            isValid = false;
        }

        if (!validatePassword(passwordInput.value)) {
            passwordInput.setCustomValidity('Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number');
            isValid = false;
        }

        if (passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordInput.setCustomValidity('Passwords do not match');
            isValid = false;
        }

        if (!privacyPolicyCheckbox.checked) {
            privacyPolicyCheckbox.setCustomValidity('You must accept the privacy policy');
            isValid = false;
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            event.preventDefault();
        }
    });

    // Optional: Add visual feedback for inputs
    const inputs = [emailInput, fnameInput, lnameInput, usernameInput, passwordInput, confirmPasswordInput];
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            this.classList.remove('focused');
        });
    });

    // Password strength indicator (optional)
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strengthIndicator = document.createElement('div');
        strengthIndicator.id = 'password-strength';
        
        if (password.length === 0) {
            strengthIndicator.textContent = '';
            return;
        }

        let strength = 0;
        if (password.length >= 8) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;

        strengthIndicator.style.width = `${strength * 20}%`;
        strengthIndicator.style.height = '4px';
        strengthIndicator.style.backgroundColor = 
            strength < 2 ? 'red' : 
            strength < 4 ? 'orange' : 
            'green';
        
        // Remove any existing strength indicator
        const existingIndicator = document.getElementById('password-strength');
        if (existingIndicator) {
            existingIndicator.remove();
        }

        // Add new strength indicator
        this.parentNode.insertBefore(strengthIndicator, this.nextSibling);
    });
});
