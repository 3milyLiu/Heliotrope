<?php 

require_once('../../../private/initialise.php'); 

require_login(); 

?>

<?php 

$id = $_GET['game_id'] ?? '1';

$game = find_game_by_id($id);

?>

<?php $page_title = 'Show Game'; ?>


<?php include(SHARED_PATH . "/header.php"); ?>

<title>View game </title>

<div class="actions">
    <a class="btn btn-primary" href="<?php echo url_for('/staff/games/index.php'); ?>"> Back to Games List</a>
    <h1 class="text-center">Game: <?php echo h($game['title']); ?></h1>
</div>

<div id="content">


    <center>
        <div class="game show">

            

            <div class="attributes">
                <dl>
                    <dd>
                        <?php 
                        $url=($game[ 'image']); 
                        if($url=="") {
                            $url="http://gallery.hd.org/_exhibits/memes/_more2000/_more04/question-mark-bg-mono-1-DHD.jpg" ; 
                        } 
                        $imageData=base64_encode(file_get_contents($url)); echo '<img src="data:image/jpeg;base64,'.$imageData. '">'; 
                        ?>
                    </dd>
                </dl>
                <dl>
                    <dt>Game ID</dt>
                    <dd>
                        <?php echo h($game[ 'game_id']); ?>
                    </dd>
                </dl>
                <dl>
                    <dt>Platform</dt>
                    <dd>
                        <?php echo h($game[ 'platform']); ?>
                    </dd>
                </dl>
                <dl>
                    <dt>Release year</dt>
                    <dd>
                        <?php echo h($game[ 'release_year']); ?>
                    </dd>
                </dl>
                <dl>
                    <dt>Broken</dt>
                    <dd>
                        <?php echo $game[ 'broken']=='1' ? 'Yes' : 'No'; ?>
                    </dd>
                </dl>
                <dl>
                    <dt>Available</dt>
                    <dd>
                        <?php echo $game[ 'available']=='1' ? 'Yes' : 'No'; ?>
                    </dd>
                </dl>
                <dl>
                    <dt>Price</dt>
                    <dd>
                        <?php echo h($game[ 'price']); ?>
                    </dd>
                </dl>
                <dl>
                    <a href="<?php echo h($game['info']); ?>">IGN Link</a>
                </dl>
            </div>

        </div>


    </center>
</div>

<?php include(SHARED_PATH . "/footer.php");?>
