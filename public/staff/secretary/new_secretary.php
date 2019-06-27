<?php

require_once('../../../private/initialise.php');

require_secretary();

if(!isset($_SESSION['staff_id'])) {
  redirect_to(url_for('/staff/Staff_Index.php'));
}
$id = $_SESSION['staff_id'];

if(is_post_request()) {
  $secretary = [];
  $secretary['id'] = $id;
  $secretary['first_name'] = $_POST['first_name'] ?? '';
  $secretary['last_name'] = $_POST['last_name'] ?? '';
  $secretary['email'] = $_POST['email'] ?? '';
  $secretary['username'] = $_POST['username'] ?? '';
  $secretary['password'] = $_POST['password'] ?? '';
  $secretary['confirm_password'] = $_POST['confirm_password'] ?? '';

  $result = update_staff($secretary);
  if($result === true) {
    $_SESSION['message'] = 'secretary updated.';
    redirect_to(url_for('/staff/Staff_Index.php?id=' . $id));
  } else {
    $errors = $result;
  }
} else {
  $secretary = find_staff_by_id($id);
}

?>

<?php $page_title = 'Edit Secretary'; ?>
<?php include(SHARED_PATH . "/header.php"); ?>

<title>Edit Secretary</title>

<div id="content">

    <div class="actions">
        <a class="btn btn-primary" href="<?php echo url_for('/staff/Staff_Index.php'); ?>">Back to Staff Home</a>
        <h1 class="text-center">Edit Secretary</h1>
    </div>

    <div class="container" style="margin: 100px auto">
        <center>


            <?php echo display_errors_as_table($errors); ?>

            <form action="<?php echo url_for('/staff/secretary/new_secretary.php?id=' . h(u($id))); ?>" method="post">
                <dl>
                    <dt>First name</dt>
                    <dd>
                        <input type="text" name="first_name" value="<?php echo h($secretary['first_name']); ?>" />
                    </dd>
                </dl>

                <dl>
                    <dt>Last name</dt>
                    <dd>
                        <input type="text" name="last_name" value="<?php echo h($secretary['last_name']); ?>" />
                    </dd>
                </dl>

                <dl>
                    <dt>Username</dt>
                    <dd>
                        <input type="text" name="username" value="<?php echo h($secretary['username']); ?>" />
                    </dd>
                </dl>

                <dl>
                    <dt>Email</dt>
                    <dd>
                        <input type="text" name="email" value="<?php echo h($secretary['email']); ?>" />
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
                    <input type="submit" class="btn btn-primary" value="Edit secretary" />
                </div>
            </form>
        </center>
    </div>
</div>


<?php include(SHARED_PATH . "/footer.php");?>



