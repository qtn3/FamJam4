<?php
    $sql_host="";
    $sql_username="";
    $sql_password='';
    $sql_database="";
    
    try{
        $conn = new PDO("mysql:host=$sql_host;dbname=$sql_databse;$sql_username;$sql_password");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXEPTION);
        echo "Connected successfully";
        echo "</br>";
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
?>