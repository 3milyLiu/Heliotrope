<?php

require_once('../../../private/initialise.php');

require_login();

if(!isset($_GET['rental_id'])) {
  redirect_to(url_for('/staff/rentals/index.php'));
}

$id = $_GET['rental_id'];


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $rental = [];
    $rental['rental_id'] = $id;
    $rental['broken'] = $_POST['broken'] ?? '';
    $rental['returned'] = $_POST['returned'] ?? '';
    $rental['extend'] = $_POST['extend'] ?? '';
      
    if($rental['broken']) {
        $result = rental_returned_broken($rental);
    }
    else if($rental['returned']) {
        $result = return_rental($rental);
    }
    else if($rental['extend']) {
        $result = extend_rental($rental);
    }
      
    if($result === true) {
        
        redirect_to(url_for('/staff/rentals/index.php'));
            
    } else {
        $errors = $result;
        //var_dump($errors);
    }
      
} 

$rentals = find_rental_by_id($id); 

?>

<?php include(SHARED_PATH . "/header.php"); ?>

<title>Gaming Society</title>


<div id="content">


    <?php echo display_errors_as_table($errors); ?>

    <?php $page_title='Rentals' ; ?>


    <div class="container" style="margin: 100px auto">

        <h1>Rentals</h1>

        <div class="actions">
            <a class="btn btn-primary" href="<?php echo url_for('/staff/rentals/index.php'); ?>">Back to Rentals</a>
        </div>

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
                <?php while($rental=mysqli_fetch_assoc($rentals)) { ?>

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
            </tbody>

        </table>

        <form action="#" method="post">
            <div id="operations">
                <!-- Disable extensions for overdue rentals -->
                <button class="btn btn-primary" type="submit" name="extend" value="1" <?php if(date( 'Y-m-d')> h($rental['date_due'])) echo 'disabled'; ?>>Extend</button>
                <button class="btn btn-primary" type="submit" name="returned" value="1">Return</button>
                <button class="btn btn-warning" type="submit" name="broken" value="1">Return Broken</button>
            </div>
        </form>
        <?php } ?>
    </div>
</div>

        
        
<?php include(SHARED_PATH . "/footer.php");?>