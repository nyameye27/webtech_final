<?php


function connectDB(){
    $servername='localhost';
    $username='nyameye.akuamoah';
    $password='wassce2022';
    $dbname = 'webtech_fall2024_nyameye_akuamoah';
    
    $conn = mysqli_connect($servername,$username,$password,$dbname);

    if(!$conn){
        die("Connection failed" . mysqli_connect_error());
    }else{
        //do nothing
        //echo "Connection successful";
    }
    return $conn;
}

// Define the getDatabaseConnection function which returns the PDO instance
function getDatabaseConnection() {
    return connectDB();
}
?>