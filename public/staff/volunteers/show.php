<?php

require_once('../../../private/initialise.php');

require_secretary();

$id = $_GET['id'] ?? '1'; // PHP > 7.0
$volunteer = find_staff_by_id($id);

?>

<?php include(SHARED_PATH . "/header.php"); ?>
  
<?php $page_title = 'Show volunteer'; ?>

<title>Show Volunteer</title>


<div class="actions">
    <a class="btn btn-primary" href="<?php echo url_for('/staff/volunteers/index.php'); ?>">Back to List</a>
    <h1 class="text-center">Volunteer: <?php echo h($volunteer['username']); ?></h1>
</div>



<div class="container" style="margin: 100px auto">
    <div class="volunteer show">
        <center>

            <div class="attributes">
                <dl>
                    <dt>First Name:</dt>
                    <dd>
                        <?php echo h($volunteer[ 'first_name']); ?>
                    </dd>
                </dl>
                <dl>
                    <dt>Last Name:</dt>
                    <dd>
                        <?php echo h($volunteer[ 'last_name']); ?>
                    </dd>
                </dl>
                <dl>
                    <dt>Email:</dt>
                    <dd>
                        <?php echo h($volunteer[ 'email']); ?>
                    </dd>
                </dl>
                <dl>
                    <dt>Username:</dt>
                    <dd>
                        <?php echo h($volunteer[ 'username']); ?>
                    </dd>
                </dl>
            </div>
        </center>
    </div>
</div>

<?php include(SHARED_PATH . "/footer.php");?>