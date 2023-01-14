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
          //Table Bonbons---------------------------------------------------------------------------------------------------------
          $req2 = "SELECT * FROM BONBONS WHERE IDB=:idb";
          $nomb = oci_parse($connect, $req2);
          oci_bind_by_name($nomb, ':idb', $container['IDB']);
          $res = oci_execute($nomb);
          while (($container2 = oci_fetch_assoc($nomb)) != false) {
            $idbonbon = htmlentities($container2['IDB']);
            $nameC = htmlentities($container2['NOMB']);
            $datailC = htmlentities($container2['DESCRIPTIONB']);
            $prixU = str_replace(',', '.', htmlentities($container2['PRIXUNITAIRE']));
            $format = htmlentities($container2['FORMAT']);
          }
          oci_free_statement($nomb);
          //------------------------------------------------------------fonction PrixTotal-----------------------------------------------------------------------------
          /* $sq = "begin :retour := prixtotalcommande.prixtotal(:idc); end;";
                    // $req = " begin :retour := Gestion_Rugby.retournePointsMarques(:pNe); end; ";
                    $appelFunct = oci_parse($connect, $sq);
                    oci_bind_by_name($appelFunct, ':idc', $idp);
                    oci_bind_by_name($appelFunct, ':retour', $retour, 40);
                    $prixTotal = oci_execute($appelFunct);
                    oci_free_statement($appelFunct);*/
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
                        <p>' . $prixU . '€</p>
                      </div>
                      <div class="quant">
                        <h2>Quantité :</h2>
                        <p>' . $qkg . '</p>
                      </div>
                      <div class="prix">
                        <h2>Prix total :</h2>
                        <p>' . $prixTotal . ' €</p>
                      </div> 
                      <a href="include/supprimerbonbon.php?idb=' . $idbonbon . '"><button class="boutonS" style="color: RED;"><b>Supprimer</b></button></a>
                    </div><hr>
                    ';
        }
        //recipient------------------------------------------------------------------------------- //recipient-------------------------------------------------------------------------------
        //recipient------------------------------------------------------------------------------- //recipient-------------------------------------------------------------------------------
        //recipient------------------------------------------------------------------------------- //recipient-------------------------------------------------------------------------------
        //recipient------------------------------------------------------------------------------- //recipient------------------------------------------------------------------------------- //recipient-------------------------------------------------------------------------------
        //recipient------------------------------------------------------------------------------- //recipient------------------------------------------------------------------------------- //recipient-------------------------------------------------------------------------------

        $requeteSQL1 = 'SELECT * from contientrecipient where idpanier = :idc';
        $nomR = oci_parse($connect, $requeteSQL1);
        oci_bind_by_name($nomR, ":idc", $idp);
        $resultat = oci_execute($nomR);
        while (($container1 = oci_fetch_assoc($nomR)) != false) {
          $qkg = htmlentities($container1['QUANTITEUNITAIRE']);
          //Table Recipient---------------------------------------------------------------------------------------------------------
          $requeteSQL2 = "SELECT * FROM RECIPIENT WHERE IDR=:idr";
          $nomb = oci_parse($connect, $requeteSQL2);
          oci_bind_by_name($nomb, ':idr', $container1['IDR']);
          $res = oci_execute($nomb);
          while (($container2 = oci_fetch_assoc($nomb)) != false) {
            $idRecip = htmlentities($container2['IDR']);
            $nameC = htmlentities($container2['NOMR']);
            $datailC = htmlentities($container2['DESCRIPTIONR']);
            $prixU = str_replace(',', '.', htmlentities($container2['PRIXUNITAIRE']));
            $couleur = htmlentities($container2['COULEURR']);
          }
          oci_free_statement($nomb);

          $prixTotal = $prixU * $qkg;

          echo  '
                    <div class="cont">
                      <div class="bonbon">
                        <img id="bonbon" src="include/images/R0' . $idRecip . '.jpg" alt="img recipient">
                      </div>
                      <div class="infop">       
                        <h2>' . $nameC . '</h2>
                        <p>' . $datailC . '</p>
                      </div>
                      <div class="infop">       
                        <h2>Couleur :</h2>
                        <p>' . $couleur . '</p>
                      </div>
                      <div class="prixun">
                        <h2>Prix unitaire :</h2>
                        <p>' . $prixU . '€</p>
                      </div>
                      <div class="quant">
                        <h2>Quantité :</h2>
                        <p>' . $qkg . '</p>
                      </div>
                      <div class="prix">
                        <h2>Prix total :</h2>
                        <p>' . $prixTotal . ' €</p>
                      </div> 
                      <a href="include/supprimerRecipient.php?idr=' . $idRecip . '"><button class="boutonS" style="color: RED;"><b>Supprimer</b></button></a>
                    </div><hr>
                    ';
        }

        oci_free_statement($nomproduit);
        //recipient-------------------------------------------------------------------------------
        ?>
        <form class='complement' method='POST' action='abP.php'>
          <input class="boutonV" type="submit" name="Val" value="valider">
          <input class='submit' type='submit' name='panier' value='Abandonner le panier' />
        </form>
      </div>
    </div>
    </div>
  </main>
  <?php include("include/footer.php"); ?>
</body>

</html>