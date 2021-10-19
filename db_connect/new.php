<?php
$sql_host="sql1.njit.edu";
$sql_username="ej84";
$sql_password='yWcc5735?!';
$sql_database="ej84";
function connect_db() {
    global $sql_host, $sql_username, $sql_password, $sql_database;
    
    $conn=new mysqli($sql_host,$sql_username,$sql_password);
    #$conn=new mysqli_connect($sql_host,$sql_username,$sql_password, $sql_database);
    echo "Successfully Connected"."\n";
    if(mysqli_connect_error() != null) {
        
        return false;
    }
    //$conn -> select_db($sql_database);
    return $conn;
}

function connect_db_2() {
    
    global $sql_host, $sql_username, $sql_password, $sql_database;
    $conn=new mysqli_connect($sql_host,$sql_username,$sql_password, $sql_database);
    
    if(!$conn) {
        $msg = "could not conenct to database.<br/>";
        $msg .="Error Number: " . Mysqli_connect_errno();
        $msg .="Error: " . Mysqli_connect_error();
        return false;
    }
    return $conn;
}
?>