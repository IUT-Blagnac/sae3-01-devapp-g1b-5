<?php
session_start();
if (isset($_POST['valider'])) {
    # si tout les champs sont remplis
    if ($_POST['prenom'] != "" && $_POST['nom'] != "" && $_POST['email'] != "" && $_POST['email2'] != "" && $_POST['mdp'] != "" && $_POST['mdp2'] != "") {
        #si les email et mdp sont les meme
        $mail = htmlentities($_POST['email']);
        $nom = htmlentities($_POST['nom']);
        $prenom = htmlentities($_POST['prenom']);
        if ($mail == $_POST["email2"] && $_POST['mdp'] == $_POST["mdp2"]) {
            $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
            $_SESSION['access'] = "oui";
            # ----------------------------------------------------------------------------------------------------------------  
            #BD insertion du compte
            require_once('./Connect.inc.php');
            $req = 'BEGIN CreerCompte( :nom , :pre , :mail , :mdp ); END;';
            $requete = oci_parse($connect, $req);
            oci_bind_by_name($requete, ":nom", $nom);
            oci_bind_by_name($requete, ":pre", $prenom);
            oci_bind_by_name($requete, ":mail", $mail);
            oci_bind_by_name($requete, ":mdp", $mdp);
            $result = oci_execute($requete);
            oci_free_statement($requete);
            $_SESSION['nom'] = $mail;
            header("location: ../index.php");
            exit();
        }
        #si les 2 email sont pas les meme 
        else if ($_POST['email'] != $_POST['email2']) {
            echo "<script language='Javascript' type='text/javascript'>
            alert('Erreur: Votre E-mail est incorrect'); location.href='../Compte.php?acces=register';</script>";
            exit();
        }
        #si les 2 mdp sont pas les meme
        else if ($_POST['mdp'] != $_POST['mdp2']) {
            echo "<script language='Javascript' type='text/javascript'>
            alert('Erreur: Votre mot de passe est incorrect'); location.href='../Compte.php?acces=register';</script>";
            exit();
        }
    }
    #si un des champs n'est pas remplie
    else {
        echo "<script language='Javascript' type='text/javascript'>
        alert('Erreur: Champ incomplet'); location.href='../Compte.php?acces=register';</script>";
        exit();
    }
}?>