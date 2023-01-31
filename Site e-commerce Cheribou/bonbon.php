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
        <?php
        if (!isset($_SESSION)) {
          session_start();
        }
        ?>
      <br></br><br></br>
      <?php
        $count = 0;
        if(isset($_GET['msgErreur'])){ #si il y a un mg d'erreur (donc qu'il n'y a pas d'articles correspondant à la recherche)
          $titre = $_GET['msgErreur'];
          echo "<h1 style='padding-bottom: 15%; text-align: center;'>$titre</h1>"; #on affiche l'erreur
        }
        else{ #sinon
          require_once('include/Connect.inc.php');
          if (isset($_GET['Search'])) { #gestion si recherche par barre de recherche
            $req = "SELECT * FROM Bonbons WHERE lower(nomB) LIKE lower('%$_GET[Search]%')";
            $requete = oci_parse($connect, $req);


          }

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
            $count += 1;
          }
          if($count == 0){
            echo "<p style = 'font-size: 2.5em; margin: 25%; ' ><b>Aucun résultat !</b></p><br></br>";
          }
          oci_free_statement($requete);
        }
      ?>
    </div>
  </main>
  <?php include("include/footer.php"); ?>
</body>

</html>