<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
  <link rel="stylesheet" href="include\i.css">
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
    </div>
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
    else {
    echo "<div class ='historique' style='margin-left: 5%; margin-right: 49%;'>";
    echo "<h4>Historique des commandes</h4><br><br>";
   
    $query = 'SELECT c.idcommande, c.datecommande, c.prixc, ce.nomc from commande c, client ce where ce.idclient = c.idclient and c.idclient =' . $_SESSION['IDC']. '';
    $stid = oci_parse($connect, $query);
    
    $result = oci_execute($stid);
    while (($row = oci_fetch_assoc($stid)) != false) {
    echo "<p>" . "Id commande : " . $row['IDCOMMANDE'] . " / Date commande : " . $row['DATECOMMANDE'] . " / Prix commande : " . $row['PRIXC'] . " euros " . " / Nom client : " . $row[      'NOMC'] . "<br>\n </p>";
    }
    echo "</div>";
    
    
    echo "<div class='fidel'  >";
    echo "<h3>Mes points de fidélité</h3>";
    $r = "SELECT ptsfidelite FROM client where idclient=:idc";
        $sa = oci_parse($connect, $r);
        $idc = $_SESSION['IDC'];
        oci_bind_by_name($sa, ':idc', $idc);
        $result = oci_execute($sa);
        $p = oci_fetch_assoc($sa);
        $fidel = htmlentities($p['PTSFIDELITE']);
        echo "<p>Vous avez " . $fidel . " points de fidelité<br><br>";
        oci_free_statement($sa);
        if($fidel!=0){
          echo "<button class='bf' name='boutonF'>Voir mes cadeaux</button>";
        }
       
    
    echo "</div>";
    
    }
    ?>
  
  <div class="ca">
  <?php include("include/footer.php"); ?>
  </div>
</body>
  </html>