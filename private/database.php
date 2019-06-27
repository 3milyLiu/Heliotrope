<?php

// taken from lynda.com - PHP with mysql essential trainging 1 the basics

  require_once('db_credentials.php');
//  require_once('db_prod.php');  

  function db_connect() {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
//    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_NAME);
    confirm_db_connect();
    return $connection;
  }

  function db_disconnect($connection) {
    if(isset($connection)) {
      mysqli_close($connection);
    }
  }

  function confirm_db_connect() {
    if(mysqli_connect_errno()) {
      $msg = "Database connection failed: ";
      $msg .= mysqli_connect_error();
      $msg .= " (" . mysqli_connect_errno() . ")";
      exit($msg);
    }
  }

  function confirm_result_set($result_set) {
    if (!$result_set) {
    	exit("Database query failed.");
    }
  }
  
  function db_escape($connection, $string) {
    return mysqli_real_escape_string($connection, $string);
  }

?>

