<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include database connection
require '../db/db.php';
$conn = connectDB();

// Initialize session (for production)
session_start();
$user_id = $_SESSION['id'] ?? 1; // Hardcoded for now, replace with session variable

// Fetch user information
$user_query = "SELECT username, email, preferences FROM Users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$stmt->close();

// Placeholder for form processing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['updateProfile'])) {
        // Update profile details
        $username = $_POST['username'];
        $email = $_POST['email'];
        $update_query = "UPDATE Users SET username = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssi", $username, $email, $user_id);
        $stmt->execute();
        $stmt->close();
        $user['username'] = $username;
        $user['email'] = $email;
        $message = "Profile updated successfully!";
    } elseif (isset($_POST['updatePassword'])) {
        // Update password logic (placeholder)
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        // Verify and update password (Add hashing and verification in production)
        if ($newPassword === $confirmPassword) {
            $password_query = "UPDATE Users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($password_query);
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt->bind_param("si", $hashedPassword, $user_id);
            $stmt->execute();
            $stmt->close();
            $message = "Password updated successfully!";
        } else {
            $message = "Passwords do not match.";
        }
    } elseif (isset($_POST['updatePreferences'])) {
        // Update preferences
        $themeToggle = isset($_POST['themeToggle']) ? 1 : 0;
        $notifications = isset($_POST['notifications']) ? 1 : 0;
        $language = $_POST['language'];
        $preferences_query = "UPDATE Users SET preferences = ? WHERE id = ?";
        $preferences = json_encode(['theme' => $themeToggle, 'notifications' => $notifications, 'language' => $language]);
        $stmt = $conn->prepare($preferences_query);
        $stmt->bind_param("si", $preferences, $user_id);
        $stmt->execute();
        $stmt->close();
        $message = "Preferences updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Personal Journal</title>
    <link rel="stylesheet" href="../assets/css/settings.css">
    <script src="../assets/js/settings.js" defer></script>
</head>
<body>
    <nav class="main-navigation">
        <div class="nav-container">
            <div class="logo">
                <h1>MyJournal</h1>
            </div>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="new_entry.php">New Entry</a></li>
                <li><a href="view entry.php">Past Entries</a></li>
                <li><a href="settings.php" class="active">Settings</a></li>
                <li><a href="../index.php">Home</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>Settings</h1>

        <?php if (isset($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <!-- Profile Section -->
        <section class="settings-section">
            <h2>Profile Information</h2>
            <form method="POST">
                <input type="hidden" name="updateProfile" value="1">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <button type="submit">Save Changes</button>
            </form>
        </section>

        <!-- Password Section -->
        <section class="settings-section">
            <h2>Change Password</h2>
            <form method="POST">
                <input type="hidden" name="updatePassword" value="1">
                <label for="currentPassword">Current Password</label>
                <input type="password" id="currentPassword" name="currentPassword" required>

                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="newPassword" required>

                <label for="confirmPassword">Confirm New Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>

                <button type="submit">Update Password</button>
            </form>
        </section>

        <!-- Preferences Section -->
        
    </div>
</body>
</html>