<?php
require_once('../../../private/initialise.php');

require_login();

if(!isset($_GET['member_id'])) {
  redirect_to(url_for('/staff/members/index.php'));
}

$id = $_GET['member_id'];


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $member = [];
    
    $member['member_id'] = $id;
    $member['name'] = $_POST['name'] ?? '';
    $member['surname'] = $_POST['surname'] ?? '';
    $member['ban_status'] = $_POST['ban_status'] ?? '';
    $result = update_member($member);
    if($result === true) {
        redirect_to(url_for('/staff/members/index.php?member_id=' . $id));
    } else {
        $errors = $result;
    }
      
  } else { // display the blank form
  
    $member = find_member_by_id($id); 

}
?>

<?php
  if(!isset($page_title)) { $page_title = 'Staff Area - Edit Member'; }
?>
<?php $page_title = 'Edit Member'; ?>

  
<?php include(SHARED_PATH . "/header.php"); ?>


<title>Edit Member</title>


<div class="actions">
    <a class="btn btn-primary" href="<?php echo url_for('/staff/members/index.php'); ?>"> Back to Members List</a>
    <h1 class="text-center">Edit Member</h1>
</div>
<div class="container" style="margin: 100px auto">
    <center>

        <?php if ($_SERVER[ 'REQUEST_METHOD']=='POST' ) { echo display_errors_as_table($errors); } ?>
        <form action="<?php echo url_for('/staff/members/edit.php?member_id='. h(u($id))); ?>" method="post">
            <p>
                <label for="name">First Name:</label>
                <input type="text" name="name" id="name" value="<?php echo $member['name']; ?>">
            </p>
            <p>
                <label for="surname">Last Name:</label>
                <input type="text" name="surname" id="surname" value="<?php echo $member['surname']; ?>">
            </p>
            <p>
                <label for="ban_status">Banned:</label>
                <input type="hidden" name="ban_status" value="0" />
                <input type="checkbox" name="ban_status" id="ban_status" value="1" <?php if($member[ 'ban_status']=="1" ) { echo " checked"; } ?> />
            </p>
            <p>
                <input type="submit" class="btn btn-primary" value="Confirm">
            </p>

        </form>
    </center>
</div>

<?php include(SHARED_PATH . "/footer.php");?>