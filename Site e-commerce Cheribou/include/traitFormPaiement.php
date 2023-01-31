<?php
session_start();
require_once('Connect.inc.php');
$regexCB = '#^[0-9]{16}$#';
$regexCVV = '#^[0-9]{3}$|^[0-9]{4}$#';
$regexnom = '#^[A-Z]{1}[a-z]{1,15}$#';

if (isset($_POST["validerCB"]) && $_POST["nom"] != "" && $_POST["num"] != "" && $_POST["adr"] != "" && $_POST["Date"] != "" && $_POST["CVV"] != "") { #si tous les champs sont remplis
  if(preg_match($regexCB,$_POST['num']) == True && preg_match($regexCVV,$_POST['CVV']) == True && preg_match($regexnom,$_POST['nom']) == True){ # si les regex sont respectés
  
    //on execute la procédure suivante pour vider panier, transférer dans commande et calculer les pts de fidélités
    $commande = "begin viderpanier(:idp ,'CB'); end;";
    $request = oci_parse($connect, $commande);
    $value = htmlentities($_SESSION['IDC']);
    oci_bind_by_name($request, ':idp', $value);

    $result = oci_execute($request);
    oci_commit($connect);
    oci_free_statement($request);
    
    $req = "SELECT * FROM CLIENT WHERE IDCLIENT = :id";
    $requete = oci_parse($connect, $req);
    oci_bind_by_name($requete, ":id", $value);
    $result = oci_execute($requete);
    $container = oci_fetch_assoc($requete);
    if($container != ""){
      $_SESSION['PTS'] = $container['PTSFIDELITE']; #on modifie la valeur session des pts avec les nouveaux rajoutés après la commande
    }
    oci_free_statement($requete);
    
    echo "<script language='Javascript' type='text/javascript'>
    alert('Merci de vos achats, votre commande a été prise en compte'); location.href='../panier.php';</script>";
    exit();
  }
  else{
    echo "<script language='Javascript' type='text/javascript'>
    alert('Vous devez remplir les champs correctement'); location.href='../choixP.php?acces=CB';</script>";
    exit();
  }
    
} elseif (isset($_POST["validerPaypal"]) && $_POST["mail"] != "" && $_POST["adr"] != "") {#si tous les champs sont remplis
    $commande = "begin viderpanier(:idp ,'Paypal'); end;";
    $request = oci_parse($connect, $commande);
    $value = htmlentities($_SESSION['IDC']);
    oci_bind_by_name($request, ':idp', $value);
    $result = oci_execute($request);
    oci_commit($connect);
    oci_free_statement($request);
    
    $req = "SELECT * FROM CLIENT WHERE IDCLIENT = :id";
    $requete = oci_parse($connect, $req);
    oci_bind_by_name($requete, ":id", $value);
    $result = oci_execute($requete);
    $container = oci_fetch_assoc($requete);
    if($container != ""){
      $_SESSION['PTS'] = $container['PTSFIDELITE']; #on modifie la valeur session des pts avec les nouveaux rajoutés après la commande
    }
    oci_free_statement($requete);
    
    echo "<script language='Javascript' type='text/javascript'>
    alert('Merci de vos achats, votre commande a été prise en compte'); location.href='../panier.php';</script>";
    exit();
} else {
  echo "<script language='Javascript' type='text/javascript'>
  alert('Erreur : Vous devez remplir tous les champs '); location.href='../choixP.php?acces=CB';</script>";
  exit();
}
?>
