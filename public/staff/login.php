<?php 
require_once('../../private/initialise.php');

$errors = [];
$username = '';
$password = '';

if(is_post_request()){
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if(is_blank($username)){
    $errors[] = "Username cannot be blank.";
  }
  
  if(is_blank($password)){
    $errors[] = "Password cannot be blank.";
  }

  if(empty($errors)) {
      
    $login_failure = "Log in was unsuccessful.";
    // find the staff member trying to login
    $user = find_staff_by_username($username);
    
    if($user) { 
        if(password_verify($password, $user['hashed_password'])) {

        // correct password
        if($user['secretary'] == 1) {
            log_in_secretary($user);
        } else { // volunteer
            log_in_volunteer($user);
        }

        redirect_to(url_for('/staff/Staff_Index.php'));
        } 
        else{
        // wrong password
        $errors[] = $login_failure;
        }
    } 
    else{
      // no username found
      $errors[] = $login_failure;
    }
  }
}

?>

<?php include(SHARED_PATH . "/header.php"); ?>

<title>Login</title>
  

<div class="container" style="margin:150px auto;">

    <center>
        <?php echo display_errors_as_table($errors); ?>
        <h1>Log in</h1>
        <form action="login.php" method="post">
            Username:
            <br>
            <input type="text" name="username" value="<?php echo h($username); ?>" />
            <br> Password:
            <br>
            <input type="password" name="password" value="" />
            <br>
            <input type="submit" class="btn btn-primary" value="Login" />
            
        </form>

    </center>
</div>



<?php include(SHARED_PATH . "/footer.php");?>

