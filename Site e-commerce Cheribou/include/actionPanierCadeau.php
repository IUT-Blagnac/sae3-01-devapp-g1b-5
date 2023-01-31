<?php
  if (!isset($_SESSION)) {
    session_start();
  }
  
  require_once('./Connect.inc.php'); #suivant l'id du bonbon, on retire une valeur différente des pts de fidélité
  $idb = $_GET['id'];
  if($idb == 83){
    $pts = 25;
  }elseif($idb == 20){
    $pts = 50;
  }elseif($idb == 29){
    $pts = 100;
  }elseif($idb == 21){
    $pts = 200;
  }
  #on met à jour les points de fidélité pour le client
  $req = "UPDATE Client SET PTSFIDELITE = :pts WHERE IDCLIENT = :idc";
  $requete = oci_parse($connect, $req);
  $idc = $_SESSION['IDC'];
  $points = $_GET['points'] - $pts;
  oci_bind_by_name($requete, ":pts", $points);
  oci_bind_by_name($requete, ":idc", $idc);
  $result = oci_execute($requete);
  oci_commit($connect);
  oci_free_statement($requete);

//-------------------------------------------------------------------------------------------
/*----------------------------Pour l'instant les seuls cadeaux sont des bonbons donc on ne gère pas l'insert dans contient recipient*/
//-------------------------------------------------------------------------------------------

  #on ajoute au panier le bonbon
  $req7 = "SELECT * FROM CONTIENTBONBON WHERE IDPANIER = :panier AND IDB = :id AND FIDELITE IS NOT NULL";
  $requete7 = oci_parse($connect, $req7);
  oci_bind_by_name($requete7, ":panier", $idc);
  oci_bind_by_name($requete7, ":id", $idb);
  $result2 = oci_execute($requete7);
  $container = oci_fetch_assoc($requete7);
  if($container != ""){  #si le produit est déjà dans un panier on augmente la quantité
      $qteKG = 1 + $container['QUANTITEKG'];
      $req8 = "UPDATE CONTIENTBONBON SET QUANTITEKG = :kg WHERE IDB = :idb AND FIDELITE IS NOT NULL";
      $requete8 = oci_parse($connect, $req8);
      oci_bind_by_name($requete8, ":kg", $qteKG);
      oci_bind_by_name($requete8, ":idb", $idb);
      $result1 = oci_execute($requete8); 
      oci_commit($connect);
      oci_free_statement($requete8);
  }
  else{ #sinon on l'ajoute tout cour
      $req6 = "INSERT INTO CONTIENTBONBON VALUES (:pa, :bonbon, :qte, :fi)";
      $nb = 1;
      $fi = 'oui';
      $requete6 = oci_parse($connect, $req6);
      oci_bind_by_name($requete6, ":pa", $idc);
      oci_bind_by_name($requete6, ":bonbon", $idb);
      oci_bind_by_name($requete6, ":qte", $nb);
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
  
  header("location: ../panier.php");
?>