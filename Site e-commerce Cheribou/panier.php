<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
    <link rel="stylesheet" href="include\Panier.css">
    <title>Mon panier</title>
</head>

<body>
    <?php include("include/header.php"); ?>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if ($_SESSION['access'] != "oui") { #si la variable session est différent de oui
        echo "<script language='Javascript' type='text/javascript'>
      alert('Erreur: vous devez être connecté !'); location.href='Compte.php?acces=login';</script>";
        exit();
    }
    ?>
    <main>
        <div class="contener">
            <a href="include/Deconnexion.php"><button class="boutonD" style="color: black;"><b>Se déconnecter</b></button></a>
            <p><b>Mon panier</b></p>

            <p style="font-size: 2em;">X articles</p>
            <div class="contener2">
                <p class="text">Informations personnelles</p>
                <div class="cont">
                    <button class="boutonV">Valider</button>
                </div>
            </div>



        </div>
    </main>
    <?php include("include/footer.php"); ?>

</body>

</html>