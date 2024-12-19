<?php
// Ensure the db.php file is included only once
require_once '../../db/db.php';

class SystemConfiguration {
    private $conn;

    // Constructor that sets up the database connection
    public function __construct() {
        $this->conn = connectDB(); // Initialize the database connection
    }

    // Get system settings
    public function getSystemSettings() {
        $query = "SELECT * FROM system_config LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update system settings
    public function updateSystemSettings($site_name, $default_role, $maintenance_mode) {
        $query = "UPDATE system_config 
                  SET site_name = :site_name, 
                      default_role = :default_role, 
                      maintenance_mode = :maintenance_mode";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':site_name', $site_name);
        $stmt->bindParam(':default_role', $default_role);
        $stmt->bindParam(':maintenance_mode', $maintenance_mode);

        return $stmt->execute();
    }
}
?>