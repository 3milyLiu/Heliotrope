<?php require_once('../../../private/initialise.php'); ?>

<?php 

require_login();
    
$allMembers = get_all_banned_members();

?>

<?php
  if(!isset($page_title)) { $page_title = 'Staff Area - View Banned Members'; }
?>
<?php include(SHARED_PATH . "/header.php"); ?>

<title>Banned Members</title>


<div class="container" style="margin: 100px auto">

    <h1>Banned Members</h1>
    
    <div class="actions">
        <a class="btn btn-primary" href="<?php echo url_for('/staff/members/index.php'); ?>">All Members</a>
    </div>

        <?php if (!empty(mysqli_num_rows($allMembers))) { ?>
        <div class="content">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Surname</th>
                        <th scope="col">Pending Fines</th>
                        <th scope="col">Violations</th>
                        <th scope="col">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($member=mysqli_fetch_assoc($allMembers)) { ?>
                    <tr>
                        <td>
                            <?php echo h($member[ 'member_id']); ?>
                        </td>
                        <td>
                            <?php echo h($member[ 'name']); ?>
                        </td>
                        <td>
                            <?php echo h($member[ 'surname']); ?>
                        </td>
                        <td>
                            <?php echo h($member[ 'pending_fine']); ?>
                        </td>
                        <td>
                            <?php echo h($member[ 'violations']); ?>
                        </td>
                        <td>
                            <a class="btn btn-outline-primary" href="<?php echo url_for('/staff/members/edit.php?member_id=' . h(u($member['member_id']))); ?>">Edit</a>
                            <a class="btn btn-outline-danger" href="<?php echo url_for('/staff/members/delete.php?member_id=' . h(u($member['member_id']))); ?>">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } else { echo "<h1>There are currently no banned members.</h1>"; }?>
    
</div>

  <?php include(SHARED_PATH . "/footer.php");?>