<?php
session_start();
if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['tel'])){#si tout les champs sont saisis
  #regex
  $regexNom = "#[^0-9]#i";
  $regexPrenom = "#[^0-9]#i";
  $regexTel = "#^(?:\+33\s|0)[1-9](?:\s\d{2}){4}$#";
  $regexMail = "#^[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-z]{2,3}#i";
  if(preg_match($regexNom,$_POST['nom']) == True && preg_match($regexPrenom,$_POST['prenom']) == True &&
   preg_match($regexTel,$_POST['tel']) == True && preg_match($regexMail,$_POST['mail']) == True){ 
    #si les champs sont correctement remplis
    require_once('./Connect.inc.php');
    error_reporting(0);
    $req = "UPDATE Client SET nomC = :newNom, prenomC = :newPrenom, adresseMail = :newMail, telPortableC = :newTel WHERE adresseMail = :mail"; #on modifie dans la BD
    $requete = oci_parse($connect, $req);
    $nom = htmlentities($_POST['nom']);
    $prenom = htmlentities($_POST['prenom']);
    $mail = htmlentities($_POST['mail']);
    $tel = htmlentities($_POST['tel']);
    $ancienMail = $_GET['ancienMail'];
    oci_bind_by_name($requete, ":newNom", $nom);
    oci_bind_by_name($requete, ":newPrenom", $prenom);
    oci_bind_by_name($requete, ":newMail", $mail);
    oci_bind_by_name($requete, ":newTel", $tel);
    oci_bind_by_name($requete, ":mail", $ancienMail);
    $result = oci_execute($requete);
    oci_free_statement($requete);
    $_SESSION['nom'] = $mail;
    header("location: ..\index.php");
  }
  else{
    echo "<script language='Javascript' type='text/javascript'>
    alert('Erreur: Vous avez mal écris vos informations !'); location.href='../index.php';</script>";
  }
}
else{
  echo "<script language='Javascript' type='text/javascript'>
  alert('Erreur: Vous devez remplir tous les champs !'); location.href='../index.php';</script>";
}
?>