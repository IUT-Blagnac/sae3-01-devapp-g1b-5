<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="include/Nouveaute.css">
  <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
  <title>Nos bonbons !</title>
</head>
<body>
  <?php include("include/header.php"); ?>
  <main>
    <p class="titre">Nouveautés chez nous !</p>
    <div class="contener">
    <?php
    require_once('include/Connect.inc.php');
    $req = "SELECT * FROM BONBONS WHERE IDB > 41";
    $requete = oci_parse($connect, $req);
    $result = oci_execute($requete);
    echo "<div class='produit'>";
    while (($container = oci_fetch_assoc($requete)) != false) {
      echo "<div id='produitAffiche'>";
      echo "<div id='img'>";
      echo "<a href='detailBonbon.php?IDB=".$container['IDB']."'><img style='border-radius: 20px;' src='include/images/P0" . $container['IDB'] . ".jpg'  alt='image du produit'/></a>";
      echo "</div>";
      echo "<div id='contenerdesc'>";
      echo "<div id='nom'>" . $container['NOMB'] . "</div>";
      echo "<div id='prix'><b>" . $container['PRIXUNITAIRE'] . " €</b></div>";
      echo "<div id='desc'>" . $container['DESCRIPTIONB'] . "</div>";
      echo "</div>";
      echo "</div>";
    }
      oci_free_statement($requete);
      
    $req1 = "SELECT * FROM RECIPIENT WHERE IDR > 5";
    $requete1 = oci_parse($connect, $req1);
    $result = oci_execute($requete1);
    echo "<div class='produit'>";
    while (($container1 = oci_fetch_assoc($requete1)) != false) {
      echo "<div id='produitAffiche'>";
      echo "<div id='img'>";
      echo "<a href='detailRecipient.php?IDR=".$container1['IDR']."'><img style='border-radius: 20px;' src='include/images/R0" . $container1['IDR'] . ".jpg'  alt='image du produit'/></a>";
      echo "</div>";
      echo "<div id='contenerdesc'>";
      echo "<div id='nom'>" . $container1['NOMR'] . "</div>";
      echo "<div id='prix'><b>" . $container1['PRIXUNITAIRE'] . " €</b></div>";
      echo "<div id='poid'>" . $container1['POIDSUNITAIRE'] . " Kg</div>";
      echo "<div id='desc'>" . $container1['DESCRIPTIONR'] . "</div>";
      echo "</div>";
      echo "</div>";
    }
      oci_free_statement($requete1);
    ?>
    </div>
  </main>
  <?php include("include/footer.php"); ?>
</body>

</html>