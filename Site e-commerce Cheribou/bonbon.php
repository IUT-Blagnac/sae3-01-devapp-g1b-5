<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="include/styles.css">
  <link rel="stylesheet" href="include/bonbon.css">
  <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
  <title>Nos bonbons !</title>
</head>
<body>
  <?php include("include/header.php"); ?>
  <main>
    <p class="titre">Nos Bonbons</p>
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
      <br></br><br></br><br></br><br></br>
      <?php
      if (!isset($_SESSION)) {
        session_start();
      }
      require_once('include/Connect.inc.php');
      $count = 0;
      if (isset($_GET['nomP'])) {
        $value = $_GET['nomP'];
        $req = "SELECT * FROM Bonbons WHERE nomB = :produit";
        $requete = oci_parse($connect, $req);
        oci_bind_by_name($requete, ":produit", $value);
      } elseif (isset($_GET['nomF'])) {
        $value = $_GET['nomF'];
        $req = "SELECT * FROM Bonbons WHERE Format = :format";
        $requete = oci_parse($connect, $req);
        oci_bind_by_name($requete, ":format", $value);
      } elseif (isset($_GET['nomG'])) {
        $value = $_GET['nomG'];
        $req = "SELECT * FROM Bonbons WHERE Gout = :gout";
        $requete = oci_parse($connect, $req);
        oci_bind_by_name($requete, ":gout", $value);
      } elseif (isset($_GET['nomPref'])) {
        $value = $_GET['nomPref'];
        $req = "SELECT * FROM Bonbons WHERE preferenceAlimentaire = :nomPref";
        $requete = oci_parse($connect, $req);
        oci_bind_by_name($requete, ":nomPref", $value);
      }
      $result = oci_execute($requete);
      echo "<div class='produit'>";
      while (($container = oci_fetch_assoc($requete)) != false) {
        echo "<div id='produitAffiche'>";
        echo "<div id='img'>";
        echo "<img style='border-radius: 20px;' src='include/images/P0" . $container['IDB'] . ".jpg'  alt='image du produit'/>";
        echo "</div>";
        echo "<div id='contenerdesc'>";
        echo "<div id='nom'>" . $container['NOMB'] . "</div>";
        echo "<div id='prix'>" . $container['PRIXUNITAIRE'] . " €</div>";
        echo "<div id='desc'>" . $container['DESCRIPTIONB'] . "</div>";
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