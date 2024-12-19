<?php
require_once '../../db/db.php';

class UserManagement {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct() {
        $this->conn = connectDB(); // Initialize the connection using the connectDB() function
    }

    // Get all users
    public function getAllUsers() {
        $query = "SELECT id, username, email, userrole FROM Users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new user
    public function addUser($username, $email, $userrole) {
        $query = "INSERT INTO Users (username, email, userrole) VALUES (:username, :email, :userrole)";
        $stmt = $this->conn->prepare($query);
        
        // Bind the parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':userrole', $userrole);

        return $stmt->execute();
    }

    // Update an existing user
    public function updateUser($id, $username, $email, $userrole) {
        $query = "UPDATE Users SET username = :username, email = :email, userrole = :userrole WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        // Bind the parameters
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':userrole', $userrole);

        return $stmt->execute();
    }

    // Delete a user
    public function deleteUser($id) {
        $query = "DELETE FROM Users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>