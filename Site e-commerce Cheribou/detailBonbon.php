<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
    <link rel="stylesheet" href="include/detailBonbon.css">
    <title>Détail Produit</title>
</head>

<body>
  <?php include("include/header.php"); ?>
    
    <div class="contener">
      <div class="gauche">
        <?php
          if(isset($_GET['IDB'])){ #gestion de l'image : si on retrouve la variable IDB :
            $valueV = $_GET['IDB'];
            echo "<img class='image' src='include/images/P0" .$valueV. ".jpg' alt='image du produit'/>";
          }else{ #sinon : (sa veut dire qu'on a cliquer sur un autre format)
            require_once('include/Connect.inc.php');
            $value = $_GET['Format'];
            $color = $_GET['colorBonbon'];
            $nom = $_GET['NOM'];
            $req5 = "SELECT * FROM Bonbons WHERE Format = :produit AND COULEURB = :idP AND NOMB = :nom";
            $requete5 = oci_parse($connect, $req5);
            oci_bind_by_name($requete5, ":produit", $value);
            oci_bind_by_name($requete5, ":idP", $color);
            oci_bind_by_name($requete5, ":nom", $nom);
            $result = oci_execute($requete5);
            while (($container5 = oci_fetch_assoc($requete5)) != false) {
              $valueV = $container5['IDB'];
              echo "<img class='image' src='include/images/P0" .$valueV. ".jpg' alt='image du produit'/>";
            }
            oci_free_statement($requete5);
          }
        ?>
      </div>
      <div class="droite">
        <div class="info">
          <?php
            require_once('include/Connect.inc.php');
            if(isset($_GET['colorBonbon'])){ #si on a cliqué sur un autre format
              $value = $_GET['Format'];
              $color = $_GET['colorBonbon'];
              $nom = $_GET['NOM'];
              $req = "SELECT * FROM Bonbons WHERE Format = :produit AND COULEURB = :idP AND NOMB = :nom";
              $requete = oci_parse($connect, $req);
              oci_bind_by_name($requete, ":produit", $value);
              oci_bind_by_name($requete, ":idP", $color);
              oci_bind_by_name($requete, ":nom", $nom);
            
            }else{ #sinon 
              $value = $_GET['IDB'];
              $req = "SELECT * FROM Bonbons WHERE IDB = :produit";
              $requete = oci_parse($connect, $req);
              oci_bind_by_name($requete, ":produit", $value);
            }
            
            $result = oci_execute($requete);
            while (($container = oci_fetch_assoc($requete)) != false) {
              echo "".$container['NOMB']." + "; # affichage nom du produit
              echo "".$container['FORMAT']." + "; # affichage format du produit
              echo "".$container['POIDS']." KG<br></br>"; # affichage poids du produit
              echo "</div>";
              echo "<div class='format1'>Formats disponibles : <br></br>";
              if($container['IDB'] == 19 or $container['IDB'] == 20 or $container['IDB'] == 83){#gestion des formats seulement pour les grands sachets
                echo "<a style='color: red; text-decoration: none;' href='detailBonbon.php?colorBonbon=".$container['COULEURB']."&NOM=".$container['NOMB']."&Format=Grand Sachet'>Grand Sachet</a><br></br></div>";
              }
              elseif($container['IDB'] > 32 AND $container['IDB'] <= 41){#gestion des formats seulement pour les toudoudou
              echo "<a style='color: red; text-decoration: none;' href='detailBonbon.php?colorBonbon=".$container['COULEURB']."&NOM=".$container['NOMB']."&Format=10cm'>10cm</a> - 
                    <a style='color: red; text-decoration: none;' href='detailBonbon.php?colorBonbon=".$container['COULEURB']."&NOM=".$container['NOMB']."&Format=25cm'>25cm</a> - 
                    <a style='color: red; text-decoration: none;' href='detailBonbon.php?colorBonbon=".$container['COULEURB']."&NOM=".$container['NOMB']."&Format=50cm'>50cm</a><br></br></div>";
              }else{#gestion des formats seulement pour tout le reste
                echo "<a style='color: red; text-decoration: none;' href='detailBonbon.php?colorBonbon=".$container['COULEURB']."&NOM=".$container['NOMB']."&Format=Grand Sachet'>Grand Sachet</a> - 
                      <a style='color: red; text-decoration: none;' href='detailBonbon.php?colorBonbon=".$container['COULEURB']."&NOM=".$container['NOMB']."&Format=Mini Sachet'>Mini Sachet</a><br></br></div>";
              }
              
              #id du bonbon que l'on va ajouter
              $_SESSION['bonbonsPanier'] = $container['IDB'];
              
              # affichage prix du produit / Promo si jamais
              $prixU = str_replace(',', '.', htmlentities($container['PRIXUNITAIRE']));
              $prixpromo = $prixU - ($prixU*$container['PROMO']);
              if($container['PROMO'] != 0){
                echo "<div class='info'><p style='text-decoration: line-through;'>".$container['PRIXUNITAIRE']." euros</p>".$prixpromo." euros / ".$container['PRIXKG']." euros le kilos</div><br></br>";
              }else{
                echo "<div class='info'>".$container['PRIXUNITAIRE']." euros / ".$container['PRIXKG']." euros le kilos</div><br></br>";
              }
              # affichage bouton panier + qte a choisir
              echo " <form class='complement' method='POST' action='ajoutPanierBonbon.php'>
                       <input class='qte' type='number' min='1' max='10' placeholder='quantite' name='qteAchoisir' value='1'/>
                       <input class='submit' type='submit' name='panier' value='Ajouter au panier'/>
                     </form><br></br>";
        
              # affichage ingrédients et pref alimentaire du produit        
              echo "<br></br><div class='complement2'>
                      <div class='ingredient'><b>Ingrédients :</b><br></br>".$container['INGREDIENT']."</div>
                      <div class='valeurNutri'><b>Préférence Alimentaire :</b><br></br>".$container['PREFERENCEALIMENTAIRE']."</div>  
                    </div>
                  
                  
                  ";       
                        
              
            }
            oci_free_statement($requete);
          ?>
      </div>
    </div>
    
     <?php include("include/footer.php"); ?>

</body>

</html>