<?php
    $sql_host="sql1.njit.edu";
    $sql_username="ej84";
    $sql_password='yWcc5735?!';
    $sql_database="ej84";
    
    try{
        $conn = new PDO("mysql:host=$sql_host;dbname=$sql_database;$sql_username;$sql_password");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXEPTION);
        echo "Connected successfully";
        echo "</br>";
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
?>