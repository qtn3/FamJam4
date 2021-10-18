<?php
session_start();
require_once ('/home/qtn3/Desktop/FamJam4/vendor/autoload.php');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('192.168.194.150', 5672, 'dp75', '1234','dp75');
$channel = $connection->channel();

$channel->queue_declare('test queue', false, false, false, false);
$countAlpha = array("A"=>"ONE", "B"=>"TWO");
$msg = new AMQPMessage(json_encode($countAlpha));
$channel->basic_publish($msg, '', 'test queue');

echo " [x] Sent test\n";


$channel->close();
$connection->close();


?>