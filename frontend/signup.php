<?php
session_start();
require_once ('/home/qtn3/Desktop/FamJam4/vendor/autoload.php');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


if(isset($_POST['submit'])){
  $connection = new AMQPStreamConnection('192.168.194.150', 5672, 'dp75', '1234', 'dp75');
  $channel = $connection->channel();


  $channel->queue_declare('username queue', false, false, false, false);
  $username= !empty($_POST['sign_up_name'])?trim($_POST['sign_up_name']):null;
  $password= !empty($_POST['sign_up_pass'])?trim($_POST['sign_up_pass']):null;
  $passwordHashed= password_hash($password, PASSWORD_BCRYPT);
  $email= !empty($_POST['sign_up_email'])?trim($_POST['sign_up_email']):null;

  $credential = array("username"=>$username, "password"=>$passwordHashed, "email"=>$email);
  
  $msg = new AMQPMessage(json_encode($credential));
  $channel->basic_publish($msg, '', 'username queue');

  include 'registerSignalReceive.php';
  echo "works";
  $signal=$_SESSION['signalSignup'];

  if($signal == 'true'){
    header('location:homepage.html');
  }
  else{
    echo "Account existed!";
    header('location:signup.php');
  }

  $channel->close();
  $connection->close();
}




?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="signup.css">
    <title>Sign up</title>
  </head>
  <body>
    <div class="main">
        <p class="sign" align="center">Sign up</p>
        <form class="form1" action="signup.php" method="post">
          <input class="un " type="text" align="center" name="sign_up_name" placeholder="Username">
          <input class="pass" type="password" align="center" name="sign_up_pass" placeholder="Password">
          <input class="pass" type="email" align="center" name="sign_up_email" placeholder="Email">
          <input class="submit" type="submit" name="submit" value="Sign up">
          <br>
          <br>
          <a class="submit" align="center" href="login.php">Sign in</a>
        </form>                
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>