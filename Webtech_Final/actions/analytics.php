<?php
require_once '../../db/db.php';
$conn = connectDB(); // Use the connectDB() function to establish the connection


class Analytics {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct() {
        $this->conn = $conn; // Use the already established connection
    }

    // Get user growth over time
    public function getUserGrowth() {
        $query = "SELECT 
                    DATE_FORMAT(created_at, '%M %Y') as month, 
                    COUNT(*) as user_count 
                  FROM Users
                  GROUP BY month 
                  ORDER BY created_at";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get journal entries over time
    public function getJournalEntriesOverTime() {
        $query = "SELECT 
                    DATE_FORMAT(created_at, '%M %Y') as month, 
                    COUNT(*) as entry_count 
                  FROM Entries 
                  GROUP BY month 
                  ORDER BY created_at";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get total number of users and entries
    public function getTotalUsersAndEntries() {
        $users_query = "SELECT COUNT(*) as total_users FROM Users";
        $entries_query = "SELECT COUNT(*) as total_entries FROM Entries";

        $users_stmt = $this->conn->prepare($users_query);
        $entries_stmt = $this->conn->prepare($entries_query);

        $users_stmt->execute();
        $entries_stmt->execute();

        return [
            'total_users' => $users_stmt->fetchColumn(),
            'total_entries' => $entries_stmt->fetchColumn()
        ];
    }
}
?>