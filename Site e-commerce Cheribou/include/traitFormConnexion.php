<?php
session_start();
if(isset($_POST['valider']) && isset($_POST['Email']) && $_POST['mdp'] != "" && $_POST['confi'] != ""){ #si le bouton valider est appuyer et que tous les champs sont remplis
  
    if ($_POST['Email'] == 'admin@gmail.com' && $_POST['mdp']== 'ADMIN'){
      $_SESSION['access'] = "oui";
      $_SESSION['admin']="oui";
      $_SESSION['nom'] = htmlentities($_POST['Email']);
      $_SESSION['IDC'] = $container['IDCLIENT'];
  		header('location: ..\admin.php');
 	  }
    require_once('./Connect.inc.php');
    error_reporting(0);
    #on met en place la requète SQL pour récupérer toutes les infos d'un client par rapport à l'adresse mail saisie
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
        $_SESSION['PTS'] = $container['PTSFIDELITE'];
      
        #redirection ----------------------------------------------------------------------
        header('location: ..\index.php');
        exit();
      }else{#sinon on renvoie le retour à la page de base
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
else {
  echo "<script language='Javascript' type='text/javascript'>
  alert('Erreur : Vous devez remplir tous les champs et accepter la politique de confidentialité'); location.href='../Compte.php?acces=login';</script>";
  exit();
}
?>