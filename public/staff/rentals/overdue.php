<?php
require_once('../../../private/initialise.php');
?>

<?php

require_login();

$rentals_set = find_all_overdue_rentals();    
  
?>

<?php $page_title = 'Overdue rentals'; ?>

<?php include(SHARED_PATH . "/header.php"); ?>

<title>Gaming Society</title>

<div class="container" style="margin: 100px auto">

    <h1>Overdue Items</h1>

    <div class="actions">
        <a class="btn btn-primary" href="<?php echo url_for('/staff/rentals/index.php'); ?>">Back to Rentals</a>
    </div>

    <div class="content">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Member ID</th>
                    <th>Name</th>
                    <th>Game ID</th>
                    <th>Title</th>
                    <th>Date Rented</th>
                    <th>Date Due</th>
                    <th>Extensions</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody id="rental list">

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
                        <a class="btn btn-outline-primary" href="<?php echo url_for('/staff/rentals/extend_or_return.php?rental_id='. h(u($rental['rental_id']))). '" '; ?>>Return</a>               
                <span class="badge badge-danger">late</td>
           
        	</tbody>
          <?php } ?>
      	</table>
      	
        <?php mysqli_free_result($rentals_set); ?>
        
      </div>
</div>
    
<?php include(SHARED_PATH . "/footer.php");?>