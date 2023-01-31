<!DOCTYPE html>
<html lang="fr">
<head>
<link rel="stylesheet" href="include\proadmin.css">
 <meta charset="utf-8">
  <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
</head>
<body>
<form>
  <input type="button" value="Retour" onclick="history.go(-1)">
</form>



<?php 
if (isset($_POST['buttonB'])) {
echo "<h1>Gestion produits bonbons</h1>";
require_once('include/Connect.inc.php');
echo "<div class ='bb'>";
echo "<h2>Supprimer un bonbon</h2>";
echo '<form class="b" method="post" action="include/suppbonbonadmin.php">';
      $req = "SELECT * from bonbons";
      $requete = oci_parse($connect, $req);
      $result = oci_execute($requete);
      $select= '<select name="idb" id="idb" required>';
      while (($row = oci_fetch_array($requete, OCI_BOTH)) != false) {
     $select.= "<option value='".$row['IDB']."'>".$row['NOMB']. " :" . $row['IDB']."</option>";
      }
      $select.="</select>";
      echo $select."<br><br>";
      oci_free_statement($requete);
      
      echo '<input type="submit" name="b1"
                class="button" value="Supprimer bonbon" />
         
    </form>'; echo "</div>";   
    
    echo"<div class='bba'>";
      $req = "SELECT * from categorieb";
      $requete = oci_parse($connect, $req);
      $result = oci_execute($requete);
      $select= 'Id categorie : <select name="Idc" id="Idc" required>';
      while (($row = oci_fetch_array($requete, OCI_BOTH)) != false) {
     $select.= "<option value='".$row['IDCATEGORIE']."'>".$row['NOMCATEGORIE']. " :" . $row['IDCATEGORIE']."</option>";
      }
      $select.="</select><br><br>";
      oci_free_statement($requete);
    
      
       echo "<form class='addbb' method='POST' action='include/traitNvBonbon.php' >";
        echo "<h2>Ajouter un bonbon</h2>";
           echo $select;
           echo " Prix au kg : <input type='text' name='kg'/><br><br>";
           echo" Couleur du bonbon : <input type='text' name='couleur'/><br><br>";
           echo" Format bonbon : <input type='text' name ='format'/><br><br>";
            echo"Ingr&eacutedient : <input type='text' name='ing'/><br><br>";
           echo" Nom du bonbon : <input type='text' name='nomb'/><br><br>"; 
           echo" Description : <input type='text' name='describ'/><br><br>";    
            echo "Pr&eacutef&eacuterence alimentaire : <input type='text' name='prefali'/><br><br>";
           echo " Marque du bonbon : <input type='text' name='marqueb'/><br><br>";      
            echo "Gout du bonbon : <input type='text' name='goutb'/><br><br>";
            echo "Poid KG bonbon : <input type='text' name='poidkg'/><br><br>";
           echo " Prix unitaire : <input type='text' name='prixuni'/><br><br> ";  
           echo "<input style='font-size: 16px; padding-left: 5%;' type='submit' value='Valider' name='Valider'/><br>";
        echo "</form>";
       
    
    echo"</div>";
    
    
    
    
    
    
    
    
    
    
    }else if(isset($_POST['buttonR'])){
    
    echo "<h1>Gestion produits r&eacutecipients</h1>";
    
    require_once('include/Connect.inc.php');
    echo "<div class ='rr'>";
    echo "<h2>Supprimer un r&eacutecipient</h2>";
    echo '<form class="r" method="post" action="include/supprecipadmin.php">';
      $req = "SELECT * from recipient";
      $requete = oci_parse($connect, $req);
      $result = oci_execute($requete);
      $select='<select name="idr" id="idr" required>';
      while (($row = oci_fetch_array($requete, OCI_BOTH)) != false) {
     $select.= "<option value='".$row['IDR']."'>".$row['NOMR']. " :" . $row['IDR']."</option>";
      }
      $select.="</select>";
      echo $select."<br><br>";
      oci_free_statement($requete);
      
      echo '<input type="submit" name="b1"
                class="button" value="Supprimer recipient" />
         
    </form>'; echo "</div>";
    
    
     echo"<div class='rra'>";
     
      
       echo "<form class='addrr' method='POST' action='include/traitNvRecip.php' >";
        echo "<h2>Ajouter un r&eacutecipient</h2>";
           echo " Prix unitaire : <input type='text' name='prixu'/><br><br>";
            echo"Couleur du r&eacutecipient : <input type='text' name='couleur'/><br><br>";
           echo" Nom du r&eacutecipient : <input type='text' name='nomr'/><br><br>"; 
           echo" Description : <input type='text' name='descrir'/><br><br>";       
            echo "Poid unitaire : <input type='text' name='poiduni'/><br><br>"; 
           echo "<input style='font-size: 16px; padding-left: 5%;' type='submit' value='Valider' name='Valider'/><br>";
        echo "</form>";
    
    
    echo"</div>";
    
    }else if(isset($_POST['buttonG'])){
  
      
      echo "<h1>Gestion des categories</h1>";
       echo "<form class='addga' method='POST' action='include/traitNvCategorie.php' >";
        echo "<h2>Ajouter une gat&eacutegorie de bonbon</h2>";
           echo " Nom categorie : <input type='text' name='nomcat'/><br><br>";
            echo "<input style='font-size: 16px; padding-left: 5%;' type='submit' value='Valider' name='Valider'/><br>";
        echo "</form>";
        
        
    
   
    
    
    
    }







?>
</body>

</html>