<?php
namespace Acme\AmqpWrapper;
session_start();
require '/home/qtn3/Desktop/FamJam4/db_connect/new.php';
require_once ('/home/qtn3/Desktop/FamJam4/vendor/autoload.php');
$conn = connect_db();
$conn_string = "mysql:host=$sql_host;dbname=$sqll_database;charset=utf8mb4";
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('192.168.194.150', 5672, 'dp75', '1234','dp75');
$channel = $connection->channel();

$channel->queue_declare('username queue', false, false, false, false);


$callback = function($msg){
    $cread=json_decode($msg->body,true);
    if(count($cread) == 2){
        echo count($cread);
        $sql            = 'Select username From account Where username = dp75';
        $sql            = $conn->query($sql);
        $sql            = $sql->fetch_assoc();
        if ($sql) {
            $signal='true';
            $channel->queue_declare('signal queue', false, false, false, false);
            $credential = array("username"=>$cread['username'], "password"=>$cread['password'], "signal"=>$signal);
            $msg = new AMQPMessage(json_encode($credential));
            $channel->basic_publish($msg, '', 'signal queue');
            exit();
        }else{
            $signal='false';
            $channel->queue_declare('signal queue', false, false, false, false);
            $credential = array("username"=>$cread['username'], "password"=>$cread['password'], "signal"=>$signal);
            $msg = new AMQPMessage(json_encode($credential));
            $channel->basic_publish($msg, '', 'signal queue');
            exit();
        }
    }else{
	$db = new PDO($conn_string, $username, $password);
        $sql = "INSERT INTO account (username, password, email) VALUES ('A', 'B', 'C')";
        if ($db->query($sql)){
        
            $signal='true';
            $channel->queue_declare('signal queue', false, false, false, false);
            $credential = array("username"=>$cread['username'], "password"=>$cread['password'], "email"=>$cread['email'], "signal"=>$signal);
            $msg = new AMQPMessage(json_encode($credential));
            $channel->basic_publish($msg, '', 'signal queue');
            exit();
        }
        // }else{
        //     $signal='false';
        //     $channel->queue_declare('signal queue', false, false, false, false);
        //     $credential = array("username"=>"A", "password"=>"B", "email"=>"C", "signal"=>$signal);
        //     $msg = new AMQPMessage(json_encode($credential));
        //     $channel->basic_publish($msg, '', 'signal queue');
        //     exit();
        // }
    }
};


$channel->basic_consume('username queue','',false,true,false,false,$callback);
while($channel->is_consuming()){
    $channel->wait();
}

$channel->close();
$connection->close();

?>
