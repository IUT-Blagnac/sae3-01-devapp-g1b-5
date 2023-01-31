<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="include/choixP.css">
    <title>Paiement</title>
</head>

<body>
    <?php
    include("include/header.php");
    ?>
    <div class="principal">
    <div class="info">
      <div class="links">
        <h2>Choisir un mode de paiement :</h2>
        <a href="?acces=CB" <?php
                            if (isset($_GET['acces'])) {
                                if ($_GET['acces'] == 'CB') {
                                    echo ' id="CB" ';
                                }
                            } ?>> CB </a>
        <a href="?acces=Paypal" <?php if (isset($_GET['acces'])) {
                                    if ($_GET['acces'] == 'Paypal') {
                                        echo 'id="Paypal"';
                                    }
                                } ?>> Paypal </a>
      </div>

      <div class="body">
        <?php
        require_once("include/Connect.inc.php");


        /*Nombre d'article */
        $req = "SELECT * FROM panier where idpanier=:idc";
        $appelFunctStock = oci_parse($connect, $req);
        $idc = $_SESSION['IDC'];
        oci_bind_by_name($appelFunctStock, ':idc', $idc);
        $result = oci_execute($appelFunctStock);
        $panier = oci_fetch_assoc($appelFunctStock);
        $nba = htmlentities($panier['NBPRODUIT']);


        if (isset($_GET['acces'])) {
            if ($_GET['acces'] == 'CB') {
                echo  ' <section>  
            <div class="container"><br></br>
            <h4>Paiement</h4>
        <hr>
       <form action="include/traitFormPaiement.php" method="post">
                   <div class="name-field">
                    <div>
                        <strong> <label>Numéro de CB*</label></strong>
                        <input type="text" name="num" />
                    </div>
                    <div>
                        <strong><label>Nom du propriétaire*</label></strong>
                        <input type="text" name="nom" />
                    </div>
                   </div>
                   <div class="name-field">
                    <div>
                        <strong> <label>CVV*</label></strong>
                        <input type="text" name="CVV">
                    </div>
                    <div>
                        <strong><label>Date* </label></strong>
                        <input type="text" name="Date" />
                    </div>
                   </div>
                   <div>
                        <strong><label>Adresse de livraison*</label></strong>
                         <input type="text" name="adr"/>
                   </div>
                <div>
                    <button id="valider" type="submit" name="validerCB">Valider</button>
                </div>
            </form>
        </div>
    </section>
    <section>  
</form>
</section></div> 
';#fin body
            } elseif ($_GET['acces'] == 'Paypal') {
                echo '<section>
             <div class="container"><br></br>
            <h4>Paiement</h4>
            <hr>
                <form action="include/traitFormPaiement.php"  method="post">
               
                 <div>
                 <strong> <label>Adresse e-mail*</label></strong>
                <input type="mail" name="mail" />
            </div>
            <div>
                <strong><label>Adresse de livraison*</label></strong>
                <input type="text" name="adr" />
            </div>
           <div>
                <button id="valider" type="submit" name="validerPaypal">Valider</button>
            </div>
        
        </section></div> ';
            }#fin body
        } ?> 
      </div> 
      <div class="global">
        <section>
            <div class="total">
                <h4>Récapitulatif:</h4>
                <hr>

                <h4><?php echo $nba;
                    if ($nba > 1) {

                        echo " articles";
                    } else {

                        echo " article";
                    } ?> </h4>
                <h4>Nom
                    </hr>Prix Quantité
                    <br></br>
                </h4>
                <?php $req1 = 'SELECT * from contientbonbon where idpanier = :idc';
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

                        if ($container2['PROMO'] != null) {
                            $prix = str_replace(',', '.', htmlentities($container2['PRIXUNITAIRE']));
                            $prixU = $prix - ($prix * $container2['PROMO']);
                        } else {
                            $prixU = str_replace(',', '.', htmlentities($container2['PRIXUNITAIRE']));
                        }

                        if ($container['FIDELITE'] == 'oui') {
                            $prixU = 0;
                        }

                        echo " <p> $nameC  -   $prixU €  -  $qkg </p>";
                    }
                    oci_free_statement($nomb);
                }
                oci_free_statement($nomproduit);



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
                        if ($container2['PROMO'] != null) { //gestion de la promo
                            $prix = str_replace(',', '.', htmlentities($container2['PRIXUNITAIRE']));
                            $prixU = $prix - ($prix * $container2['PROMO']);
                        } else {
                            $prixU = str_replace(',', '.', htmlentities($container2['PRIXUNITAIRE']));
                        }
                        $couleur = htmlentities($container2['COULEURR']);
                    }
                    echo  " <p> $nameC  -   $prixU €  -  $qtu </p>";
                    oci_free_statement($nomb);
                }
                echo "<br></br>";
                oci_free_statement($nomR);
                ?>
                
                <br></br>
                <hr>
                <?php
                $sq = "begin :retour:=prixtotalcommande.prixtotal(:id); end;";
                $Appelprix = oci_parse($connect, $sq);

                oci_bind_by_name($Appelprix, ':id', $idc);
                oci_bind_by_name($Appelprix, ':retour', $prixTotal, 60);
                oci_execute($Appelprix);
                echo "<h4> Prix total: $prixTotal €</h4>";
                oci_free_statement($Appelprix);
                ?>
            </div>
          </div>
        </section>
  </div>
<?php include("include/footer.php"); ?>
</body>

</html>