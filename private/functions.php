<?php

// functions that will be reused throughout the site go here

function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

function u($string="") {
  return urlencode($string);
}

function raw_u($string="") {
  return rawurlencode($string);
}

function h($string="") {
  return htmlspecialchars($string);
}

function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

function display_errors($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<div class=\"errors\">";
    $output .= "Please fix the following errors:";
    $output .= "<ul>";
    foreach($errors as $error) {
      $output .= "<li>" . h($error) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}

function display_errors_as_table($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<div class=\"container\">";
    $output .= "Please fix the following errors:";
    $output .= "<ul class=\"list-group\">";
    foreach($errors as $error) {
      $output .= "<li class=\"list-group-item list-group-item-danger\">" . h($error) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";
    $output .= "</br>";
  }
  return $output;
}

function is_post_request(){
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

  
function redirect($location){
    header("location: " . $location);
    exit;
}

function get_and_clear_session_message() {
  if(isset($_SESSION['message']) && $_SESSION['message'] != '') {
    $msg = $_SESSION['message'];
    unset($_SESSION['message']);
    return $msg;
  }
}

function display_session_message() {
  $msg = get_and_clear_session_message();
  if(!is_blank($msg)) {
    return '<div id="message">' . h($msg) . '</div>';
  }
}

?>