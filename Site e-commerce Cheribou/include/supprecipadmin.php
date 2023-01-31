
<?php
session_start();
require_once("./Connect.inc.php");

if (isset($_POST["idr"])) {
     $id = htmlentities($_POST['idr']);

    $sop="DELETE from contientrecipient where idr=:idr";
    $req2 = oci_parse($connect, $sop);
    oci_bind_by_name($req2, ':idr', $id);
    $result2 = oci_execute($req2);
    oci_commit($connect);
    oci_free_statement($req2);
    
    
   
    $sup = "DELETE  FROM recipient WHERE idr=:idr";
    $req = oci_parse($connect, $sup);
    oci_bind_by_name($req, ':idr', $id);
    $result = oci_execute($req);
    oci_commit($connect);
    oci_free_statement($req);
    
    
    echo "<script language='Javascript' type='text/javascript'>
    alert('Recipient bien supprime'); location.href='../admin.php';</script>";
    exit();
} else {
    
}
?>