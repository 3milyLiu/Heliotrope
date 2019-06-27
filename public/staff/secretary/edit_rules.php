<?php
require_once('../../../private/initialise.php');

require_secretary();


if(is_post_request()) {
    
  $rules = [];
  $rules['rental_length'] = $_POST['rental_length'] ?? '';
  $rules['max_rentals'] = $_POST['max_rentals'] ?? '';
  $rules['ban_length'] = $_POST['ban_length'] ?? '';
  $rules['extension_length'] = $_POST['extension_length'] ?? '';
  $rules['max_extensions'] = $_POST['max_extensions'] ?? '';
  $rules['max_violations'] = $_POST['max_violations'] ?? '';
  

  
  $result = update_rules($rules);
  
  if($result === true) {
    redirect_to(url_for('/staff/Staff_Index.php'));
  } else {
    $errors = $result;
  }
  
} else {
  $rules = get_rules();
}
?>

<?php include(SHARED_PATH . "/header.php"); ?>
<?php $page_title = 'Edit Rules'; ?>

<title>Edit Rules</title>

<div id="content">
    <div class="actions">
        <a class="btn btn-primary" href="<?php echo url_for('/staff/Staff_Index.php'); ?>">Back to Staff Dashoboard</a>
        <h1 class="text-center">Edit Rules</h1>
    </div>



    <div class="container" style="margin: 100px auto">
        <center>

            <?php echo display_errors_as_table($errors); ?>

            <form action="#" method="post">
                <dl>
                    <dt>Rental length</dt>
                    <dt><small>(weeks)</small></dt>
                    <dd>
                        <input type="number" min="1" name="rental_length" value="<?php echo (int)h($rules['rental_length']); ?>" />
                    </dd>
                </dl>

                <dl>
                    <dt>Maximum rentals per member</dt>
                    <dd>
                        <input type="number" min="1" name="max_rentals" value="<?php echo (int)h($rules['max_rentals']); ?>" />
                    </dd>
                </dl>

                <dl>
                    <dt>Ban length for violations</dt>
                    <dt><small>(months)</small></dt>
                    <dd>
                        <input type="number" min="1" name="ban_length" value="<?php echo (int)h($rules['ban_length']); ?>" />
                    </dd>
                </dl>

                <dl>
                    <dt>Time added per rental extension</dt>
                    <dt><small>(weeks)</small></dt>
                    <dd>
                        <input type="number" min="1" name="extension_length" value="<?php echo (int)h($rules['extension_length']); ?>" />
                        <br />
                    </dd>
                </dl>

                <dl>
                    <dt>Number of extensions per rental</dt>
                    <dd>
                        <input type="number" min="1" name="max_extensions" value="<?php echo (int)h($rules['max_extensions']); ?>" />
                    </dd>
                </dl>

                <dl>
                    <dt>Number of violations until ban</dt>
                    <dd>
                        <input type="number" min="1" name="max_violations" value="<?php echo (int)h($rules['max_violations']); ?>" />
                    </dd>
                </dl>
                <br />

                <div id="operations">
                    <input type="submit" min="1" class="btn btn-primary" value="Edit Rules" />
                </div>
            </form>

        </center>
    </div>
</div>

<?php include(SHARED_PATH . "/footer.php");?>

