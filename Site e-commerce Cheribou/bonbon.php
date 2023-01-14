<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
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
      <br></br><br></br>
      <?php
        if(isset($_GET['msgErreur'])){ #si il y a un mg d'erreur (donc qu'il n'y a pas d'articles correspondant à la recherche)
          $titre = $_GET['msgErreur'];
          echo "<h1 style='padding-bottom: 15%;'>$titre</h1>"; #on affiche l'erreur
        }
        else{ #sinon
          require_once('include/Connect.inc.php');
          if (isset($_GET['nomP'])) { # gestion des liens des marques
            $value = $_GET['nomP'];
            $req = "SELECT * FROM Bonbons WHERE nomB = :produit";
            $requete = oci_parse($connect, $req);
            oci_bind_by_name($requete, ":produit", $value);
          } elseif (isset($_GET['nomF'])) { # gestion des liens des formats
            $value = $_GET['nomF'];
            $req = "SELECT * FROM Bonbons WHERE Format = :format";
            $requete = oci_parse($connect, $req);
            oci_bind_by_name($requete, ":format", $value);
          } elseif (isset($_GET['nomG'])) { # gestion des liens des gouts
            $value = $_GET['nomG'];
            $req = "SELECT * FROM Bonbons WHERE Gout = :gout";
            $requete = oci_parse($connect, $req);
            oci_bind_by_name($requete, ":gout", $value);
          } elseif (isset($_GET['nomPref'])) { # gestion des liens des pref alimentaires
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
        }
      ?>
    </div>
  </main>
  <?php include("include/footer.php"); ?>
</body>

</html>