<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session for potential error handling and user tracking
session_start();

// Include database connection
require '../db/db.php';
$conn = connectDB();


//echo 'session '.$_SESSION['id'];


// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get database connection
    $conn = getDatabaseConnection();

    // Sanitize and validate inputs
    $title = filter_input(INPUT_POST, 'entryTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $mood = filter_input(INPUT_POST, 'entryMood', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'entryContent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Process tags (split comma-separated tags and sanitize)
    $tags_input = filter_input(INPUT_POST, 'entryTags', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tags = array_map('trim', explode(',', $tags_input));
    $tags = array_filter($tags); // Remove empty tags
    

    // Validate required fields
    $errors = [];
    if (empty($title)) $errors[] = "Title is required";
    if (empty($mood)) $errors[] = "Mood is required";
    if (empty($content)) $errors[] = "Content is required";
    
    // If no errors, insert entry into database
    if (empty($errors)) {
        // Prepare SQL to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO Entries (title, mood, user_id, content, tags, created_at) VALUES (?, ?, ?, ?, ?,  NOW())");
        
        // Convert tags to a JSON string for storage
        $tags_json = json_encode($tags);
        
        $stmt->bind_param("sssss", $title, $mood, $_SESSION['id'], $content, $tags_json);
        
        if ($stmt->execute()) {
            // Redirect to dashboard or show success message
            $_SESSION['success_message'] = "Entry saved successfully!";
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = "Error saving entry: " . $stmt->error;
        }
        
        $stmt->close();
    }
    
    // Store errors in session to display on page reload
    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
    }

    // Close database connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Entry</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/new_entry.css">
    <style>
        .error-message {
            color: red;
            margin-bottom: 15px;
        }
        .success-message {
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <nav class="main-navigation">
        <div class="nav-container">
            <div class="logo">
                <a href="index.php">Mindful Journal</a>
            </div>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="new_entry.php" class="active">New Entry</a></li>
                <li><a href="view entry.php">Past Entries</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../index.php">Home</a></li>
            </ul>
        </div>
    </nav>

    <?php
    // Display any errors
    if (isset($_SESSION['form_errors'])) {
        echo '<div class="error-message">';
        foreach ($_SESSION['form_errors'] as $error) {
            echo "<p>" . htmlspecialchars($error) . "</p>";
        }
        echo '</div>';
        // Clear the errors after displaying
        unset($_SESSION['form_errors']);
    }

    // Display success message
    if (isset($_SESSION['success_message'])) {
        echo '<div class="success-message">' . 
             htmlspecialchars($_SESSION['success_message']) . 
             '</div>';
        // Clear the success message
        unset($_SESSION['success_message']);
    }
    ?>

    <form id="newEntryForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <header>
            <h1>Create New Journal Entry</h1>
        </header>
        
        <div class="form-left">
            <!-- Title -->
            <div>
                <label for="entryTitle">Title</label>
                <input type="text" id="entryTitle" name="entryTitle" 
                       placeholder="Enter your title here" 
                       value="<?php echo isset($_POST['entryTitle']) ? htmlspecialchars($_POST['entryTitle']) : ''; ?>"
                       required>
            </div>
            
            <!-- Mood Selector -->
            <div>
                <label for="entryMood">Mood</label>
                <select id="entryMood" name="entryMood" required>
                    <option value="" disabled selected>-- Select your mood --</option>
                    <option value="happy" <?php echo (isset($_POST['entryMood']) && $_POST['entryMood'] == 'happy') ? 'selected' : ''; ?>>Happy 😊</option>
                    <option value="sad" <?php echo (isset($_POST['entryMood']) && $_POST['entryMood'] == 'sad') ? 'selected' : ''; ?>>Sad 😔</option>
                    <option value="excited" <?php echo (isset($_POST['entryMood']) && $_POST['entryMood'] == 'excited') ? 'selected' : ''; ?>>Excited 🎉</option>
                    <option value="angry" <?php echo (isset($_POST['entryMood']) && $_POST['entryMood'] == 'angry') ? 'selected' : ''; ?>>Angry 😡</option>
                    <option value="relaxed" <?php echo (isset($_POST['entryMood']) && $_POST['entryMood'] == 'relaxed') ? 'selected' : ''; ?>>Relaxed 😌</option>
                </select>
            </div>
            
            <!-- Tags -->
            <div>
                <label for="entryTags">Tags</label>
                <input type="text" id="entryTags" name="entryTags" 
                       placeholder="Add tags (comma-separated)"
                       value="<?php echo isset($_POST['entryTags']) ? htmlspecialchars($_POST['entryTags']) : ''; ?>">
            </div>
        </div>
        
        <div class="form-right">
            <!-- Content -->
            <label for="entryContent">Content</label>
            <textarea id="entryContent" name="entryContent" 
                      placeholder="Start writing your entry here..." 
                      required><?php echo isset($_POST['entryContent']) ? htmlspecialchars($_POST['entryContent']) : ''; ?></textarea>
            
            <!-- Submit Button -->
            <button type="submit">Save Entry</button>
        </div>
    </form>
    
    <script src="../assets/js/journal-entry.js"></script>
</body>
</html>