<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="include/recipient.css">
  <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
  <title>Nos récipients !</title>
</head>
<body>
  <?php include("include/header.php"); ?>
  <main>
    <p class="titre">Nos Récipients</p>
    <div class="contener">
      <p class="text">
        <?php
        if (!isset($_SESSION)) {
          session_start();
        }
        #echo "".$_SESSION['compt']." résultats<br></br>"; 
        ?>
      <form class="form" method="POST">
        Trier par : <select style="width: 200px; font-size: 0.7em;" name='Type_recherche'>
          <option value="best">Meileur résultat</option>
          <option value="prixCroissant">Prix croissant</option>
          <option value="prixDecr">Prix décroissant</option>
          <option value="AaZ">De A à Z</option>
          <option value="ZaA">De Z à A</option>
          <option value="marque">Marque</option>
          <option value="PlusPOP">Les plus populaires</option>
        </select>
        <input style="font-size: 0.7em; width: 150px; height: 25px;" type="submit" name="Valider" value="Valider" />
      </form>
      <br></br><br>
      <?php
      if (!isset($_SESSION)) {
        session_start();
      }
      require_once('include/Connect.inc.php');
      $count = 0;
        $req = "SELECT * FROM Recipient";
        $requete = oci_parse($connect, $req);
      $result = oci_execute($requete);
      echo "<div class='produit'>";
      while (($container = oci_fetch_assoc($requete)) != false) {
        echo "<div id='produitAffiche'>";
        echo "<div id='img'>";
        echo "<a href='detailRecipient.php?IDR=".$container['IDR']."'><img style='border-radius: 20px;' src='include/images/R0" . $container['IDR'] . ".jpg'  alt='image du produit'/></a>";
        echo "</div>";
        echo "<div id='contenerdesc'>";
        echo "<div id='nom'>" . $container['NOMR'] . "</div>";
        echo "<div id='prix'>" . $container['PRIXUNITAIRE'] . " €</div>";
        echo "<div id='poid'>" . $container['POIDSUNITAIRE'] . " Kg</div>";
        echo "<div id='desc'>" . $container['DESCRIPTIONR'] . "</div>";
        echo "</div>";
        echo "</div>";
        $count += 1;
      }
      #echo "</div>";
      #echo "<div class='compteur' style='position: absolute; margin-bottom: 100px;'> $count résultats</div>";
      $_SESSION['compt'] = $count;
      oci_free_statement($requete);
      ?>
    </div>
  </main>
  <?php include("include/footer.php"); ?>
</body>

</html>