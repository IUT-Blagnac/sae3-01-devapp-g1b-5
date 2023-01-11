<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
  <link rel="stylesheet" href="include\infosComtpe.css">
  <title>Mon Compte</title>
</head>
<body>
  <?php include("include/header.php"); ?>
  <?php
  //requete SQL pour recup nom, prenom, point, adresse mail et num de tel en fonction de l'adresse mail du client connecté
  require_once('include/Connect.inc.php');
  $LoginMail = $_GET['nomC'];
  $req = "SELECT * FROM Client WHERE adresseMail = :pMail";
  $requete = oci_parse($connect, $req);
  oci_bind_by_name($requete, ":pMail", $LoginMail);
  $result = oci_execute($requete);
  while (($container = oci_fetch_assoc($requete)) != false) {
    $nom = $container['NOMC'];
    $prenom = $container['PRENOMC'];
    $points = $container['PTSFIDELITE'];
    $adresse = $container['ADRESSEC'];
    $tel = $container['TELPORTABLEC'];
  } 
  oci_free_statement($requete);
  ?>
  <h2>Bienvenue !<br> 
  <?php echo "$nom"; ?></h2>
  <a href="include/Deconnexion.php"><button class="boutonD" style="color: black;"><b>Se déconnecter</b></button></a>
  <div class="info" style="margin-left: 5%; margin-right: 49%;">
  <!--on affiche les différentes données-->
    <p style="font-size: 2em; color:#ff74aa;">Informations personnelles</p><br>
    <b>Nom : </b><?php echo "$nom"; ?><br></br>
    <b>Prénom : </b><?php echo "$prenom"; ?><br></br>
    <b>Points de fidélités : </b><?php echo "$points"; ?><br></br>
    <b>Adresse : </b><?php echo "$adresse"; ?><br></br>
    <b>Numéro de téléphone : </b><?php echo "$tel"; ?><br></br>
    <b>Adresse mail : </b><?php echo "$LoginMail"; ?><br></br>
    <form method="POST" <?php echo "action='InfosCompte.php?nomC=".$LoginMail."'>"; ?> 
      <button class="boutonM" name="boutonModif">Modifier</button>
    </form>
    <?php
    if (isset($_POST['boutonModif'])) {
      echo "<form class='formModif' method='POST' action='include/modifierCompte.php?ancienMail=" . $LoginMail . "' >";
      echo "<p><b>Modification des informations</b></p><br>";
      echo "Nom : <input type='text' name='nom'/><br><br>
            Prénom : <input type='text' name='prenom'/><br><br>
            AdresseMail : <input type='text' name='mail'/><br><br>
            Téléphone : <input type='text' name='tel'/><br><br>       
            <input style='font-size: 0.5em; padding-left: 5%; padding-right: 5%;' type='submit' value='Valider' name='Valider'/><br>";
      echo "</form>";
    }
    ?>
  </div>
  <?php include("include/footer.php"); ?>
</body>
  </html>