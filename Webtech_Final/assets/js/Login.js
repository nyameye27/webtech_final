document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    

    form.addEventListener('submit', function (event) {
        const email = emailField.value.trim();
        const password = passwordField.value.trim();
    
        // Debugging
        console.log('Form submitted:', { email, password });
    
        // Validation logic...
    }); 
    
    // Function to validate email format
    function validateEmail(email) {
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return emailPattern.test(email);
    }

    // Function to validate password strength
    function validatePassword(password) {
        const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
        return passwordPattern.test(password);
    }

    // Handle form submission
    form.addEventListener('submit', function (event) {
        const email = emailField.value.trim();
        const password = passwordField.value.trim();

        // Check if fields are empty
        if (!email || !password) {
            alert('Please fill out all fields.');
            event.preventDefault();
            return;
        }

        // Validate email
        if (!validateEmail(email)) {
            alert('Please enter a valid email address.');
            emailField.focus();
            event.preventDefault();
            return;
        }

        // Validate password
        if (!validatePassword(password)) {
            alert('Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, and one number.');
            passwordField.focus();
            event.preventDefault();
            return;
        }
    });

    // Optional: Real-time validation feedback for email
    emailField.addEventListener('input', function () {
        if (!validateEmail(emailField.value.trim())) {
            emailField.setCustomValidity('Please enter a valid email address.');
        } else {
            emailField.setCustomValidity('');
        }
    });

    // Optional: Real-time validation feedback for password
    passwordField.addEventListener('input', function () {
        if (!validatePassword(passwordField.value.trim())) {
            passwordField.setCustomValidity(
                'Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, and one number.'
            );
        } else {
            passwordField.setCustomValidity('');
        }
    });
});

