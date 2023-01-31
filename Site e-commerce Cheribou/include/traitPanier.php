<?php
session_start();
$idc = $_SESSION['IDC'];
require_once("Connect.inc.php");
if (isset($_POST)) {
        //on rajoute les points de fidélités
        $value = $_SESSION['PTS'];
        $requete = "UPDATE CLIENT SET PTSFIDELITE = :points WHERE IDCLIENT = :id";
        $req = oci_parse($connect, $requete);
        oci_bind_by_name($req, ':points', $value);
        oci_bind_by_name($req, ':id', $idc);
        $result = oci_execute($req);
        oci_free_statement($req);
        oci_commit($connect);


    if (isset($_POST["Val"])) {
        $commande = "BEGIN ViderPanier(:id ,'Paypal); END;";
        $request = oci_parse($connect, $commande);
        oci_bind_by_name($request, ':id', $idc);
        $result = oci_execute($request);
        oci_free_statement($request);
    } elseif (isset($_POST["Abpanier"])) {
        $supPanier = "BEGIN Abandonner(:idc); END;";
        $request = oci_parse($connect, $supPanier);
        oci_bind_by_name($request, ':idc', $idc);
        $result = oci_execute($request);
        oci_free_statement($request);
        oci_commit($connect);
        header("location: ../panier.php");
        exit();
    }
}
