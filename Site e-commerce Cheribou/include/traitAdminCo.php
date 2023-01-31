 <!DOCTYPE html>
<html lang="fr">
<head>
<link rel="stylesheet" href="AdminCo.css">
 <meta charset="utf-8">
  <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
</head>
<body>
<form>
  <input type="button" value="Retour" onclick="history.go(-1)">
</form>
<h1>Commandes clients</h1>
 
 <?php
 if( isset($_POST['valid']) && !empty($_POST['idc']) ){
 
                 require_once('Connect.inc.php');
                 $r =  "SELECT idcommande from commande where idclient = : idce";
                 $reqe = oci_parse($connect, $r);
                 $idcl = htmlentities($_POST['idc']);
                 oci_bind_by_name($reqe, ":idce", $idcl);
                 oci_execute($reqe);
                 $nrows = oci_fetch_all($reqe, $res);
                  oci_free_statement($reqe);
                  
                  
                  if($nrows == 0){
                  echo "<p>Ce client n'a pas fais de commande.</p>";
                  
                  }else if($nrows > 0){
                
             
 
 
 
                 
                  $req4 = "SELECT * from commande where idclient = : idc";
                  $requete4 = oci_parse($connect, $req4);
                  $idclit = htmlentities($_POST['idc']);
                  oci_bind_by_name($requete4, ":idc", $idclit);
                  $result4 = oci_execute($requete4);
                  $select4='<select>';
                  while (($row4 = oci_fetch_array($requete4, OCI_BOTH)) != false) {
                  $select4.= "<option value='".$row4['IDCLIENT']."'>"."Id client : " . $row4['IDCLIENT']. " ,id commande : " . $row4['IDCOMMANDE'] . " ,id paiement :" . $row4['IDPAIEMENT'] . " ,date commande : " . $row4['DATECOMMANDE'] . " ,prix commande : " . $row4['PRIXC'] . "</option>";
                  }
                  $select4.="</select>";
                  oci_free_statement($requete4);
                  echo "<div>";
                  echo "<b>Les commandes du clients</b> ";echo "<br><br>";
                  
                  echo $nrows . " commandes"; echo "<br><br>";
                  echo $select4;
                  echo "</div>";
               
               
               }}else echo "<script language='Javascript' type='text/javascript'>
  alert('Erreur: Selectionner un client !'); location.href='../admin.php';</script>";
  
  ?>
  
  </body>
  
  </html>