<?php
session_start();
if(isset($_POST['valider']) && isset($_POST['Email']) && $_POST['mdp'] != "" ){ #si le bouton valider est appuyer et que tous les champs sont remplis
  require_once('./Connect.inc.php');
  error_reporting(0);
  #on met en place la requ�te SQL pour r�cup�rer toutes les infos d'un client par rapport � l'adresse mail saisie
  $req = "SELECT * FROM CLIENT WHERE adresseMail = :mail";
  $requete = oci_parse($connect, $req);
  $value = htmlentities($_POST['Email']);
  oci_bind_by_name($requete, ":mail", $value);
  $result = oci_execute($requete);
  $container = oci_fetch_assoc($requete);
  if($container != ""){
    if (password_verify($_POST['mdp'], $container['MOTDEPASSE'])) { 
      #gestion session et cookie --------------------------------------------------------
      $_SESSION['access'] = "oui";
      $_SESSION['nom'] = htmlentities($_POST['Email']);
      $_SESSION['IDC'] = $container['IDCLIENT'];
      if(isset($_POST['souvenir'])){#Si le cookie existe
        $val = htmlentities($_POST['Email']);
			  setcookie('Cook', $val, time()+60);#on cr�er le cookie et on veut mettre la dur�e du cookie � 1min
      }
      
      #redirection ----------------------------------------------------------------------
      header('location: ..\index.php');
      exit();
    }else{#sinon on renvoie le retour � la page de base
		  echo "<script language='Javascript' type='text/javascript'>
      alert('Erreur: Votre mot de passe est incorrect'); location.href='../Compte.php?acces=login';</script>";
		  exit();
    }
  }else{
    echo "<script language='Javascript' type='text/javascript'>
    alert('Erreur: Vos mot de passe ou adresse mail sont incorrectes'); location.href='../Compte.php?acces=login';</script>";
    exit();
  }
  oci_free_statement($requete);
}
?>