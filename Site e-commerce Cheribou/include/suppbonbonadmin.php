
<?php
session_start();
require_once("./Connect.inc.php");

if (isset($_POST["idb"])) {
     $id = htmlentities($_POST['idb']);

    $sop="DELETE from contientbonbon where idb=:idb";
    $req2 = oci_parse($connect, $sop);
    oci_bind_by_name($req2, ':idb', $id);
    $result2 = oci_execute($req2);
    oci_commit($connect);
    oci_free_statement($req2);
    
    
   
    $sup = "DELETE  FROM bonbons WHERE idb=:idb";
    $req = oci_parse($connect, $sup);
    oci_bind_by_name($req, ':idb', $id);
    $result = oci_execute($req);
    oci_commit($connect);
    oci_free_statement($req);
    
    
    
     echo "<script language='Javascript' type='text/javascript'>
    alert('Bonbon bien supprime'); location.href='../admin.php';</script>";
    exit();
} else {
    
}
?>