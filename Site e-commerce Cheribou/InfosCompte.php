<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
  <link rel="stylesheet" href="include\infosCompte.css">
  <title>Mon Compte</title>
</head>
<body>
  <?php include("include/header.php"); ?>
  <main>
  <?php
  if (!isset($_SESSION)) {
    session_start();
  }
  
  
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
    $tel = $container['TELPORTABLEC'];
  } 
  oci_free_statement($requete);
  ?>
  <h2>Bienvenue !<br> 
  <?php echo "$nom"; ?></h2>
  <a href="include/Deconnexion.php"><button class="boutonD" style="color: black;"><b>Se déconnecter</b></button></a>
  
  
  
    <div class="global">
      <div class="info" style="margin-left: 5%;">
      <!--on affiche les différentes données-->
        <p style="font-size: 2em; color:#ff74aa;">Informations personnelles</p><br>
        <b>Nom : </b><?php echo "$nom"; ?><br></br>
        <b>Prénom : </b><?php echo "$prenom"; ?><br></br>
        <b>Points de fidélités : </b><?php echo "$points"; ?><br></br>
        <b>Numéro de téléphone : </b><?php echo "$tel"; ?><br></br>
        <b>Adresse mail : </b><?php echo "$LoginMail"; ?><br></br>
        <form method="POST" <?php echo "action='InfosCompte.php?nomC=".$LoginMail."'>"; ?> 
          <button class="boutonM" name="boutonModif">Modifier</button>
        </form>
      </div>
      <?php
      if (isset($_POST['boutonModif'])) {
      
        echo "<div class='global2'>";
        echo "<form class='formModif' method='POST' action='include/modifierCompte.php?ancienMail=" . $LoginMail . "' >";
        echo "<p><b>Modification des informations</b></p><br>";
        echo "Nom : <input type='text' name='nom'/><br><br>
            Prénom : <input type='text' name='prenom'/><br><br>
            AdresseMail : <input type='text' name='mail'/><br><br>
            Téléphone : <input type='text' name='tel'/><br><br>       
            <input style='font-size: 0.5em; padding-left: 5%; padding-right: 5%;' type='submit' value='Valider' name='Valider'/><br>";
        echo "</form>";
        echo "</div>";#fermeture global2
      echo "</div>";#fermeture classe global
      }
      else {
        echo "<div class='global2'>";
          echo "<div class='fidel'>";
          echo "<h3>Mes points de fidélité</h3>";
          $r = "SELECT * FROM Client where idclient=:idc";
          $sa = oci_parse($connect, $r);
          $idc = $_SESSION['IDC'];
          oci_bind_by_name($sa, ':idc', $idc);
          $result = oci_execute($sa);
          while (($container = oci_fetch_assoc($sa)) != false) {
            echo "<p>Vous avez " . $container['PTSFIDELITE'] . " points de fidelité<br><br>";
            if($container['PTSFIDELITE']!=0){
              echo "<a href='Cadeaux.php?email=".$_SESSION['nom']."'><button class='bf' name='boutonF'>Voir mes cadeaux</button></a>";
            }
          }
          oci_free_statement($sa);
          echo "</div><br></br>";
          echo "<div class='mdp'  >";
          echo "<h3>Mot de passe</h3>";
          echo "<br><a href='ChangeMDP.php'><button class='bmdp' name='boutonMdp'>Modifier</button></a>";
          echo "</div>";
        echo "</div>"; #fermeture global2
        echo "</div>"; #fermeture classe global
      }
      ?>
      <br></br>
      <div class ='historique' style='margin-left: 5%;'>
      <h4>Historique des commandes</h4><br><br>
      <?php
      $query = 'SELECT c.idcommande, c.datecommande, c.prixc, ce.nomc from commande c, client ce where ce.idclient = c.idclient and c.idclient =' . $_SESSION['IDC']. ' ORDER BY c.datecommande DESC';
      $stid = oci_parse($connect, $query);
    
      $result = oci_execute($stid);
      while (($row = oci_fetch_assoc($stid)) != false) {
        echo "<p>" . "Id commande : " . $row['IDCOMMANDE'] . " / Date commande : " . $row['DATECOMMANDE'] . " / Prix commande : " . $row['PRIXC'] . " euros " . " / Nom client : " . $row[      'NOMC'] . "<br>\n </p>";
      }
      echo "</div>";
      oci_free_statement($stid);
     ?>
  </main>
  
  <?php include("include/footer.php"); ?>
  
</body>
</html>