<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
    <link rel="stylesheet" href="include/detailRecipient.css">
    <title>Détail Produit</title>
</head>

<body>
  <?php include("include/header.php"); ?>
    
    <div class="contener">
      <div class="gauche">
        <?php
          #gestion de l'image : on recup l'id du recipient
            $valueV = $_GET['IDR'];
            echo "<img class='image' src='include/images/R0" .$valueV. ".jpg' alt='image du recipient'/>";
        ?>
      </div>
      <div class="droite">
        <div class="info">
          <?php
            require_once('include/Connect.inc.php'); 
            $req = "SELECT * FROM Recipient WHERE IDR = :produit";
            $requete = oci_parse($connect, $req);
            oci_bind_by_name($requete, ":produit", $valueV);
            $result = oci_execute($requete);
            while (($container = oci_fetch_assoc($requete)) != false) {
              echo "".$container['NOMR']." + "; # affichage nom du produit
              echo "".$container['COULEURR']." + "; # affichage color du produit
              echo "".$container['POIDSUNITAIRE']." KG"; # affichage poids du produit
              echo "</div>";
              
              
              #id du recipient que l'on va ajouter
              $_SESSION['recipPanier'] = $container['IDR'];
              
              # affichage prix du produit / Promo si jamais
              $prixU = str_replace(',', '.', htmlentities($container['PRIXUNITAIRE']));
              $prixpromo = $prixU - ($prixU*$container['PROMO']);
              if($container['PROMO'] != null){
                echo "<div class='info'><p style='text-decoration: line-through;'>".$container['PRIXUNITAIRE']." euros</p>".$prixpromo." euros </div><br></br>";
              }else{
                echo "<div class='info'>".$container['PRIXUNITAIRE']." euros </div><br></br>";
              }
              
              # affichage bouton panier + qte a choisir
              echo " <form class='complement' method='POST' action='ajoutPanierRecip.php'>
                       <input class='qte' type='number' min='1' max='10' placeholder='quantite' name='qteAchoisir' value='1'/>
                       <input class='submit' type='submit' name='panier' value='Ajouter au panier'/>
                     </form><br></br>";
        
              # affichage description produit      
              echo "<br></br><div class='desc'><b>Description :</b><br></br>".$container['DESCRIPTIONR']."</div>";       
                        
              
            }
            oci_free_statement($requete);
          ?>
      </div>
    </div>
    
     <?php include("include/footer.php"); ?>

</body>

</html>