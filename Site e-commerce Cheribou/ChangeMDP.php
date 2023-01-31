<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if ($_SESSION['access'] != "oui") { #si la variable session est différent de oui
        echo "<script language='Javascript' type='text/javascript'>
      alert('Erreur: vous devez être connecté !'); location.href='Compte.php?acces=login';</script>";
        exit();
    }
    echo $_SESSION['IDC'];
    $idc = htmlentities($_SESSION['IDC']);
    ?>
    <form action="ChangeMDP.php" method="post">
        Ancien mdp* <input type="password" name="Amdp">
        Nouveau mdp* <input type="password" name="Nmdp">
        confirmer nouveau mdp <input type="password" name="cmdp">
        <input type="submit" id="Valider" name="Val">
    </form>

    <?php
    if (isset($_POST["Val"])) {
        if (null !== htmlentities($_POST['Amdp'])) {
            echo "<script language='Javascript' type='text/javascript'>
        alert('Erreur: votre ancien mot de passe n'est pas renseigner');</script>";
            exit();
        }
        if (null !== htmlentities($_POST['Nmdp'])) {
            echo "<script language='Javascript' type='text/javascript'>
        alert('Erreur: votre nouveau mot de passe n'est pas renseigner');</script>";
            exit();
        }
        if (null !== htmlentities($_POST['cmdp'])) {
            echo "<script language='Javascript' type='text/javascript'>
        alert('Erreur: votre confirmation de mot de passe n'est pas renseigner');</script>";
            exit();
        }
        $nmdp = htmlentities($_POST["Nmdp"]);
        $cmdp = htmlentities($_POST["cmdp"]);
        require_once("include/Connect.inc.php");
        $reqMDP = "SELECT motdepasse FROM CLIENT WHERE idclient = :idc";
        $requete = oci_parse($connect, $reqsql);
        oci_bind_by_name($requete, ":idc", $idc);
        $result = oci_execute($requete);
        $container = oci_fetch_assoc($requete);
        if ($container != "") {
            $mdp = htmlentities($_POST('Amdp'));
            if (password_verify($_POST['mdp'], $container['MOTDEPASSE'])) {
                if ($nmdp != $cmdp) {
                    echo "<script language='Javascript' type='text/javascript'>
        alert('Erreur: Vos nouveau mot de passse est incorect');</script>";
                    exit();
                }
                $reqChangerMDP = "UPDATE clientSET motdepasse = :mdp WHERE idclient=:idc";
                $req = oci_parse($connect, $reqsql);
                oci_bind_by_name($requete, ":idc", $idc);
                oci_bind_by_name($requete, ":mdp", password_hash($_POST['mdp'], PASSWORD_DEFAULT));
                $result = oci_execute($requete);
                oci_commit($connect);
                header("location: ./InfosCompte.php?nomC=" . $_SESSION["nom"] . "");
                exit();
            } else {
                echo "<script language='Javascript' type='text/javascript'>
        alert('Erreur: Votre ancien mot de passe est inccorect');</script>";
                exit();
            }
        }
    } ?>


</body>

</html>