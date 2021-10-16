<?php
session_start();
require_once ('/home/qtn3/Desktop/FamJam4/vendor/autoload.php');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('192.168.194.191', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('test queue', false, false, false, false);

$msg = new AMQPMessage('test here');
$channel->basic_publish($msg, '', 'test queue');

echo " [x] Sent test\n";


$channel->close();
$connection->close();


?>