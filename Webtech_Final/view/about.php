<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../db/db.php';
$conn = connectDB();

// // Initialize session to track logged-in users
session_start();
 $user_id = $_SESSION['user_id'] ?? null; // Replace with your session variable

// // Close the database connection
 mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindful Journal - Your Digital Safe Space</title>
    <link rel="stylesheet" href="../assets/css/about.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="../assets/js/about.js" defer></script>
</head>
<body>
    <div class="container">
        <div class="overlay"></div>
        
        <nav>
            <div class="logo">MindfulJournal</div>
            <div class="nav-links">
                <a href="../index.php">Home</a>
                <a href="login.php">Login</a>
                <a href="signup.php" class="cta-button">Get Started</a>
            </div>
        </nav>

        <section class="hero">
            <div class="hero-content">
                <h1>Your Safe Space for Self-Reflection</h1>
                <p>"Our mission is to provide a secure and inviting space for people to reflect, grow, and keep track of their personal journeys"</p>
            </div>
        </section>

        <section id="features" class="section features">
            <h2 class="section-title">Why Choose MindfulJournal</h2>
            <div class="features-grid">
                <div class="feature">
                    <h3>Secure Journaling</h3>
                    <p>User accounts and data encryption ensure that your personal journal entries are private and safe</p>
                </div>
                <div class="feature">
                    <h3>Organized Entries</h3>
                    <p>Effortlessly add, view, edit, and delete journal entries, keeping everything in one place</p>
                </div>
                <div class="feature">
                    <h3>Tags and Moods</h3>
                    <p>Categorize entries with tags and track your mood for a deeper understanding of your journaling journey</p>
                </div>
                <div class="feature">
                    <h3>Quick Stats</h3>
                    <p>Monitor your journaling progress with statistics like streaks, entry count, and themes over time</p>
                </div>
            </div>
        </section>

        <!-- Rest of the sections remain the same until contact section -->

        <section id="contact" class="section contact">
            <h2>Contact Us</h2>
            <div class="contact-content">
                <div class="contact-info">
                    <p>Email: support@mindfuljournal.com</p>
                    <p>Phone: (555) 123-4567</p>
                    <p>Hours: Monday - Friday, 9AM - 5PM EST</p>
                </div>
                <div class="contact-form">
                    <form>
                        <input type="email" placeholder="Your email" required>
                        <textarea placeholder="Your message" required></textarea>
                        <button type="submit" class="submit-button">Send Message</button>
                    </form>
                </div>
            </div>
        </section>


    </div>
</body>
</html>