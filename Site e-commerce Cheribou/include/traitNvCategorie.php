<?php
session_start();
if( !empty($_POST['nomcat']) ){#si tout les champs sont saisis
  #regex

  $regexL = "#[a-z]#";
  
 
  if(preg_match($regexL,$_POST['nomcat']) == True ){ 
    #si les champs sont correctement remplis
    require_once('./Connect.inc.php');
    $req = "INSERT INTO CATEGORIEB (IDCATEGORIE,NOMCATEGORIE,STOCKB) VALUES(idcategorieb.nextval,  :ncat, 0)";
    $requete = oci_parse($connect, $req);
    $nomcate = htmlentities($_POST['nomcat']);
    oci_bind_by_name($requete, ":ncat", $nomcate);
    oci_execute($requete);
    oci_commit($connect);
    oci_free_statement($requete);
     echo "<script language='Javascript' type='text/javascript'>
    alert('Nouvelle categorie bien cree!'); location.href='../admin.php';</script>";
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