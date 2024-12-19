<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../../actions/user_management.php';
require '../../actions/analytics.php';
require '../../actions/system_configuration.php';
// Initialize classes
$userManagement = new UserManagement();
$analytics = new Analytics();
$systemConfig = new SystemConfiguration();

// Fetch data
$users = $userManagement->getAllUsers();
$userGrowth = $analytics->getUserGrowth();
$journalEntries = $analytics->getJournalEntriesOverTime();
$totalStats = $analytics->getTotalUsersAndEntries();
$config = $systemConfig->getSystemSettings();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'add_user':
                $userManagement->addUser($_POST['name'], $_POST['email'], $_POST['role']);
                break;
            case 'update_user':
                $userManagement->updateUser($_POST['id'], $_POST['name'], $_POST['email'], $_POST['role']);
                break;
            case 'delete_user':
                $userManagement->deleteUser($_POST['id']);
                break;
            case 'update_config':
                $systemConfig->updateSystemSettings(
                    $_POST['site-name'], 
                    $_POST['default-role'], 
                    $_POST['maintenance-mode']
                );
                break;
        }
        // Refresh data after action
        $users = $userManagement->getAllUsers();
        $config = $systemConfig->getSystemSettings();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindful Journal - Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>MyJournal Admin</h1>
            </div>
            <div class="user-info">
                <p>Welcome back, <strong>Admin</strong></p>
                <a href="../actions/logout.php" class="logout">Logout</a>
            </div>
        </nav>
    </header>

    <main>
        <aside class="sidebar">
            <ul>
                <li><a href="#user-management">User Management</a></li>
                <li><a href="#analytics-reporting">Analytics & Reporting</a></li>
                <li><a href="#system-configuration">System Configuration</a></li>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../view/about.html">About</a></li>
            </ul>
        </aside>

        <section class="content">
            <!-- User Management Section -->
            <div id="user-management" class="section">
                <h2>User Management</h2>
                <p>Total Users: <?= $totalStats['total_users'] ?></p>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <td>
                                <button class="button small" onclick="editUser(<?= $user['id'] ?>)">Edit</button>
                                <button class="button small red" onclick="deleteUser(<?= $user['id'] ?>)">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="button" onclick="showAddUserModal()">Add New User</button>
            </div>

            <!-- Analytics and Reporting Section -->
            <div id="analytics-reporting" class="section">
                <h2>Analytics & Reporting</h2>
                <p>Total Journal Entries: <?= $totalStats['total_entries'] ?></p>
                <div id="analytics-charts">
                    <div class="chart-container">
                        <h3>User Growth</h3>
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <h3>Journal Entries Over Time</h3>
                        <canvas id="entriesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- System Configuration Section -->
            <div id="system-configuration" class="section">
                <h2>System Configuration</h2>
                <form id="system-config-form" method="POST">
                    <input type="hidden" name="action" value="update_config">
                    <label for="site-name">Site Name:</label>
                    <input type="text" id="site-name" name="site-name" value="<?= htmlspecialchars($config['site_name']) ?>" required>

                    <label for="default-role">Default User Role:</label>
                    <select id="default-role" name="default-role">
                        <option value="user" <?= $config['default_role'] == 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= $config['default_role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>

                    <label for="maintenance-mode">Maintenance Mode:</label>
                    <select id="maintenance-mode" name="maintenance-mode">
                        <option value="off" <?= $config['maintenance_mode'] == 'off' ? 'selected' : '' ?>>Off</option>
                        <option value="on" <?= $config['maintenance_mode'] == 'on' ? 'selected' : '' ?>>On</option>
                    </select>

                    <button type="submit" class="button">Save Changes</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Mindful Journal. All rights reserved.</p>
    </footer>

    <script>
        // Charts for User Growth and Journal Entries
        document.addEventListener('DOMContentLoaded', function() {
            // User Growth Chart
            var userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
            new Chart(userGrowthCtx, {
                type: 'line',
                data: {
                    labels: [<?= "'".implode("','", array_column($userGrowth, 'month'))."'" ?>],
                    datasets: [{
                        label: 'User Count',
                        data: [<?= implode(',', array_column($userGrowth, 'user_count')) ?>],
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                }
            });

            // Journal Entries Chart
            var entriesCtx = document.getElementById('entriesChart').getContext('2d');
            new Chart(entriesCtx, {
                type: 'bar',
                data: {
                    labels: [<?= "'".implode("','", array_column($journalEntries, 'month'))."'" ?>],
                    datasets: [{
                        label: 'Journal Entries',
                        data: [<?= implode(',', array_column($journalEntries, 'entry_count')) ?>],
                        backgroundColor: 'rgba(54, 162, 235, 0.5)'
                    }]
                }
            });
        });

        // User Management Functions (to be implemented)
        function showAddUserModal() {
            // Implement modal for adding a new user
            alert('Add User Modal - To be implemented');
        }

        function editUser(id) {
            // Implement edit user functionality
            alert('Edit User - To be implemented for user ID: ' + id);
        }

        function deleteUser(id) {
            if(confirm('Are you sure you want to delete this user?')) {
                // Implement delete user functionality
                alert('Delete User - To be implemented for user ID: ' + id);
            }
        }
    </script>
</body>
</html>