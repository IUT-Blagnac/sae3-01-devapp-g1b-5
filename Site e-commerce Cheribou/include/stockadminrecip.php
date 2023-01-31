<?php if (isset($_POST['valider'])) {
$value2 = htmlentities($_POST['qteU']);
   if($value2 <= 0){
   echo "<script language='Javascript' type='text/javascript'>
  alert('Erreur: quantite a ajouter inférieur ou egal a 0'); location.href='../admin.php';</script>";
  }else {
      require_once('./Connect.inc.php');
      error_reporting(0);
      $req = "UPDATE RECIPIENT SET STOCK = :qte WHERE idr = :idr";
      $requete = oci_parse($connect, $req);
      $value = htmlentities($_POST['idr']);
      oci_bind_by_name($requete, ":idr", $value);
      oci_bind_by_name($requete, ":qte", $value2);
      $result = oci_execute($requete);
      oci_commit($connect);
      oci_free_statement($requete);
      echo "<script language='Javascript' type='text/javascript'>
  alert('Le stock a bien ete mis a jour'); location.href='../admin.php';</script>";
}
}

?>



