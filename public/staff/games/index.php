<?php 

require_once( '../../../private/initialise.php');

require_login(); 

?>

<?php $games_set=find_all_games(); ?>


<?php include(SHARED_PATH . "/header.php"); ?>

<title>Games</title>

<div class="container" style="margin: 100px auto">

    <h1>Games</h1>

    <div class="actions">
        <a class="btn btn-primary" href="<?php echo url_for('/staff/games/new.php'); ?>">Add New Game</a>
    </div>

    <div class="content">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Game ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Platform</th>
                    <th scope="col">Release Year</th>
                    <th scope="col">Broken</th>
                    <th scope="col">Available</th>
                    <th scope="col">Price (£)</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                <?php while($game=mysqli_fetch_assoc($games_set)) { ?>

                <tr <?php if(($game[ 'broken']==1 ) || ($game[ 'available']==0 )) echo 'class="table-secondary"'?>>
                    <td>
                        <?php echo h($game[ 'game_id']); ?>
                    </td>
                    <td>
                        <?php echo h($game[ 'title']); ?>
                    </td>
                    <td>
                        <?php echo h($game[ 'platform']); ?>
                    </td>
                    <td>
                        <?php echo h($game[ 'release_year']); ?>
                    </td>
                    <td>
                        <?php echo $game[ 'broken']==1 ? 'Yes' : 'No'; ?>
                    </td>
                    <td>
                        <?php echo $game[ 'available']==1 ? 'Yes' : 'No'; ?>
                    </td>
                    <td>
                        <?php echo number_format((float)h($game[ 'price']), 2); ?>
                    </td>
                    <td>
                        <a class="btn btn-outline-primary" href="<?php echo url_for('/staff/games/show.php?game_id=' . h(u($game['game_id']))); ?>">View</a>
                        <a class="btn btn-outline-primary" href="<?php echo url_for('/staff/games/edit.php?game_id=' . h(u($game['game_id']))); ?>">Edit</a>
                        <a class="btn btn-outline-danger" href="<?php echo url_for('/staff/games/delete.php?game_id=' . h(u($game['game_id']))); ?>">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php mysqli_free_result($games_set); ?>

    </div>

</div>


<?php include(SHARED_PATH . "/footer.php");?>
