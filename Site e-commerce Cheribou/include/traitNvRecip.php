<?php
session_start();
if( !empty($_POST['prixu']) && !empty($_POST['couleur']) && !empty($_POST['nomr']) && !empty($_POST['descrir']) && !empty($_POST['poiduni'])){#si tout les champs sont saisis
  #regex
  $regexN = "#[0-9]#";
  $regexL = "#[a-z]#";
  
 
  if(preg_match($regexN,$_POST['prixu']) == True && preg_match($regexL,$_POST['couleur']) == True && preg_match($regexL,$_POST['nomr']) == True &&
   preg_match($regexL,$_POST['descrir']) == True && preg_match($regexN,$_POST['poiduni']) == True ){ 
    #si les champs sont correctement remplis
    require_once('./Connect.inc.php');
    $req = "INSERT INTO RECIPIENT (IDR,NOMR,DESCRIPTIONR,PRIXUNITAIRE,POIDSUNITAIRE,COULEURR,STOCK,PROMO) VALUES(idrecipient.nextval,  :nr,  : descri , : puni,  : poiduni,  : crr, 0,null)";
    $requete = oci_parse($connect, $req);
    $pru = htmlentities($_POST['prixu']);
    $cb = htmlentities($_POST['couleur']);
    $nr  = htmlentities($_POST['nomr']);
    $dr = htmlentities($_POST['descrir']);
    $poidu = htmlentities($_POST['poiduni']);
    oci_bind_by_name($requete, ":nr", $nr);
    oci_bind_by_name($requete, ":descri", $dr);
    oci_bind_by_name($requete, ":puni", $pru);
    oci_bind_by_name($requete, ":poiduni", $poidu);
    oci_bind_by_name($requete, ":crr", $cb);
    oci_execute($requete);
    oci_commit($connect);
    oci_free_statement($requete);
     echo "<script language='Javascript' type='text/javascript'>
    alert('Recipient bien ajoute !'); location.href='../admin.php';</script>";
  }
  else{
    echo "<script language='Javascript' type='text/javascript'>
    alert('Erreur: Vous avez mal écris vos informations !'); location.href='../admin.php';</script>";
  }
}
else{
  echo "<script language='Javascript' type='text/javascript'>
  alert('Erreur: Vous devez remplir tous les champs !'); location.href='../admin.php';</script>";
}
?>