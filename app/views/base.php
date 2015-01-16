<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>AFK</title>
        <meta charset="UTF-8">
        <link href='//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <nav>
            <a href="<?php Url::to('/')?>"><i class="fa fa-home"></i>
                <span>Acceuil</span></a>

            <?php if(Auth::isLoggedIn()) { ?>
                <a href="<?php Url::to("/profile/" . $_SESSION['user']);?>"><i class="fa fa-user"></i>
                    <span>Profil</span></a>
            <?php } else { ?>
                <a href="<?php Url::to("/login");?>"><i class="fa fa-sign-in"></i>
                    <span>Connexion</span></a>
            <?php } ?>
            <?php if(Auth::isLoggedIn()) { ?>
                <a href="<?php Url::to("/logout");?>"><i class="fa fa-sign-out"></i>
                    <span>Déconnexion</span></a>
            <?php } ?>

        </nav>
        <div id="container-main">
            <div class="container clearfix home">
                @Content@
            </div>
        </div>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    </body>
</html>

