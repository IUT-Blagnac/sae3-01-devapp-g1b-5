
<?php
session_start();
require_once("./Connect.inc.php");

if (isset($_GET["idb"])) {
    $id = htmlentities($_GET['idb']);
    
    //gestion si pts de fidélité : on les rajoute sur le compte
    
    switch($id){
      case 83:
        $point = 25;
        break;
      case 20:
        $point = 50;
        break;
      case 29:
        $point = 100;
        break;
      case 21:
        $point = 200;
        break;
    }
    
    $req3 = "SELECT * FROM contientBonbon WHERE IDB = :idB AND IDPANIER = :pa"; #on récup la quantité de bonbon pris par les pts de fidélité
    $requete3 = oci_parse($connect, $req3);
    $Login = $_SESSION['IDC'];
    oci_bind_by_name($requete3, ":idB", $id);
    oci_bind_by_name($requete3, ":pa", $Login);
    $result = oci_execute($requete3);
    while (($container = oci_fetch_assoc($requete3)) != false) {
      $nb = $container['QUANTITEKG'];
      $fi = $container['FIDELITE'];
    }
    oci_free_statement($requete3);
    if($fi != null){
      $req2 = "SELECT * FROM Client WHERE IDCLIENT = :pid"; #on récup les pts déjà présent sur le compte
      $requete2 = oci_parse($connect, $req2);
      oci_bind_by_name($requete2, ":pid", $Login);
      $result = oci_execute($requete2);
      while (($container = oci_fetch_assoc($requete2)) != false) {
    
        $pts = "UPDATE Client SET PTSFIDELITE = :point WHERE IDCLIENT = :idc";
        $ptsFinal = $container['PTSFIDELITE'] + $point*$nb; #on rajoute les points correspondant sur le compte
        $req = oci_parse($connect, $pts);
        oci_bind_by_name($req, ':point', $ptsFinal);
        oci_bind_by_name($req, ':idc', $_SESSION['IDC']);
        $result = oci_execute($req);
        oci_commit($connect);
        oci_free_statement($req);
      }
      oci_free_statement($requete2);
    }
    //on supprime simplement l'élément du "panier"
    
    if(isset($_GET['fi'])){
      $sup = "DELETE FROM contientbonbon WHERE idb=:idb AND idpanier= :idp AND FIDELITE IS NOT NULL";
    }else{
      $sup = "DELETE FROM contientbonbon WHERE idb=:idb AND idpanier= :idp";
    }
    
    $req = oci_parse($connect, $sup);
    oci_bind_by_name($req, ':idb', $id);
    oci_bind_by_name($req, ':idp', $_SESSION['IDC']);
    $result = oci_execute($req);
    oci_commit($connect);
    oci_free_statement($req);
    echo "<script language='Javascript' type='text/javascript'>
    alert('Bonbon bien supprimé.'); location.href='../panier.php';</script>";
    exit();
} else {
}
?>