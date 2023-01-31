<?php
session_start();

if (isset($_POST['valider'])) {
  $regexNom = "#[\sa-zA-Záâäôèéêëçîïûü-]$#i";
  $regexPrenom = "#[\sa-zA-Záâäôèéêëçîïûü-]$#i";

  # si tout les champs sont remplis

  if ($_POST['prenom'] != "" && $_POST['nom'] != "" && $_POST['email'] != "" && $_POST['email2'] != "" && $_POST['mdp'] != "" && $_POST['mdp2'] != "" && $_POST['confi'] != "") {
    if(preg_match($regexNom,$_POST['nom']) == True && preg_match($regexPrenom,$_POST['prenom']) == True){
    
      $mail = htmlentities($_POST['email']);
      $nom = htmlentities($_POST['nom']);
      $prenom = htmlentities($_POST['prenom']);
    
      # Gestion si email existe déjà dans la BD
      require_once('./Connect.inc.php');
      $req1 = 'SELECT * FROM CLIENT';
      $requete1 = oci_parse($connect, $req1);
      $result1 = oci_execute($requete1);
      while (($container2 = oci_fetch_assoc($requete1)) != false) {

        if($container2['ADRESSEMAIL'] == $mail){ #si il existe déjà

          #on affiche un message d'erreur et on redirige vers la création du compte
          echo "<script language='Javascript' type='text/javascript'> 
          alert('Erreur: Cet email existe déjà !'); location.href='../Compte.php?acces=register';</script>";
          exit();
        }
      }
      oci_free_statement($requete1);
      
    
    
      if ($mail == $_POST["email2"] && $_POST['mdp'] == $_POST["mdp2"]) {
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        $_SESSION['access'] = "oui";
    
        # ----------------------------------------------------------------------------------------------------------------  
        #BD insertion du compte
        $req = 'BEGIN CreerCompte( :nom , :pre , :mail , :mdp ); END;';
        $requete = oci_parse($connect, $req);
        oci_bind_by_name($requete, ":nom", $nom);
        oci_bind_by_name($requete, ":pre", $prenom);
        oci_bind_by_name($requete, ":mail", $mail);
        oci_bind_by_name($requete, ":mdp", $mdp);
        $result = oci_execute($requete);
        oci_commit($connect);
        oci_free_statement($requete);
        $_SESSION['nom'] = $mail;
        $sql = "SELECT * FROM Client WHERE adresseMail =:m";
        $requete2 =  oci_parse($connect, $sql);
        oci_bind_by_name($requete2, ":m", $mail);
        $resultat = oci_execute($requete2);
        $container = oci_fetch_assoc($requete2);
        if (isset($container)) {
          $_SESSION['IDC'] = $container['IDCLIENT'];
          $_SESSION['PTS'] = $container['PTSFIDELITE'];
        }
        oci_commit($connect);
        oci_free_statement($requete);
        header("location: ../index.php");
        exit();
      }
    
      #si les 2 emails sont pas les mêmes 
      else if ($_POST['email'] != $_POST['email2']) {
        echo "<script language='Javascript' type='text/javascript'>
        alert('Erreur: Votre E-mail est incorrect'); location.href='../Compte.php?acces=register';</script>";
        exit();
      }
    
      #si les 2 mdps sont pas les mêmes
      else if ($_POST['mdp'] != $_POST['mdp2']) {
        echo "<script language='Javascript' type='text/javascript'>
        alert('Erreur: Votre mot de passe est incorrect'); location.href='../Compte.php?acces=register';</script>";
        exit();
      }
      
    }else {
      echo "<script language='Javascript' type='text/javascript'>
      alert('Erreur : Vous avez mal écris votre nom ou prénom'); location.href='../Compte.php?acces=register';</script>";
      exit();
    }
  }
  #si un des champs n'est pas remplis
  else {
    echo "<script language='Javascript' type='text/javascript'>
    alert('Erreur : Vous devez remplir tous les champs et accepter la politique de confidentialité'); location.href='../Compte.php?acces=register';</script>";
    exit();
  }
}
?>