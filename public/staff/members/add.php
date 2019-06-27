<?php

require_once('../../../private/initialise.php');

require_login();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member = [];
    $member['name'] = $_POST['name'] ?? '';
    $member['surname'] = $_POST['surname'] ?? '';
    $member['pending_fine'] = 0.0;
    $member['ban_status'] = 0;
    $member['violations'] = 0;
    $result = insert_member($member);
    if($result === true) {
        $new_id = mysqli_insert_id($db);
        redirect_to(url_for('/staff/members/index.php?member_id=' . $new_id));
    } else {
        $errors = $result;
    }
      
  } else { // display the blank form
    
    $member = [];
    $member["name"] = '';
    $member["surname"] = '';
    
}

?>

<?php
  if(!isset($page_title)) { $page_title = 'Staff Area - Members'; }
?>
<?php $page_title = 'Add Member'; ?>

<?php include(SHARED_PATH . "/header.php"); ?>

<title>Add Member</title>

<div class="actions">
    <a class="btn btn-primary" href="<?php echo url_for('/staff/members/index.php'); ?>"> Back to Members List</a>
    <h1 class="text-center">Add Member</h1>
</div>

<div class="container" style="margin: 100px auto">

    <center>


        <?php if ($_SERVER['REQUEST_METHOD']=='POST') { echo display_errors_as_table($errors); } ?>
        <form action="<?php echo url_for('/staff/members/add.php'); ?>" method="post">
            <p>
                <label for="firstName">First Name:</label>
                <input type="text" name="name" id="name">
            </p>
            <p>
                <label for="lastName">Last Name:</label>
                <input type="text" name="surname" id="surname">
            </p>
            <p>
                <input type="submit" class="btn btn-primary" value="Add Member">
            </p>

        </form>

    </center>
</div>
    
<?php include(SHARED_PATH . "/footer.php");?>
