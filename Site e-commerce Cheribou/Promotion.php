<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
  <link rel="stylesheet" href="include\Promotion.css">
  <title>Mon panier</title>
</head>

<body>
  <?php include("include/header.php"); ?>
  <main>
    <p class="titre">Nos offres</p>
    <div class="contener">
      <?php
      # On est partit du principe que, pour l'instant, les promos ne se font que sur les dragibou
      
      #on affiche donc tous les dragibous :
      require_once('include/Connect.inc.php');
      $nom = "Dragibou";   
      $req = "SELECT * FROM BONBONS WHERE NOMB = :nom";
      $requete = oci_parse($connect, $req);
      oci_bind_by_name($requete, ":nom", $nom);
      $result = oci_execute($requete);
      echo "<div class='produit'>";
          while (($container = oci_fetch_assoc($requete)) != false) {
          
            #calcul du nouveau prix en prenant en compte le taux de promotion dans la BD
            $prixU = str_replace(',', '.', htmlentities($container['PRIXUNITAIRE']));
            $prixpromo = $prixU - ($prixU*$container['PROMO']);
            
            #On affiche les infos
            echo "<div id='produitAffiche'>";
            echo "<div id='image'>";
            echo "<a href='detailBonbon.php?IDB=".$container['IDB']."'><img style='border-radius: 20px;' src='include/images/P0" . $container['IDB'] . ".jpg'  alt='image du produit'/></a>";
            echo "</div>";
            echo "<div id='contenerdesc'>";
            echo "<div id='nom'>" . $container['NOMB'] . "</div>";
            echo "<div style='text-decoration: line-through;' id='prix'><b>" . $container['PRIXUNITAIRE'] . " €</b></div>";
            echo "<div id='prixPromo' style='color: red;'>".$prixpromo." €</div>";
            echo "<div id='desc'>" . $container['DESCRIPTIONB'] . "</div>";
            echo "</div>";
            echo "</div>";
          }
          oci_free_statement($requete);
      ?>
      
        
      </div>
      <hr>
    </div>
  </main>
  <?php include("include/footer.php"); ?>
</body>

</html>