<?php

if (!isset($_SESSION)) {
        session_start();
}

if($_SESSION['access'] != "oui"){
  echo "<script language='Javascript' type='text/javascript'>
  alert('Erreur: Vous devez être connecté'); location.href='Compte.php?acces=login';</script>";
}
else{
  $panier = $_SESSION['IDC'];
  $idBONBON = $_SESSION['bonbonsPanier'];
  $qte = $_POST['qteAchoisir'];
  
  require_once('include/Connect.inc.php');
  $req7 = "SELECT * FROM CONTIENTBONBON WHERE IDPANIER = :panier AND IDB = :id AND FIDELITE IS NULL";
  $requete7 = oci_parse($connect, $req7);
  oci_bind_by_name($requete7, ":panier", $panier);
  oci_bind_by_name($requete7, ":id", $idBONBON);
  $result2 = oci_execute($requete7);
  $container = oci_fetch_assoc($requete7);
  if($container != ""){ 
      $qteKG = $qte + $container['QUANTITEKG'];
      $req8 = "UPDATE CONTIENTBONBON SET QUANTITEKG = :kg WHERE IDB = :idb AND FIDELITE IS NULL";
      $requete8 = oci_parse($connect, $req8);
      oci_bind_by_name($requete8, ":kg", $qteKG);
      oci_bind_by_name($requete8, ":idb", $idBONBON);
      $result1 = oci_execute($requete8); 
      oci_commit($connect);
      oci_free_statement($requete8);
  }
  else{
      $req6 = "INSERT INTO CONTIENTBONBON VALUES (:pa, :bonbon, :qte, :fi)";
      $fi = null;
      $requete6 = oci_parse($connect, $req6);
      oci_bind_by_name($requete6, ":pa", $panier);
      oci_bind_by_name($requete6, ":bonbon", $idBONBON);
      oci_bind_by_name($requete6, ":qte", $qte);
      oci_bind_by_name($requete6, ":fi", $fi);
      $result1 = oci_execute($requete6);
      #if (!$result1) {
		    #$e = oci_error($requete6);  // on récupère l'exception liée au pb d'execution de la requete 
		    #echo "<script language='Javascript' type='text/javascript'>
        #alert('".htmlentities($e['message'])."'); 
        #location.href='panier.php';</script>";
	    #}
      oci_commit($connect);
      oci_free_statement($requete6);
      
  }
  oci_free_statement($requete7);
  header('location: panier.php');
}
      

?>

