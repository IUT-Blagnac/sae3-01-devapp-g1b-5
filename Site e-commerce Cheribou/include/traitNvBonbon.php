<?php
session_start();
if(!empty($_POST['Idc']) && !empty($_POST['kg']) && !empty($_POST['couleur']) && !empty($_POST['format']) && !empty($_POST['ing']) && !empty($_POST['nomb']) && !empty($_POST['describ']) && !empty($_POST['prefali']) && !empty($_POST['marqueb']) && !empty($_POST['goutb']) && !empty($_POST['poidkg']) && !empty($_POST['prixuni'])){#si tout les champs sont saisis
  #regex
  $regexN = "#[0-9]#";
  $regexL = "#[a-z]#";
  $regexAlimentaire = "";
  $regexFormat = "#Grand-sachet|Petit-sachet#";
 
  if(preg_match($regexN,$_POST['kg']) == True && preg_match($regexL,$_POST['couleur']) == True && preg_match($regexL,$_POST['format']) == True &&
   preg_match($regexL,$_POST['ing']) == True && preg_match($regexL,$_POST['nomb']) == True && preg_match($regexL,$_POST['describ']) == True && preg_match($regexL,$_POST['prefali']) == True && preg_match($regexL,$_POST['marqueb']) == True &&preg_match($regexL,$_POST['goutb']) == True && preg_match($regexN,$_POST['poidkg']) == True && preg_match($regexN,$_POST['prixuni']) == True && preg_match($regexFormat,$_POST['format']) == True   ){ 
    #si les champs sont correctement remplis
    require_once('./Connect.inc.php');
    $req = "INSERT INTO BONBONS (IDB,IDCATEGORIE,PRIXKG,COULEURB,FORMAT,INGREDIENT,NOMB,DESCRIPTIONB,PREFERENCEALIMENTAIRE,MARQUE,GOUT,POIDS,PRIXUNITAIRE,PROMO) VALUES(SEQ_BONBON_IDB.nextval, :idc,  : prixkgc ,  : couleur, : formatb,  : ingb,  : nom,  : describ,  : preali, : marqueb, : goutb,  : poidb,  : prixunib, null)";
    $requete = oci_parse($connect, $req);
    $idca = htmlentities($_POST['Idc']);
    $pkg = htmlentities($_POST['kg']);
    $cb = htmlentities($_POST['couleur']);
    $fb  = htmlentities($_POST['format']);
    $ingre = htmlentities($_POST['ing']);
    $nb = htmlentities($_POST['nomb']);
    $db = htmlentities($_POST['describ']);
    $pa = htmlentities($_POST['prefali']);
    $mb = htmlentities($_POST['marqueb']);
    $gb = htmlentities($_POST['goutb']);
    $pb = htmlentities($_POST['poidkg']);
    $pub = htmlentities($_POST['prixuni']);
    oci_bind_by_name($requete, ":idc", $idca);
    oci_bind_by_name($requete, ":prixkgc", $pkg);
    oci_bind_by_name($requete, ":couleur", $cb);
    oci_bind_by_name($requete, ":formatb", $fb);
    oci_bind_by_name($requete, ":ingb", $ingre);
    oci_bind_by_name($requete, ":nom", $nb);
    oci_bind_by_name($requete, ":describ", $db);
    oci_bind_by_name($requete, ":preali", $pa);
    oci_bind_by_name($requete, ":marqueb", $mb);
    oci_bind_by_name($requete, ":goutb", $gb);
    oci_bind_by_name($requete, ":poidb", $pb);
    oci_bind_by_name($requete, ":prixunib", $pub);
    oci_execute($requete);
    oci_commit($connect);
    oci_free_statement($requete);
     echo "<script language='Javascript' type='text/javascript'>
    alert('Bonbon bien ajoute'); location.href='../admin.php';</script>";
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