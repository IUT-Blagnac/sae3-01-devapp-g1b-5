<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                                    } ?>>Cree compte</a>
    </div>



    <?php
    if (isset($_GET['acces'])) {
        if ($_GET['acces'] == 'login') {
            echo '  <section>  <div class="container">
                <form action="" id="login" method="post">
                    <label for="email">Email</label>
                    <input id="email" type="email">
                    <label for="mdp">Mot de passe</label>
                    <input id="mdp" type="password">
                    <button type="submit" id="valider">Valider</button>
                </form>
            </div>
            
    </section>';
        } elseif ($_GET['acces'] == 'register') {
            echo ' <div class="body">
                <form>
                    <h4>Inscription</h4>
                    <hr>
                    <div class="name-field">
                        <div>
                             <label>Nom</label>
                             <input type="text">
                    </div>
                    <div>
                        <label>Prenom</label>
                        <input type="text">
                    </div>
                    </div>
                    <label >Email</label>
            <input type="email">
            <label >Mot de passe</label>
            <input type="password">
                  
                  <label >Mot de passe</label>
            <input type="password">
            <input type="submit" value="S inscrire">
            
                
                </form>    
           
            ';
        }
    }

    ?>



</body>

</html>