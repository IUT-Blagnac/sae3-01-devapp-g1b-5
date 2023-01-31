<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="include/Cadeau.css">
  <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
  <title>Nos bonbons !</title>
</head>
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
<body>
  <?php include("include/header.php"); ?>
  <main>
    <div class="contener">
      <div class="gauche">
        <div class="value">
          <h2>Votre programme fidélité</h2>
          <?php
          require_once('include/Connect.inc.php');
          $req = "SELECT * FROM Client WHERE adresseMail = :pMail";
          $requete = oci_parse($connect, $req);
          $LoginMail = $_GET['email'];
          oci_bind_by_name($requete, ":pMail", $LoginMail);
          $result = oci_execute($requete);
          while (($container = oci_fetch_assoc($requete)) != false) {
            echo "Vous avez ".$container['PTSFIDELITE']." points de fidélités.";
            echo "</div>";
            echo "<div class='produit'>";
            
            if($container['PTSFIDELITE'] < 25){
              echo "Vous n'avez pas asser de points de fidélités pour accèder aux cadeaux. Requis : minimum 25 points.";
            }     
            if($container['PTSFIDELITE'] >= 25){
              echo "<div><img style='border-radius: 20px;' src='include/images/P083.jpg'  alt='image du produit'/><br></br>
                     <form method='POST' action='include/actionPanierCadeau.php?id=83&points=".$container['PTSFIDELITE']."'><button class='boutonInfos' name='boutonMdp'>25 points</button></form><br></br></div>";
            }
            if($container['PTSFIDELITE'] >= 50){
              echo "<div><img style='border-radius: 20px;' src='include/images/P020.jpg'  alt='image du produit'/><br></br>
                      <form method='POST' action='include/actionPanierCadeau.php?id=20&points=".$container['PTSFIDELITE']."'><button class='boutonInfos' name='boutonMdp'>50 points</button></form><br></br></div>";
            }
            if($container['PTSFIDELITE'] >= 100){
              echo "<div><img style='border-radius: 20px;' src='include/images/P029.jpg'  alt='image du produit'/><br></br>
                     <form method='POST' action='include/actionPanierCadeau.php?id=29&points=".$container['PTSFIDELITE']."'><button class='boutonInfos' name='boutonMdp'>100 points</button></form><br></br></div>";
            }
            if($container['PTSFIDELITE'] >= 200){
              echo "<div><img style='border-radius: 20px;' src='include/images/P021.jpg'  alt='image du produit'/><br></br>
                     <form method='POST' action='include/actionPanierCadeau.php?id=21&points=".$container['PTSFIDELITE']."'><button class='boutonInfos' name='boutonMdp'>200 points</button></form><br></br></div>";
            }
          } 
          oci_free_statement($requete);
          ?>
        </div>
      </div>
      
      
      
      <div class="droite">
        <a href="include/Deconnexion.php"><button class="boutonD" style="color: black;"><b>Se déconnecter</b></button></a>
        <div class="info">
          <h3>Mes informations</h3>
          Consulter et modifier toutes vos informations personnelles.
          <?php
          $LoginMail = $_SESSION['nom'];
          echo "<br></br><a href='InfosCompte.php?nomC=".$LoginMail."'><button class='boutonInfos' name='boutonMdp'>Mes informations</button></a>";
          ?>
        </div>
        <div class="commandes">
          <h3>Mes commandes</h3>
          Accéder à la liste des commandes que vous avez passées sur le site Cheribou.
          <?php
          $LoginMail = $_SESSION['nom'];
          echo "<br></br><a href='InfosCompte.php?nomC=".$LoginMail."'><button class='boutonInfos' name='boutonMdp'>Mes commandes</button></a>";
          ?>
        </div>
      </div>
    </div>
  </main>
  <?php include("include/footer.php"); ?>
</body>

</html>