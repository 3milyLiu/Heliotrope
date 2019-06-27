<?php 

require_once( '../../../private/initialise.php'); 

require_login(); 

if(!isset($_GET['game_id'])) {
    redirect_to(url_for( '/staff/games/index.php')); 
} 

$id = $_GET['game_id']; 

if($_SERVER['REQUEST_METHOD']=='POST') {
    
    $result = delete_game($id); 
    
    redirect_to(url_for( '/staff/games/index.php')); 
    
} else {
    $game=find_game_by_id($id); 
    
} 

?>

<?php $page_title='Delete Game'; ?>


<?php include(SHARED_PATH . "/header.php"); ?>

<title>Delete Game</title>

<div class="back">
    <a class="btn btn-primary" href="<?php echo url_for('/staff/games/index.php'); ?>"> Back to Games List</a>
    <h1 class="text-center">Delete Game</h1>
</div>

<div class="container" style="margin: 100px auto">

    <center>
        <div class="game delete">

            <p>Are you sure you want to delete this game?</p>
            <p class="item">
                <?php echo h($game[ 'title']); ?>
            </p>

            <form action="<?php echo url_for('/staff/games/delete.php?game_id=' . h(u($game['game_id']))); ?>" method="post">
                <div id="operations">
                    <input type="submit" class="btn btn-danger" name="commit" value="Delete Game" />
                </div>
            </form>
        </div>


    </center>
</div>

<?php include(SHARED_PATH . "/footer.php");?>