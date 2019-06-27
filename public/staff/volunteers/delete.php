<?php

require_once('../../../private/initialise.php');

require_secretary();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/volunteers/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
  $result = delete_volunteer($id);
  redirect_to(url_for('/staff/volunteers/index.php'));
} else {
  $volunteer = find_staff_by_id($id);
}

?>
<?php include(SHARED_PATH . "/header.php"); ?>
<?php $page_title = 'Delete Volunteer'; ?>

<title>Delete Volunteer</title>
  
        <div class="actions">
          <a class="btn btn-primary" href="<?php echo url_for('/staff/volunteers/index.php'); ?>">Back to List</a>
          <h1 class="text-center">Delete Volunteer</h1>
        </div>
        
<div class="container" style="margin: 100px auto">

<center>

     <blockquote class="blockquote text-center">
            <p class="mb-0">Are you sure you want to delete this volunteer:
                <?php echo h($volunteer['username']); ?>
            </p>
            <footer class="blockquote-footer"><cite title="Source Title"><strong>This action is not reversible</strong></cite>
            </footer>
        </blockquote>

    <form action="<?php echo url_for('/staff/volunteers/delete.php?id=' . h(u($volunteer['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" class="btn btn-danger" name="commit" value="Delete volunteer" />
      </div>
    </form>
    </center>
  </div>

</div>

<?php include(SHARED_PATH . "/footer.php");?>

