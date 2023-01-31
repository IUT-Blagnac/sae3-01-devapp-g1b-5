<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
  <link rel="stylesheet" href="include\Panier.css">
  <title>Mon panier</title>
</head>

<body>
  <?php include("include/header.php"); ?>
  <?php
  if (!isset($_SESSION)) {
    session_start();
  }
  if ($_SESSION['access'] != "oui") { #si la variable session est différent de oui
    echo "<script language='Javascript' type='text/javascript'>
      alert('Erreur: vous devez être connecté !'); location.href='Compte.php?acces=login';</script>";
    exit();
  }
  ?>
  <main>
    <div class="contener">
      <a href="include/Deconnexion.php"><button class="boutonD" style="color: black;"><b>Se déconnecter</b></button></a>
      <p><b>Mon panier</b></p>

      <p style="font-size: 2em;">
        <?php
        require_once("include/Connect.inc.php");
        $req = "SELECT * FROM panier where idpanier=:idc";
        $appelFunctStock = oci_parse($connect, $req);
        $idc = $_SESSION['IDC'];
        oci_bind_by_name($appelFunctStock, ':idc', $idc);
        $result = oci_execute($appelFunctStock);
        $panier = oci_fetch_assoc($appelFunctStock);
        $nba = htmlentities($panier['NBPRODUIT']);
        oci_commit($connect);
        oci_free_statement($appelFunctStock);
        if ($nba == 0) {
          echo "Votre panier est vide</p>";
        } elseif ($nba == 1) {
          echo "$nba article </p>";
        } else {
          echo "$nba articles</p>";
        } ?>

      <div class="contener2">
        <p class="text">Informations personnelles</p>


        <?php require_once("include/Connect.inc.php");
        //Table ContientBonbon

        //---------------------------------------------------------------------------------------------------------------------------------------
        $req1 = 'SELECT * from contientbonbon where idpanier = :idc';
        $nomproduit = oci_parse($connect, $req1);
        $idp = htmlentities($_SESSION['IDC']);
        oci_bind_by_name($nomproduit, ":idc", $idp);
        $resultat = oci_execute($nomproduit);
        while (($container = oci_fetch_assoc($nomproduit)) != false) {
          $qkg = htmlentities($container['QUANTITEKG']);
          $req2 = "SELECT * FROM BONBONS WHERE IDB=:idb";
          $nomb = oci_parse($connect, $req2);
          oci_bind_by_name($nomb, ':idb', $container['IDB']);
          $res = oci_execute($nomb);
          while (($container2 = oci_fetch_assoc($nomb)) != false) {
            $idbonbon = htmlentities($container2['IDB']);
            $nameC = htmlentities($container2['NOMB']);
            $datailC = htmlentities($container2['DESCRIPTIONB']);
            if ($container2['PROMO'] != '0') { //gestion de la promo
              $prix = str_replace(',', '.', htmlentities($container2['PRIXUNITAIRE']));
              $prixU = $prix - ($prix * $container2['PROMO']);
            } else {
              $prixU = str_replace(',', '.', htmlentities($container2['PRIXUNITAIRE']));
            }
             if($container['FIDELITE'] == 'oui'){
               $prixU = 0;
             }
            $format = htmlentities($container2['FORMAT']);
          }
          $prixTotal = $prixU * $qkg;
          echo  '
                    <div class="cont">
                      <div class="bonbon">
                        <img id="bonbon" src="include/images/P0' . $idbonbon . '.jpg" alt="img bonbon">
                      </div>
                      <div class="infop">       
                        <h2>' . $nameC . '</h2>
                        <p>' . $datailC . '</p>
                      </div>
                      <div class="infop">       
                        <h2>Format :</h2>
                        <p>' . $format . '</p>
                      </div>
                      <div class="prixun">
                        <h2>Prix unitaire :</h2>
                          <p>' . $prixU . '€</p>';
                          if($container['FIDELITE'] == 'oui'){
                              echo "<br></br><p style='color: red; font-size: 1em;'>Paiement par pts fidélités</p>";
                          } 
                          
         echo  '             </div>
                      <div class="quant">
                        <h2>Quantité :</h2>
                        <p>' . $qkg . '</p>
                      </div>
                      <div class="prix">
                        <h2>Prix total :</h2>
                        <p>' . $prixTotal . ' €</p>
                      </div> 
                      <div class="imgP">';
                      if($container['FIDELITE'] == 'oui'){
                       echo ' <a href="include/supprimerbonbon.php?idb=' . $idbonbon . '&fi=oui"><button class="boutonS" style="color: RED;"><b>Supprimer</b></button></a>';
                      }else{
                       echo ' <a href="include/supprimerbonbon.php?idb=' . $idbonbon . '"><button class="boutonS" style="color: RED;"><b>Supprimer</b></button></a>';
                      }
                   echo '   </div>
                    </div><hr>
                    ';
          oci_free_statement($nomb);
        }
        oci_free_statement($nomproduit);
        //recipient------------------------------------------------------------------------------- 
        $requeteSQL1 = 'SELECT * from contientrecipient where idpanier = :idc';
        $nomR = oci_parse($connect, $requeteSQL1);
        oci_bind_by_name($nomR, ":idc", $idp);
        $resultat = oci_execute($nomR);
        while (($container1 = oci_fetch_assoc($nomR)) != false) {
          $qtu = htmlentities($container1['QUANTITEUNITAIRE']);
          $idr = $container1['IDR'];
          //Table Recipient---------------------------------------------------------------------------------------------------------
          $requeteSQL2 = "SELECT * FROM RECIPIENT WHERE IDR=:idr";
          $nomb = oci_parse($connect, $requeteSQL2);
          oci_bind_by_name($nomb, ':idr', $idr);
          $res = oci_execute($nomb);
          while (($container2 = oci_fetch_assoc($nomb)) != false) {
            $idRecip = htmlentities($container2['IDR']);
            $nameC = htmlentities($container2['NOMR']);
            $datailC = htmlentities($container2['DESCRIPTIONR']);
            if ($container2['PROMO'] != null) { //gestion de la promo
              $prix = str_replace(',', '.', htmlentities($container2['PRIXUNITAIRE']));
              $prixU = $prix - ($prix * $container2['PROMO']);
            } else {
              $prixU = str_replace(',', '.', htmlentities($container2['PRIXUNITAIRE']));}          
            $couleur = htmlentities($container2['COULEURR']);
          } $prixTotal = $prixU * $qtu;
          echo  '
                    <div class="cont">
                      <div class="bonbon">
                        <img id="bonbon" src="include/images/R0' . $idRecip . '.jpg" alt="img recipient"> </div>
                      <div class="infop" style="width: 15%;">       
                        <h2>' . $nameC . '</h2>
                        <p>' . $datailC . '</p> </div>
                      <div class="infop">       
                        <h2>Couleur :</h2>
                        <p>' . $couleur . '</p></div>
                      <div class="prixun">
                        <h2>Prix unitaire :</h2>
                        <p>' . $prixU . '€</p></div>
                      <div class="quant">
                        <h2>Quantité :</h2>
                        <p>' . $qtu . '</p></div>
                      <div class="prix">
                        <h2>Prix total :</h2>
                        <p>' . $prixTotal . ' €</p>
                      </div> 
                      <div class="imgP">
                        <a href="include/supprimerRecipient.php?idr=' . $idRecip . '"><button class="boutonS" style="color: RED;"><b>Supprimer</b></button></a>
                      </div> 
                    </div><hr>
                    ';
          oci_free_statement($nomb);
        }
        oci_free_statement($nomR);
        //recipient-------------------------------------------------------------------------------
        ?>
        <?php if ($nba != 0) {
        
          echo "   <form class='complement' method='POST' action='include/traitPanier.php'>

          <input class='submit' type='submit' name='Abpanier' value='Abandonner le panier' />
        </form>
        <button class='boutonV'><a href='./choixP.php?acces=CB'>Valider</a></button>";
        } else {
          echo "<button class='ContinuerAchats'><a href='./Nouveaute.php'>Continuer mes achats</a></button>";
        } ?>
      </div>
    </div>
    </div>
  </main>
  <?php include("include/footer.php"); ?>
</body>

</html>