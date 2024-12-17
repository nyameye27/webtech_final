// Check if the user is logged in using localStorage (or sessionStorage)
const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true'; // Simulate checking the login state

// Links for logged-in users
const authenticatedLinks = [
    { href: "view/Settings.html", text: "Settings" },
    { href: "view/view entry.html", text: "View Entries" },
    { href: "view/new_entry.html", text: "New Entries" },
    { href: "view/dashboard.html", text: "Dashboard" },
    { href: "Logout.php", text: "Logout" }
];

document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelector('.nav-links');

    if (isLoggedIn) {
        // Show the authenticated links
        authenticatedLinks.forEach(link => {
            const navLink = document.createElement('a');
            navLink.href = link.href;
            navLink.textContent = link.text;
            navLinks.appendChild(navLink);
        });
     } //else {
    //     // Optionally, you can show some links for non-logged-in users
    //     const loginLink = document.createElement('a');
    //     loginLink.href = 'view/Login.html';
    //     loginLink.textContent = 'Login';
    //     navLinks.appendChild(loginLink);

    //     // const signupLink = document.createElement('a');
    //     // signupLink.href = 'view/signup.html';
    //     // signupLink.textContent = 'Sign Up';
    //     // navLinks.appendChild(signupLink);
    // }
});