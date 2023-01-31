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
  
  require_once('include/Connect.inc.php');
  $req7 = "SELECT * FROM CONTIENTRECIPIENT WHERE IDPANIER = :panier AND IDR = :id";
  $requete7 = oci_parse($connect, $req7);
  oci_bind_by_name($requete7, ":panier", $panier);
  oci_bind_by_name($requete7, ":id", $idRECIP);
  $result2 = oci_execute($requete7);
  $container = oci_fetch_assoc($requete7);
  if($container != ""){ 
      $qteKG = $qte + $container['QUANTITEUNITAIRE'];
      $req8 = "UPDATE CONTIENTRECIPIENT SET QUANTITEUNITAIRE = :kg WHERE IDR = :idr";
      $requete8 = oci_parse($connect, $req8);
      oci_bind_by_name($requete8, ":kg", $qteKG);
      oci_bind_by_name($requete8, ":idr", $idRECIP);
      $result1 = oci_execute($requete8); 
      oci_commit($connect);
      oci_free_statement($requete8);
  }
  else{
      $req6 = "INSERT INTO CONTIENTRECIPIENT VALUES (:recip, :pa, :qte)";
      $requete6 = oci_parse($connect, $req6);
      oci_bind_by_name($requete6, ":recip", $idRECIP);
      oci_bind_by_name($requete6, ":pa", $panier);
      oci_bind_by_name($requete6, ":qte", $qte);
      $result1 = oci_execute($requete6);
      oci_commit($connect);
      oci_free_statement($requete6);
  }
  oci_free_statement($requete7);   
  header('location: panier.php');
}
?>

