<?php

require_once('../../../private/initialise.php');

require_secretary();

if(is_post_request()) {
    
  $volunteer = [];
  $volunteer['first_name'] = $_POST['first_name'] ?? '';
  $volunteer['last_name'] = $_POST['last_name'] ?? '';
  $volunteer['email'] = $_POST['email'] ?? '';
  $volunteer['username'] = $_POST['username'] ?? '';
  $volunteer['password'] = $_POST['password'] ?? '';
  $volunteer['confirm_password'] = $_POST['confirm_password'] ?? '';

  $result = insert_staff($volunteer);
  
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'volunteer created.';
    redirect_to(url_for('/staff/volunteers/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $volunteer = [];
  $volunteer["first_name"] = '';
  $volunteer["last_name"] = '';
  $volunteer["email"] = '';
  $volunteer["username"] = '';
  $volunteer['password'] = '';
  $volunteer['confirm_password'] = '';
}

?>

<?php include(SHARED_PATH . "/header.php"); ?>  
<?php $page_title = 'New Volunteer'; ?>

<title>New Volunteer</title>

<div class="actions">
    <a class="btn btn-primary" href="<?php echo url_for('/staff/volunteers/index.php'); ?>">Back to List</a>
    <h1 class="text-center">New volunteer</h1>
</div>

<div class="container" style="margin: 100px auto">
    <div class="volunteer new">

        <center>
            <?php echo display_errors_as_table($errors); ?>

            <form action="<?php echo url_for('/staff/volunteers/new.php'); ?>" method="post">
                <dl>
                    <dt>First name</dt>
                    <dd>
                        <input type="text" name="first_name" value="<?php echo h($volunteer['first_name']); ?>" />
                    </dd>
                </dl>

                <dl>
                    <dt>Last name</dt>
                    <dd>
                        <input type="text" name="last_name" value="<?php echo h($volunteer['last_name']); ?>" />
                    </dd>
                </dl>

                <dl>
                    <dt>Username</dt>
                    <dd>
                        <input type="text" name="username" value="<?php echo h($volunteer['username']); ?>" />
                    </dd>
                </dl>

                <dl>
                    <dt>Email </dt>
                    <dd>
                        <input type="text" name="email" value="<?php echo h($volunteer['email']); ?>" />
                        <br />
                    </dd>
                </dl>

                <dl>
                    <dt>Password</dt>
                    <dd>
                        <input type="password" name="password" value="" />
                    </dd>
                </dl>

                <dl>
                    <dt>Confirm Password</dt>
                    <dd>
                        <input type="password" name="confirm_password" value="" />
                    </dd>
                </dl>
                <p>
                    Passwords should be at least 12 characters and include at least one uppercase letter, lowercase letter, number, and symbol.
                </p>
                <br />

                <div id="operations">
                    <input type="submit" class="btn btn-primary" value="Create volunteer" />
                </div>
            </form>
        </center>
    </div>

</div>

<?php include(SHARED_PATH . "/footer.php");?>