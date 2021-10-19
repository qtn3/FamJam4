<?php
namespace Acme\AmqpWrapper;
session_start();
require '/home/qtn3/Desktop/FamJam4/db_connect/new.php';
require_once ('/home/qtn3/Desktop/FamJam4/vendor/autoload.php');
$conn = connect_db();

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('192.168.194.150', 5672, 'dp75', '1234','dp75');
$channel = $connection->channel();

$channel->queue_declare('username queue', false, false, false, false);

$callback = function($msg){
    $cread=json_decode($msg->body,true);
    // $_SESSION['signalSignup'] = $cred['signal'];
    if(count($cred == 2)){
        $sql            = 'Select username From table Where username = $cread["username"]';
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
        $sql = 'Insert Into table (username, email, password) VALUES ("$cread["username"]", "$cread["password"]", "$cread["email"]")';
        $sql = $conn->query($sql);
        if ($sql) {
            $signal='true';
            $channel->queue_declare('signal queue', false, false, false, false);
            $credential = array("username"=>$cread['username'], "password"=>$cread['password'], "email"=>$cread['email'], "signal"=>$signal);
            $msg = new AMQPMessage(json_encode($credential));
            $channel->basic_publish($msg, '', 'signal queue');
            exit();
        }else{
            $signal='false';
            $channel->queue_declare('signal queue', false, false, false, false);
            $credential = array("username"=>$cread['username'], "password"=>$cread['password'], "email"=>$cread['email'], "signal"=>$signal);
            $msg = new AMQPMessage(json_encode($credential));
            $channel->basic_publish($msg, '', 'signal queue');
            exit();
        }
    }
};


$channel->basic_consume('username queue','',false,true,false,false,$callback);
while($channel->is_consuming()){
    $channel->wait();
}

$channel->close();
$connection->close();

?>