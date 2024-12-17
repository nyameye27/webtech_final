<?php
require '../db/db.php';
$conn = connectDB();


class SystemConfiguration {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getSystemSettings() {
        $query = "SELECT * FROM system_config LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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