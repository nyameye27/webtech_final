document.addEventListener("DOMContentLoaded", () => {
    // Profile Update Form
    const profileForm = document.getElementById("profileForm");
    profileForm.addEventListener("submit", (event) => {
        event.preventDefault();
        
        const username = document.getElementById("username").value;
        const email = document.getElementById("email").value;

        // Mock saving data to the server
        console.log("Profile updated:", { username, email });
        alert("Profile updated successfully!");
    });

    // Password Change Form
    const passwordForm = document.getElementById("passwordForm");
    passwordForm.addEventListener("submit", (event) => {
        event.preventDefault();
        
        const currentPassword = document.getElementById("currentPassword").value;
        const newPassword = document.getElementById("newPassword").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        if (newPassword !== confirmPassword) {
            alert("New passwords do not match. Please try again.");
            return;
        }

        // Mock password update
        console.log("Password updated");
        alert("Password updated successfully!");
    });

    // Preferences Form
    const preferencesForm = document.getElementById("preferencesForm");
    const themeToggle = document.getElementById("themeToggle");
    const notifications = document.getElementById("notifications");
    const language = document.getElementById("language");

    // Load saved preferences from localStorage
    if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark-mode");
        themeToggle.checked = true;
    }
    if (localStorage.getItem("notifications") === "enabled") {
        notifications.checked = true;
    } else {
        notifications.checked = false;
    }
    language.value = localStorage.getItem("language") || "en";

    // Toggle Dark Mode
    themeToggle.addEventListener("change", () => {
        if (themeToggle.checked) {
            document.body.classList.add("dark-mode");
            localStorage.setItem("darkMode", "enabled");
        } else {
            document.body.classList.remove("dark-mode");
            localStorage.setItem("darkMode", "disabled");
        }
    });

    // Handle Notifications Toggle
    notifications.addEventListener("change", () => {
        if (notifications.checked) {
            localStorage.setItem("notifications", "enabled");
        } else {
            localStorage.setItem("notifications", "disabled");
        }
    });

    // Save Language Preference
    language.addEventListener("change", () => {
        localStorage.setItem("language", language.value);
    });

    // Save Preferences on Form Submission
    preferencesForm.addEventListener("submit", (event) => {
        event.preventDefault();
        alert("Preferences saved successfully!");
    });
});