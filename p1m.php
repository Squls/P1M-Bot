<?php

require_once('twitteroauth.php');

//db connection
$host = '127.0.0.1';
$database = 'dbname';
$user = 'user';
$password = 'password';

$db = 'host=' . $host . ' dbname=' . $database . ' user=' . $user . ' password=' . $password;

  $conn = pg_connect ($db);
  if (!$conn)
  {
  	die('Error: Could not connect: ' . pg_last_error());
  }

// Set keys
$consumerKey = '';
$consumerSecret = '';
$accessToken = '';
$accessTokenSecret = '';

// Create Twitter object
$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

//query db 
$query = "SELECT table_name FROM numbers WHERE name='column_name'";
$result = pg_query($query);
$row = pg_fetch_row($result);
$c_row = current($row);
//truncated here but you can get Pi to a million places from http://www.piday.org/million/ 
$pinum = '3.14159...';
$digit = $pinum[$c_row];
$count = $c_row + 1;
$data = "UPDATE number SET digits=$count WHERE name='column_name'";
$update = pg_query($data);

pg_close($db);

$position = substr($c_row, -1);
$tens = substr($c_row, -2, 1);

//adds suffix to number
if ($position == 1 && $tens != 1) {
  $ender = 'st';
} else if ($position == 2 && $tens != 1){
  $ender = 'nd';
} else if ($position == 3 && $tens != 1){
  $ender = 'rd';
} else {
  $ender = 'th';
}

// Set status message
$tweetMessage = 'The ' . $c_row . $ender . ' position of Pi is '. $digit . '.';

// Check for 140 characters
if(strlen($tweetMessage) <= 140) {
    // Post the status message
    $tweet->post('statuses/update', array('status' => $tweetMessage));
};

?>
