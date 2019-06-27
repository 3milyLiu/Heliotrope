<?php

require_once('../../../private/initialise.php');

require_login(); 

if(!isset($_GET['game_id'])) {
  redirect_to(url_for('/staff/games/index.php'));
}
$id = $_GET['game_id'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $game = [];
    $game['game_id'] = $id;
    $game['title'] = $_POST['title'] ?? '';
    $game['platform'] = $_POST['platform'] ?? '';
    $game['release_year'] = $_POST['release_year'] ?? '';
    $game['broken'] = $_POST['broken'] ?? '';
    $game['available'] = $_POST['available'] ?? '';
    $game['price'] = $_POST['price'] ?? '';
    $game['info'] = $_POST['info'] ?? '';
    $game['image'] = $_POST['image'] ?? '';
      
      
    $result = update_game($game);
    if($result === true) {
        redirect_to(url_for('/staff/games/show.php?game_id=' . $id));
    } else {
        $errors = $result;
        //var_dump($errors);
    }
      
  } 
  
$game = find_game_by_id($id); 
$platforms = find_all_platforms();

?>

<?php include(SHARED_PATH . "/header.php"); ?>

<title>Edit game</title>


<div id="content">
    <div class="actions">
        <a class="btn btn-primary" href="<?php echo url_for('/staff/games/index.php'); ?>"> Back to Games List</a>
        <h1 class="text-center">Edit Game</h1>
    </div>


    <div class="container" style="margin: 100px auto">
        <center>

            <?php echo display_errors_as_table($errors); ?>

            <form action="<?php echo url_for('/staff/games/edit.php?game_id='. h(u($id))); ?>" method="post">

                <dl>
                    <dt>Game Title</dt>
                    <dd>
                        <input type="text" name="title" value="<?php echo $game['title']; ?>" />
                    </dd>
                </dl>
                <dl>
                    <!-- Displays all platforms from database, pre select the current platform -->
                    <dt>Platform</dt>
                    <dd>
                        <select name="platform">
                            <?php while($platform=mysqli_fetch_assoc($platforms)) { ?>
                            <option value="<?php echo h($platform['name']); ?>">
                                <?php echo h($platform['name']); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </dd>
                </dl>
                <dl>
                    <dt>Release Year</dt>
                    <dd>
                        <input type="text" maxlength="4" name="release_year" value="<?php echo $game['release_year']; ?>" />
                    </dd>
                </dl>
                <dl>

                    <dt>Price</dt>
                    <dd>
                        <input type="text" name="price" value="<?php echo $game['price']; ?>" />
                    </dd>
                </dl>
                <dl>
                    <dt>Broken</dt>
                    <dd>
                        <input type="hidden" name="broken" value="0" />
                        <input type="checkbox" name="broken" value="1" <?php if($game[ 'broken']=="1" ) { echo " checked"; } ?> />
                    </dd>
                </dl>
                <dl>
                    <dt>Available</dt>
                    <dd>
                        <input type="hidden" name="available" value="0" />
                        <input type="checkbox" name="available" value="1" <?php if($game[ 'available']=="1" ) { echo " checked"; } ?> />
                    </dd>
                </dl>
                <dl>
                    <dt>IGN Link</dt>
                    <dd>
                        <input type="text" name="info" value="<?php echo $game['info']; ?>" />
                    </dd>
                </dl>
                <dl>
                    <dt>URL for thubmnail</dt>
                    <dd>
                        <input type="text" name="image" value="<?php echo $game['image']; ?>" />
                    </dd>
                </dl>

                <div id="operations">
                    <input type="submit" class="btn btn-primary" value="Edit Game" >
                </div>
            </form>


        </center>
    </div>
</div>
 <?php include(SHARED_PATH . "/footer.php");?>