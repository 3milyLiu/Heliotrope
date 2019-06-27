<!DOCTYPE html>
<html lang = "en">
<head>

    <meta charset = "utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <!-- This Section takes care of the rows and columns used for the button in the home page-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- This Section takes care of the rows and columns used for the button in the home page-->
    
    <!-------------------------- Nav Bar ----------------------------->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-------------------------- Nav Bar ----------------------------->

     <!-------------------------- Carousel ----------------------------->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-------------------------- Carousel ----------------------------->
    
    <link rel = "stylesheet" type = "text/css" href = "<?php echo url_for('../private/shared/myStyle.css'); ?>">

</head>

<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark">
    
        <a href="<?php echo url_for('/index.php'); ?>" class="navbar-brand">Home</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a href="<?php echo url_for('/GameLibrary.php'); ?>" class="nav-item active nav-link"><button class="btn btn-outline-info" type="submit">Game Library</button></a>
            <ul class="navbar-nav mr-auto">
            <form action="<?php echo url_for('../public/GameLibrary.php'); ?>" method="post" class="form-inline my-2 mylg-0">
                <input type="search" name="search" id="search" class="form-control mr-md-4" placeholder="Search a Game" aria-label="search">
                <button class="btn btn-outline-info" type="submit">Search</button>
            </form>
            </ul>
            
            <?php if(is_logged_in()) { ?>
            <a class="navbar-brand" style="color:white">User: <?php echo $_SESSION['username'] ;?></a>
            <a href="<?php echo url_for('/staff/logout.php'); ?>" class="navbar-brand" >Logout</a>
            <?php } ?>
            <a href="<?php echo url_for('/staff/Staff_Index.php'); ?>" class="navbar-brand">Staff</a>
            
        </div>
    </nav>
<!------ Include the above in your HEAD tag ----------><!------ Include the above in your HEAD tag ----------><!------ Include the above in your HEAD tag ---------->    
