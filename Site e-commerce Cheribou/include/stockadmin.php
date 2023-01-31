<?php if (isset($_POST['valider'])) {
$value2 = htmlentities($_POST['qte']);
    if($value2 <= 0){
     echo "<script language='Javascript' type='text/javascript'>
    alert('Erreur: quantite a ajouter inférieur ou egal a 0'); location.href='../admin.php';</script>";
    }else {
      require_once('./Connect.inc.php');
      error_reporting(0);
      #on met en place la requ�te SQL pour r�cup�rer toutes les infos d'un client par rapport � l'adresse mail saisie
      $req = "UPDATE CATEGORIEB SET STOCKB = :qte WHERE idCategorie = :idCategorie";
      $requete = oci_parse($connect, $req);
      $value = htmlentities($_POST['idca']);
      oci_bind_by_name($requete, ":idCategorie", $value);
      oci_bind_by_name($requete, ":qte", $value2);
      $result = oci_execute($requete);
      oci_commit($connect);
      oci_free_statement($requete);
      echo "<script language='Javascript' type='text/javascript'>
  alert('Le stock a bien ete mis à jour'); location.href='../admin.php';</script>";
}
}
?>