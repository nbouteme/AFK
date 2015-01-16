<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>AFK</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assests/css/style.css">
    </head>
    <body id="bodyLogin">
        <div id="main_connexion_page">
            <div id="form-login">
                <form method="post" action="<?php Url::to'/login'?>"
                    <h4>Connectez-vous</h4>
                    <input type="text" id="Name" class="form-control input-sm chat-input" placeholder="Nom d'utilisateur" />
                    <input type="password" id="Password" class="form-control input-sm chat-input" placeholder="Mot de passe" />
                    <div class="wrapper">
                        <span class="group-btn">     
                            <input type="submit" value="Se connecter" id="btnValider" class="btn btn-primary btn-md"/>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    </body>
</html>