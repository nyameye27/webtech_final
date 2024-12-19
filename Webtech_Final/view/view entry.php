<?php
// Start session at the very beginning of the scrip


// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// Include the database connection file
require '../db/db.php';
$conn = connectDB();

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();  
}

// // Get database connection
// try {
//     $pdo = getDatabaseConnection();
// } catch (Exception $e) {
//     // Handle connection error
//     die("Database Connection Failed: " . $e->getMessage());
// }

/// Example: Fetching a username using mysqli prepared statements
$stmt = $conn->prepare("SELECT username FROM Users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']); // Bind the parameter
$stmt->execute(); // Execute the query

// Bind the result variables
$stmt->bind_result($username);

// Fetch the result
if ($stmt->fetch()) {
    echo "Username: " . $username;
} else {
    echo "No user found.";
}

$stmt->close();

// Entry Filtering Logic
$searchTerm = $_GET['search'] ?? '';
$mood = $_GET['mood'] ?? 'all';
$date = $_GET['date'] ?? '';

// Initialize the base query
$query = "SELECT entry_id, title, created_at, content, mood FROM Entries WHERE user_id = ?";
$params = [$_SESSION['id']];

// Build dynamic filters
if (!empty($searchTerm)) {
    $query .= " AND (title LIKE ? OR content LIKE ?)";
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
}

if ($mood !== 'all') {
    $query .= " AND mood = ?";
    $params[] = $mood;
}

if (!empty($date)) {
    $query .= " AND DATE(created_at) = ?";
    $params[] = $date;
}

// Append order by clause
$query .= " ORDER BY created_at DESC";

// Prepare and execute the query
if ($stmt = $conn->prepare($query)) {
    // Bind parameters dynamically
    $types = str_repeat('s', count($params)); // Generate parameter types (all as strings here for simplicity)
    $stmt->bind_param($types, ...$params);

    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch results
    $entries = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement
    $stmt->close();
} else {
    $entries = []; // Fallback for errors
    error_log("Query preparation failed: " . $conn->error);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindful Journal - View Entries</title>
    <link rel="stylesheet" href="../assets/css/view entry.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="../assets/js/view_entry.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>Mindful Journal</h1>
            </div>
            <div class="user-info">
                <p>Welcome, <strong><?php echo htmlspecialchars($user['username'] ?? 'User'); ?></strong></p>
                <a href="logout.php" class="logout">Logout</a>
            </div>
        </nav>
    </header>

    <input type="checkbox" id="sidebar-toggle" class="sidebar-toggle">
    <label for="sidebar-toggle" class="sidebar-toggle-label">☰ Menu</label>

    <aside class="sidebar">
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="new_entry.php">New Entry</a></li>
            <li><a href="view entry.php" class="active">View Entries</a></li>
            <li><a href="settings.php">Settings</a></li>
        </ul>
    </aside>

    <main>
        <section class="content">
            <div class="entries-header">
                <h2>View Journal Entries</h2>
                <form method="GET" action="">
                    <input type="text" name="search" id="search-bar" placeholder="Search by title, mood, or date" 
                           value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <div class="filters">
                        <label for="filter-mood">Filter by Mood:</label>
                        <select name="mood" id="filter-mood">
                            <option value="all" <?php echo $mood == 'all' ? 'selected' : ''; ?>>All</option>
                            <option value="happy" <?php echo $mood == 'happy' ? 'selected' : ''; ?>>Happy</option>
                            <option value="sad" <?php echo $mood == 'sad' ? 'selected' : ''; ?>>Sad</option>
                            <option value="angry" <?php echo $mood == 'angry' ? 'selected' : ''; ?>>Angry</option>
                            <option value="relaxed" <?php echo $mood == 'relaxed' ? 'selected' : ''; ?>>Relaxed</option>
                            <option value="excited" <?php echo $mood == 'excited' ? 'selected' : ''; ?>>Excited</option>
                        </select>
                        
                        <label for="filter-date">Filter by Date:</label>
                        <input type="date" name="date" id="filter-date" 
                               value="<?php echo htmlspecialchars($date); ?>">
                        
                        <button type="submit">Apply Filters</button>
                    </div>
                </form>
            </div>
            
            <div class="entries-list">
                <?php if (empty($entries)): ?>
                    <p>No entries found. Start journaling!</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($entries as $entry): ?>
                            <li>
                                <a href="entry_details.php?id=<?php echo $entry['entry_id']; ?>">
                                    <h3><?php echo htmlspecialchars($entry['title']); ?></h3>
                                    <p class="entry-date"><?php echo date('F j, Y', strtotime($entry['created_at'])); ?></p>
                                    <p class="entry-preview"><?php echo htmlspecialchars(substr($entry['content'], 0, 150) . '...'); ?></p>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Mindful Journal. All rights reserved.</p>
    </footer>
</body>
</html>