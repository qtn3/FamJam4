<?php
namespace Acme\AmqpWrapper;
session_start();
require_once ('/home/qtn3/Desktop/FamJam4/vendor/autoload.php');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('192.168.194.150', 5672, 'dp75', '1234','dp75');
$channel = $connection->channel();

$channel->queue_declare('test queue', false, false, false, false);

echo "Waiting for the message...";

$callback = function($msg){
    $cread=json_decode($msg->body,true);
    print_r($cread);
    echo 'This is cred A ', $cread['A'], "\n";
    echo 'This is cred B ', $cread['B'], "\n";
};


$channel->basic_consume('test queue','',false,true,false,false,$callback);
while($channel->is_consuming()){
    $channel->wait();
}



$channel->close();
$connection->close();

?>