<?php require_once('../../../private/initialise.php'); ?>

<?php 

require_login();
    
$allMembers = get_all_members();

?>

<?php
  if(!isset($page_title)) { $page_title = 'Staff Area - View Members'; }
?>

  
<?php include(SHARED_PATH . "/header.php"); ?>

<title>Members</title>

<div class="container" style="margin: 100px auto">
      
    <h1>Members</h1>

    <div class="actions">
                <a class="btn btn-primary" href="<?php echo url_for('/staff/members/add.php'); ?>">Add member</a>
            <div class="float-right">
                <div class="btn-group mr-2">
                    <a class="btn btn-danger" href="<?php echo url_for('/staff/members/banned.php'); ?>">View Banned Only</a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo url_for('/staff/members/outstandingfees.php'); ?>">View Members With Fees</a>
                </div>
            </div>
    </div>
  
    <div class="content">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Surname</th>
                    <th scope="col">Pending Fines</th>
                    <th scope="col">Ban Status</th>
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
                        <?php echo h($member[ 'ban_status'])==1 ? '<h4><span class="badge badge-danger">Banned</h4></span>' : '<h4><span class="badge badge-success">None</h4></span>'; ?>
                    </td>
                    <td>
                        <?php echo h($member[ 'violations']); ?>
                    </td>
                    <td >
                        <a class="btn btn-outline-primary" href="<?php echo url_for('/staff/members/edit.php?member_id=' . h(u($member['member_id']))); ?>">Edit</a>
                        <a class="btn btn-outline-danger" href="<?php echo url_for('/staff/members/delete.php?member_id=' . h(u($member['member_id']))); ?>">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <?php mysqli_free_result($allMembers); ?>
        
    </div>
</div>


<?php include(SHARED_PATH . "/footer.php");?>
