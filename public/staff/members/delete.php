<?php

require_once('../../../private/initialise.php');

require_login();

if(!isset($_GET['member_id'])) {
  redirect_to(url_for('/staff/members/index.php'));
}
$id = $_GET['member_id'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  $result = delete_member($id);
  redirect_to(url_for('/staff/members/index.php'));

} else {
  $member = find_member_by_id($id);
}

?>

<?php $page_title = 'Delete Member'; ?>

<?php include(SHARED_PATH . "/header.php"); ?>

<title>Delete Member</title>


<div class="actions">
    <a class="btn btn-primary" href="<?php echo url_for('/staff/members/index.php'); ?>"> Back to Members List</a>
    <h1 class="text-center">Delete Member</h1>
</div>

<div class="container" style="margin: 100px auto">
    <center>
        <blockquote class="blockquote text-center">
            <p class="mb-0">Are you sure you wish to delete the member:
                <?php echo h($member[ 'name']); ?>
                <?php echo h($member[ 'surname']); ?>
            </p>
            <footer class="blockquote-footer"><cite title="Source Title"><strong>This action is not reversible</strong></cite>
            </footer>
        </blockquote>
        <form action="<?php echo url_for('/staff/members/delete.php?member_id=' . h(u($member['member_id']))); ?>" method="post">
            <input type="submit" class="btn btn-danger" name="commit" value="Delete" />
        </form>
    </center>
</div>

<?php include(SHARED_PATH . "/footer.php");?>