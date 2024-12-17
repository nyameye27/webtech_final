console.log('JS file is loaded'); // Check if JS file is loading correctly

const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
console.log('isLoggedIn:', localStorage.getItem('isLoggedIn')); // Debugging
console.log('isLoggedIn (boolean):', isLoggedIn); // Debugging

const authenticatedLinks = [
    { href: "view/Settings.html", text: "Settings" },
    { href: "view/view_entry.html", text: "View Entries" },
    { href: "view/new_entry.html", text: "New Entries" },
    { href: "view/dashboard.html", text: "Dashboard" },
    { href: "Logout.php", text: "Logout" }
];

document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelector('.nav-links');
    if (!navLinks) {
        console.error('Nav links element not found');
        return; // Exit the function if navLinks is not found
    }

    console.log('Nav links element found'); // Verify the element is found

    if (isLoggedIn) {
        console.log('User is logged in');
        authenticatedLinks.forEach(link => {
            const navLink = document.createElement('a');
            navLink.href = link.href;
            navLink.textContent = link.text;
            navLinks.appendChild(navLink);
        });
    } 
        
});