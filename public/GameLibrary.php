<?php require_once('../private/initialise.php'); ?>

<?php 
if(!(is_post_request())) $games_set = find_all_games();
else $games_set = find_game_by_title($_POST['search']);
?>


<?php include(SHARED_PATH . "/header.php"); ?>
<title>Game Library</title>

<body>
  <main>
    <div class="container">
      <div class="card-columns" style="margin: 40px 0px;">
        <div class="row">
          <?php while($game = mysqli_fetch_assoc($games_set)) { ?>
            <div id="cards">
              <div class="col col-lg-4">
                <div class="card" style="width: 300px;">
                  <div class="card-body">
                    <?php
                    $url = ($game['image']);
                    if($url == "") { $url = (SHARED_PATH . "/images/placeholder.jpg"); }
                    $imageData = base64_encode(file_get_contents($url));
                    $imgtag = 'src="data:image/jpeg;base64,'.$imageData.'" alt="Card image cap">';
                    ?>
                    <img class="card-img-top" <?php echo $imgtag; ?> 
                    <p class="card-title"> <?php echo h($game['title']); ?></p>
                    <p class="card-text">Game ID: <?php echo h($game['game_id']); ?></p>
                    <p class="card-text">Platform: <?php echo h($game['platform']); ?></p>
                    <p class="card-text">Release Year: <?php echo h($game['release_year']); ?></p>
                    <p class="card-text">Broken: <?php echo $game['broken'] == 1 ? 'Yes' : 'No'; ?></p>
                    <p class="card-text">Available: <?php echo $game['available'] == 1 ? 'Yes' : 'No'; ?></p>
                    <p class="card-text">Game price: <?php echo h($game['price']); ?></p>
                    <p class="card-text"><a href="<?php echo h($game['info']); ?>">IGN Link</a></p>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <?php mysqli_free_result($games_set); ?>
  </main>

</body>

<?php include(SHARED_PATH . "/footer.php");?>
