<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include database connection
require '../db/db.php';
$conn = connectDB();

// Initialize session (for production)
session_start();
$user_id = $_SESSION['id'] ?? 1; // Hardcoded for development, replace with session variable

// Fetch user details
$user_query = "SELECT username FROM Users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$username = ($user_result->num_rows > 0) ? $user_result->fetch_assoc()['username'] : 'Users';
$stmt->close();

// Fetch journaling stats
$stats_query = "SELECT COUNT(*) AS total_entries, MAX(created_at) AS last_entry FROM Entries WHERE user_id = ?";
$stmt = $conn->prepare($stats_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stats_result = $stmt->get_result();
$stats = $stats_result->fetch_assoc();
$stmt->close();

// Fetch recent entries
$entries_query = "SELECT title, DATE_FORMAT(created_at, '%Y-%m-%d') AS entry_date FROM Entries WHERE user_id = ? ORDER BY created_at DESC LIMIT 3";
$stmt = $conn->prepare($entries_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$entries_result = $stmt->get_result();
$entries = $entries_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Daily prompt
$daily_prompt = "Reflect on one challenge you overcame today.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindful Journal - Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="../assets/js/dashboard.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>MyJournal</h1>
            </div>
            <div class="user-info">
                <p>Welcome back, <strong><?php echo htmlspecialchars($username); ?></strong></p>
                <a href="logout.php" class="logout">Logout</a>
            </div>
        </nav>
    </header>

    <main>
        <aside class="sidebar">
            <ul>
                <li><a href="new_entry.php">New Entry</a></li>
                <li><a href="view entry.php">View Entries</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </aside>

        <section class="content">
            <!-- Welcome Message -->
            <div id="welcome-message" class="section">
                <h2>Welcome back, <?php echo htmlspecialchars($username); ?>!</h2>
                <p>Today is <strong><?php echo date('Y-m-d'); ?></strong>. Take a moment to reflect and start journaling!</p>
            </div>

            <!-- Quick Stats -->
            <div id="quick-stats" class="section">
                <h2>Your Journaling Stats</h2>
                <ul class="stats-list">
                    <li>Total Entries: <strong><?php echo $stats['total_entries'] ?? 0; ?></strong></li>
                    <li>Last Entry: <strong><?php echo $stats['last_entry'] ?? 'N/A'; ?></strong></li>
                    
                </ul>
            </div>

            <!-- Recent Entries -->
            <div id="recent-entries" class="section">
                <h2>Recent Entries</h2>
                <ul class="entry-list">
                    <?php if (!empty($entries)): ?>
                        <?php foreach ($entries as $entry): ?>
                            <li>
                                <a href="view_entry.php?id=<?php echo $entry['user_id']; ?>">
                                    <?php echo htmlspecialchars($entry['title']); ?>
                                </a> - <span><?php echo $entry['entry_date']; ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No recent entries available.</li>
                    <?php endif; ?>
                </ul>
                <button onclick="location.href='view_entries.php'" class="button">View All Entries</button>
            </div>

            <!-- Daily Prompt -->
            <div id="daily-prompt" class="section">
                <h2>Today's Prompt</h2>
                <p><em><?php echo htmlspecialchars($daily_prompt); ?></em></p>
                <button onclick="location.href='new_entry.php'" class="button">Start Writing</button>
            </div>

            <!-- Mood Tracker -->
            <div id="mood-tracker" class="section">
                <h2>Your Mood Tracker</h2>
                <p>Mood trends for the past week:</p>
                <div id="mood-chart">
                    <!-- Placeholder for mood chart -->
                    <canvas id="moodCanvas"></canvas>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Mindful Journal. All rights reserved.</p>
    </footer>
</body>
</html>