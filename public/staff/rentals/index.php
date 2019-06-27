<?php
require_once('../../../private/initialise.php');
?>

<?php

require_login();

$rentals_set = find_all_rentals();  
  
?>

<?php $page_title = 'Rentals'; ?>

<?php include(SHARED_PATH . "/header.php"); ?>

<title>Rentals</title>

<div class="container" style="margin: 100px auto">

    <h1>All Rentals</h1>

    <div class="actions">
        <a class="btn btn-primary" href="<?php echo url_for('/staff/rentals/new.php'); ?>">New Rental</a>
        <div class="float-right">
            <div class="btn-group mr-2">
                <a class="btn btn-primary" href="<?php echo url_for('/staff/rentals/current.php'); ?>">Current Rentals</a>
            </div>
            <div class="btn-group">
                <a class="btn btn-danger" href="<?php echo url_for('/staff/rentals/overdue.php'); ?>">Overdue Items</a>
            </div>
        </div>
    </div>

    <div class="content">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Game ID</th>
                    <th>Title</th>
                    <th>Date Rented</th>
                    <th>Date Due</th>
                    <th>Extensions</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

                <?php while($rental=mysqli_fetch_assoc($rentals_set)) { ?>

                <tr <?php if($rental[ 'returned']==1 ) echo 'class="table-dark"'; ?>>
                    <td>
                        <?php echo h($rental[ 'member_id']); ?>
                    </td>
                    <td>
                        <?php echo h($rental[ 'name']). " ".h($rental[ 'surname']); ?>
                    </td>
                    <td>
                        <?php echo h($rental[ 'game_id']); ?>
                    </td>
                    <td>
                        <?php echo h($rental[ 'title']); ?>
                    </td>
                    <td>
                        <?php echo h($rental[ 'date_rented']); ?>
                    </td>
                    <td>
                        <?php echo h($rental[ 'date_due']); ?>
                    </td>
                    <td>
                        <?php echo h($rental[ 'extensions']); ?>
                    </td>
                    <td class="text-center" width="100">
                        <!-- Check the status of this rental -->
                        <?php $status="pending" ; if(h($rental[ 'returned'])==1 ) { $status="returned" ; } else if(date( 'Y-m-d')> h($rental['date_due'])) { $status = "late"; } ?>
                        <!-- Disable button if returned and display appropriate badge -->
                        <a class="btn btn-outline-primary <?php if($status == " returned ") echo 'disabled'; ?>" href="<?php echo url_for('/staff/rentals/extend_or_return.php?rental_id='. h(u($rental['rental_id']))). '" '; ?>>Extend/Return</a>               
                <span class="badge badge-<?php if($status == "returned") echo 'success ">returned'; 
                else if($status == "late ") echo 'danger">late'; else echo 'primary">pending'; ?> </span>
                    </td>
                </tr>
            </tbody>
            <?php } ?>
        </table>

        <?php mysqli_free_result($rentals_set); ?>

    </div>

</div>
    
<?php include(SHARED_PATH . "/footer.php");?>


