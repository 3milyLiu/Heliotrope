<?php

require_once('../../../private/initialise.php');

require_secretary();

$volunteers_set = find_all_staff();

?>
<?php include(SHARED_PATH . "/header.php"); ?>

<?php $page_title = 'volunteers'; ?>

<title>Volunteers</title>

<div class="container" style="margin: 100px auto">

    <h1>Volunteers</h1>

    <div class="actions">
        <a class="btn btn-primary" href="<?php echo url_for('/staff/volunteers/new.php'); ?>">Create New Volunteer</a>
    </div>


    <div class="content">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>First</th>
                    <th>Last</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            
            <tbody>
                <?php while($volunteer=mysqli_fetch_assoc($volunteers_set)) { if(h($volunteer[ 'secretary'])==1 ) { continue; } ?>
                <tr>
                    <td>
                        <?php echo h($volunteer[ 'id']); ?>
                    </td>
                    <td>
                        <?php echo h($volunteer[ 'first_name']); ?>
                    </td>
                    <td>
                        <?php echo h($volunteer[ 'last_name']); ?>
                    </td>
                    <td>
                        <?php echo h($volunteer[ 'email']); ?>
                    </td>
                    <td>
                        <?php echo h($volunteer[ 'username']); ?>
                    </td>
                    <td class="float-right">
                        <a class="btn btn-outline-primary" href="<?php echo url_for('/staff/volunteers/show.php?id=' . h(u($volunteer['id']))); ?>">View</a>
                        <a class="btn btn-outline-primary" href="<?php echo url_for('/staff/volunteers/edit.php?id=' . h(u($volunteer['id']))); ?>">Edit</a>
                        <a class="btn btn-outline-danger" href="<?php echo url_for('/staff/volunteers/delete.php?id=' . h(u($volunteer['id']))); ?>">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php mysqli_free_result($volunteers_set); ?>

    </div>
</div>
<?php include(SHARED_PATH . "/footer.php");?>