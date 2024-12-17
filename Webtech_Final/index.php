<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'db/db.php';
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
    <link rel="stylesheet" href="assets/css/Index.css">
    <script src="assets/js/Index.js" defer></script>
</head>
<body>
    <div class="container"></div>
    <div class="overlay"></div>

    <nav>
        <div class="logo">MindfulJournal</div>
        <div class="nav-links">
            <a href="view/about.php">About</a>
            <a href="view/login.php">Login</a>
            <a href="view/signupnew.php" class="cta-button">Get Started</a>
        </div>
    </nav>

    <div class="main-content">
        <section class="hero">
            <div class="hero-text">
                <h1>Your thoughts, beautifully organized</h1>
                <p>Create a safe space for your daily reflections, goals, and memories. Our intuitive journal platform helps you maintain a meaningful daily practice.</p>
                <a href="view/signup.php" class="cta-button">Start Journaling Free</a>
            </div>
        </section>

        <section class="features">
            <div class="feature-card">
                <h3>Daily Prompts</h3>
                <p>Get inspired with thoughtful prompts tailored to your journaling goals and mood.</p>
            </div>
            <div class="feature-card">
                <h3>Private & Secure</h3>
                <p>Your thoughts are precious. We use end-to-end encryption to keep your journal private.</p>
            </div>
            <div class="feature-card">
                <h3>Mood Tracking</h3>
                <p>Track your emotional journey with beautiful visualizations and insights.</p>
            </div>
        </section>

        <section class="how-it-works">
            <h2>How It Works</h2>
            <div class="step">
                <h3>1. Sign Up</h3>
                <p>Begin your journaling journey by signing up for free and setting your preferences.</p>
            </div>
            <div class="step">
                <h3>2. Write Daily</h3>
                <p>Use prompts, write freely, or reflect on your mood. It's all up to you.</p>
            </div>
            <div class="step">
                <h3>3. Review & Reflect</h3>
                <p>Look back on your entries, track your progress, and gain insights into your growth.</p>
            </div>
        </section>

        <section class="call-to-action">
            <h2>Ready to Start?</h2>
            <p>Join thousands of others in creating a meaningful and mindful journaling practice.</p>
            <a href="view/signup.php" class="cta-button">Start Journaling Free</a>
        </section>
    </div>
</body>
</html>