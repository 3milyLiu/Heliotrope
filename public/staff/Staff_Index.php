<?php require_once('../../private/initialise.php'); ?>
  
<?php require_login(); ?>
  
<?php include(SHARED_PATH . "/header.php"); ?>

<title>Staff Dashboard</title>

    <div class="container" style="font-size : 30px;">
    <center>
        <div class="row" style="margin-top:100px;">
            <div class="col col-lg-12" style="font-size : 30px;">Staff Tasks</div>
            
            <div class="col col-lg-12">                <!-- Space between Buttons Displayed -->
                <p style="margin-bottom : 30px;"> </p> <!-- Space between Buttons Displayed -->
            </div>                                     <!-- Space between Buttons Displayed -->
            
            <div class="col col-lg-12">

            <a href="<?php echo url_for('/staff/rentals/index.php'); ?>" class="btn btn-danger" style="width:220px">Rentals</button></a>
            </div>
            
            <div class="col col-lg-12">                 <!-- Space between Buttons Displayed -->
                <p style="margin-bottom : 30px;"> </p>  <!-- Space between Buttons Displayed -->
            </div>                                      <!-- Space between Buttons Displayed -->
            
            <div class="col col-lg-6">
            <a class="btn btn-warning" href ="<?php echo url_for('/staff/rentals/overdue.php'); ?>" style="width:220px">Overdue Rentals</a>
            </div>
            <div class="col col-lg-6">
            <a class="btn btn-warning" href="<?php echo url_for('/staff/members/outstandingfees.php'); ?>" style="width:220px">Outstanding Fees</a>

            </div>
            <div class="col col-lg-12">
            <a class="btn btn-danger" href = "<?php echo url_for('/staff/members/banned.php'); ?>" style="width:220px">Banned Members</a>
            </div>
             <div class="col col-lg-6">
             <a class="btn btn-info" href="<?php echo url_for('/staff/games/index.php'); ?>" style="width:220px">Manage Games</a>
            </div>
             <div class="col col-lg-6">
             <a href="<?php echo url_for('/staff/members/index.php'); ?>" class="btn btn-info" style="width:220px">Manage Members</a>
            </div>
            
            <div class="col col-lg-12">                 <!-- Space between Buttons Displayed -->
                <p style="margin-bottom : 30px;"> </p>  <!-- Space between Buttons Displayed -->
            </div>                                      <!-- Space between Buttons Displayed -->

            <!-- These functions are only available to the secretary -->
            <?php if(is_logged_in_as_secretary()) { ?>
            <div class="col col-lg-6">
            <a href="<?php echo url_for('/staff/secretary/edit_rules.php'); ?>" class="btn btn-info" style="width:220px">Change Rules</a>
            </div>
                       
            <div class="col col-lg-6">
            <a href="<?php echo url_for('/staff/volunteers/index.php'); ?>" class="btn btn-info" style="width:220px">Manage Volunteers</a>
            </div>
            
            <div class="col col-lg-12">
            <a href="<?php echo url_for('/staff/secretary/new_secretary.php'); ?>" class="btn btn-warning" style="width:220px">Change secretary</a>
            </div>
            <?php } ?>
            <p style="margin-bottom : 300px;"> </p>
        </div>
        <center>
    </div>


<?php include(SHARED_PATH . "/footer.php");?>