<?php

if (!isset($_SESSION)) {
        session_start();
}

if($_SESSION['access'] != "oui"){
  echo "<script language='Javascript' type='text/javascript'>
  alert('Erreur: Vous devez être connecté'); location.href='Compte.php?acces=login';</script>";
}
else{
  require_once('include/Connect.inc.php');
  $panier = $_SESSION['IDC'];
  $idRECIP = $_SESSION['recipPanier'];
  $qte = $_POST['qteAchoisir'];
  
      $req6 = "INSERT INTO CONTIENTRECIPIENT VALUES (:recip, :pa, :qte)";
      $requete6 = oci_parse($connect, $req6);
      oci_bind_by_name($requete6, ":recip", $idRECIP);
      oci_bind_by_name($requete6, ":pa", $panier);
      oci_bind_by_name($requete6, ":qte", $qte);
      $result1 = oci_execute($requete6);
      oci_commit($connect);
      oci_free_statement($requete6);
      
  header('location: panier.php');
}
?>

