<!DOCTYPE html>
<html lang="fr">


<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="include\admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" />
  <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
  <title>Admin</title>

</head>

<body>
  <header> <?php include("include/headeradmin.php"); ?>
  </header>
  <?php
  if (!isset($_SESSION)) {
    session_start();
  }
  if ($_SESSION['admin'] != "oui") { #si la variable session est différent de oui
    echo "<script language='Javascript' type='text/javascript'>
      alert('Erreur: vous devez être connecté en administrateur !'); location.href='Compte.php?acces=login';</script>";
    exit();
  }
  ?>

  <section>
    <div>
      <?php
      if (isset($_GET['Tab'])) {
        $valeur = $_GET['Tab'];
        if ($valeur == 'RajouterStock') {


          require_once('include/Connect.inc.php');
          $req = "SELECT * from categorieb";
          $requete = oci_parse($connect, $req);
          $result = oci_execute($requete);
          $select = '<select name="idca" id="idca" required>';
          while (($row = oci_fetch_array($requete, OCI_BOTH)) != false) {
            $select .= "<option value='" . $row['IDCATEGORIE'] . "'>" . $row['NOMCATEGORIE'] . " :" . $row['IDCATEGORIE'] . "</option>";
          }
          $select .= "</select>";
          oci_free_statement($requete);



          echo ' <form id="RajouterStock" method="POST" action = "include/stockadmin.php">';
          echo '<h4>Modifier Stock bonbon</h4>';
          echo ' <hr>';
          echo '<label for="idCategorie"><b>idCategorie</b></label>';
          echo $select;
          echo '<label for="qte"><b>Nombre</b></label>';
          echo '<input type="number" name="qte" />';
          echo '<button name="valider" type="submit" id="valider">Valider</button>';
          echo '</form>';



          require_once('include/Connect.inc.php');
          $req2 = "SELECT * from recipient";
          $requete2 = oci_parse($connect, $req2);
          $result2 = oci_execute($requete2);
          $select2 = '<select name="idr" id="idr" required>';
          while (($row2 = oci_fetch_array($requete2, OCI_BOTH)) != false) {
            $select2 .= "<option value='" . $row2['IDR'] . "'>" . $row2['NOMR'] . " :" . $row2['IDR'] . "</option>";
          }
          $select2 .= "</select>";
          oci_free_statement($requete2);





          echo ' <form id="RajouterStockRecip" method="POST" action = "include/stockadminrecip.php">';
          echo '<h4>Modifier Stock recipient</h4>';
          echo '<hr>';
          echo ' <label for="idRecip"><b>idRecip</b></label>';
          echo $select2;
          echo '<label for="qteU"><b>Nombre</b></label>';
          echo '<input type="number" name="qteU" />';
          echo '<button name="valider" type="submit" id="valider">Valider</button>';
          echo '</form>';
        } elseif ($valeur == 'GérerProduit') {
          echo '
                 <form id="za" method="post"  action = "produitadmin.php">
                 <h2>Que voulez-vous modifier?</h2>
                <div class="ctn">
                <div class="fle">
                <input type="submit" name="buttonB"
                 class="buttonad" value=" Bonbons " />
                </div>
                <div class="fle">
                <input type="submit" name="buttonR"
                 class="buttonad" value=" Récipients " />
                </div>
                 <div class="fle">
                <input type="submit" name="buttonG"
                 class="buttonad" value=" Catégories bonbons " />
                </div>
                </div></form>';
        } elseif ($valeur == 'Commandes') {

          require_once('include/Connect.inc.php');
          $req3 = "SELECT idclient, nomc from client";
          $requete3 = oci_parse($connect, $req3);
          $result3 = oci_execute($requete3);
          $select3 = '<select name="idc" id="idc" required>';
          while (($row3 = oci_fetch_array($requete3, OCI_BOTH)) != false) {
            $select3 .= "<option value='" . $row3['IDCLIENT'] . "'>" . "Id client : " . $row3['IDCLIENT'] . " ,nom client : " . $row3['NOMC'] . "</option>";
          }
          $select3 .= "</select>";
          oci_free_statement($requete3);



          echo ' <form id="formuclient" method="POST" action = "include/traitAdminCo.php">';
          echo "<h4>Consulter les commandes d'un client</h4>";
          echo '<hr>';
          echo ' <label for="idClient"><b>id Client</b></label>';
          echo $select3;
          echo '<button name="valid" type="submit" id="valid">Valider</button>';
          echo '</form>';
        }
      } else {
        echo "<h3>Administration Cheribou<BR></h3><br>";
        echo " <ul>
            <li>Rajouter stock : Gestion des stocks</li><br>
            <li>Gérer produit : Gestion des produits proposés</li><br>
            <li>Commandes : Consultation des commandes des clients</li>
            </ul>";
      }













      ?>



    </div>
  </section>

</body>

</html>