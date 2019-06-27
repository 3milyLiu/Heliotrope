<?php

require_once('../../../private/initialise.php');


require_login();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $rental = [];
    $rental['member_id'] = $_POST['member_id'] ?? '';
    $rental['game_id'] = $_POST['game_id'] ?? '';
    $rental['date_rented'] = date('Y-m-d');
    $rental['extensions'] = 0;
    $rental['returned'] = 0;
    
    $result = insert_rental($rental);
    if($result === true) {
        $new_id = mysqli_insert_id($db);
        redirect_to(url_for('/staff/rentals/index.php'));
    } else {
        $errors = $result;
    }
      
  } else { // display the blank form
    
    $rental = [];
    $rental['member_id'];
    $rental['game_id'];
}

?>

<?php
  if(!isset($page_title)) { $page_title = 'Staff Area'; }
?>

<?php $page_title = 'New Rental'; ?>


<?php include(SHARED_PATH . "/header.php"); ?>

   <title>New Rental</title>


<div id="content">
    <div class="actions">
        <a class="btn btn-primary" href="<?php echo url_for('/staff/rentals/index.php'); ?>"> Back to Rentals List</a>
        <h1 class="text-center">Add Rental</h1>
    </div>

    <div class="container" style="margin: 100px auto">
        <center>

            <?php echo display_errors_as_table($errors); ?>

            <form action="<?php echo url_for('/staff/rentals/new.php'); ?>" method="post">

                <dl>
                    <dt>Member ID</dt>
                    <dd>
                        <input type="text" maxlength="7" name="member_id" value="<?php echo $rental['member_id']; ?>" />
                    </dd>
                </dl>
                <dl>
                    <dt>Game ID</dt>
                    <dd>
                        <input type="text" name="game_id" value="<?php echo $rental['game_id']; ?>" />
                    </dd>
                </dl>

                <div id="operations">
                    <input type="submit" class="btn btn-primary" value="Record rental">
                </div>
            </form>
        </center>
    </div>

</div>

<?php include(SHARED_PATH . "/footer.php");?>


