
<?php
session_start();
require_once("./Connect.inc.php");

if (isset($_GET["idr"])) {
    $id = htmlentities($_GET['idr']);
    $sup = "DELETE 
FROM contientrecipient
WHERE idr=:idr
AND idpanier= :idp";
    $req = oci_parse($connect, $sup);
    oci_bind_by_name($req, ':idr', $id);
    oci_bind_by_name($req, ':idp', $_SESSION['IDC']);
    $result = oci_execute($req);
    oci_commit($connect);
    oci_free_statement($req);
    header("location: ../panier.php");
    exit();
} else {
    
}
?>