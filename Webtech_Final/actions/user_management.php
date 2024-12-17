<?php
require '../db/db.php';
$conn = connectDB();


class UserManagement {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllUsers() {
        $query = "SELECT id, username, email, userrole FROM Users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser($name, $email, $role) {
        $query = "INSERT INTO Users (username, email, userrole) VALUES (:username, :email, :userrole)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':userrole', $userrole);

        return $stmt->execute();
    }

    public function updateUser($id, $username, $email, $userrole) {
        $query = "UPDATE Users SET username = :username, email = :email, userrole = :userrole WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':userrole', $userrole);

        return $stmt->execute();
    }

    public function deleteUser($id) {
        $query = "DELETE FROM Users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>