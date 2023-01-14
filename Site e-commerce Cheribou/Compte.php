<?php
if(!isset($_SESSION)){
      session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte</title>
    <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
    <link rel="stylesheet" href="include\Compte.css">
</head>
<body>
    <?php include("include/header.php"); ?>
    <div class="links">
        <a href="?acces=login" <?php
                                if (isset($_GET['acces'])) {
                                    if ($_GET['acces'] == 'login') {
                                        echo ' id="loginLink" ';
                                    }
                                } ?>>Connexion</a>
        <a href="?acces=register" <?php if (isset($_GET['acces'])) {
                                        if ($_GET['acces'] == 'register') {
                                            echo 'id="registerLink"';
                                        }
                                    } ?>>Créer compte</a>
    </div>
    <?php
    if (isset($_GET['acces'])) {
        if ($_GET['acces'] == 'login') {
            echo '  
            <section>  
            <div class="container">
                <form action="include/traitFormConnexion.php" id="login" method="POST">
                  <h4>Connexion</h4>
                    <hr>
                    <label for="email"><b>Email</b></label>
                    <input type="email" name="Email" ';
                    if (isset($_COOKIE['Cook'])) {
                      echo "value='". $_COOKIE['Cook'] ."'";
                    }
                    
                   echo ' />
                    <label for="mdp"><b>Mot de passe</b></label>
                    <input type="password" name="mdp" />
                    <label for="souvenir">Se souvenir de moi: </label>
                    <input style="text-align: left;" type="checkbox" name="souvenir"/><BR>
                    <button name="valider" type="submit" id="valider">Valider</button>
                </form>
            </div>
          </section>';
        } elseif ($_GET['acces'] == 'register') {
            echo ' <section><div class="container">
                <form action="include/traitFormCreerCompte.php" id="regis" method="POST">
                    <h4>Inscription</h4>
                    <hr> 
                    <div class="name-field">
                        <div>
                        <strong> <label>Nom*</label></strong>
                             <input type="text" name="nom" />
                    </div>
                    <div>
                    <strong><label>Prenom*</label></strong>
                        <input type="text" name="prenom" />
                    </div>
                    </div>
                    <div class="name-field">
                        <div>
                        <strong> <label >E-mail*</label></strong>
            <input type="email" name="email">
            </div>
            <div>
            <strong><label >Confirmer lʼe-mail*</label></strong>
            <input type="email" name="email2" />
            </div>
            </div>
            <div class="name-field">
                        <div>
                        <strong><label >Mot de passe*</label></strong>
            <input type="password" name="mdp" />
            </div>
            <div>
            <strong><label >Confirmer le mot de passe*</label></strong>
            <input type="password" name="mdp2" />
            </div>
            </div>
            <div>
            <button id="valider" type="submit" name="valider">Valider</button>
            </div>
                </form>   
                </div> 
                </section>
            ';}}?>
    <?php include("include/footer.php"); ?>
</body>
</strong>
</html>