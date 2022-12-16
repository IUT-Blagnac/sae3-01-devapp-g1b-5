<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
     <link rel="stylesheet" href="include/styles.css">
     <link rel="stylesheet" href="include/bonbon.css">
	<title>Mon site en PHP!</title>
</head>
<body>
	<?php include("./include/header.php"); ?>
   <main>
     <p class="titre">Nos Bonbons</p>
     <div class="contener">
       <p class="text">X résultats</p>
       <form class="form" method="POST">
         Trié par : <select style="width: 200px; font-size: 0.7em;" name='Type_recherche'>
                     <option value="best">Meileur résultat</option>
                     <option value="prixCroissant">Prix croissant</option>
                     <option value="prixDecr">Prix décroissant</option>
                     <option value="AaZ">De A à Z</option>
                     <option value="ZaA">De Z à A</option>
                     <option value="marque">Marque</option>
                     <option value="PlusPOP">Les plus populaires</option>
                    </select>
         <input style="font-size: 0.7em; width: 150px; height: 25px;" type="submit" name="Valider" value="Valider"/>
       </form>
       
       
       <br></br><br></br>
       <br></br><br></br>
       
       
       <?php
         require_once('include/Connect.inc.php');
         $req = "SELECT * FROM Bonbons WHERE nomB = :produit";
         $requete = oci_parse($connect, $req);
         $value = $_GET['nomP'];
         oci_bind_by_name($requete, ":produit", $value);
         $result = oci_execute($requete);
         echo "<table class='produit'>";
         while (($container = oci_fetch_assoc($requete)) != false) {
           echo "<tr>";
           echo "<td> <img style='border-radius: 20px;' src='include/images/bonbon1.jpg' height=400 width=400 alt='image du bien'/></td>";
           echo "</tr>";
           echo "<tr>";
           echo "<td>".$container['NOMB']."</td>";
           echo "</tr>";
           echo "<tr>";
           echo "<td>".$container['DESCRIPTIONB']."</td>";
           echo "</tr>";
           echo "<tr>";
           echo "<td>".$container['PRIXKG']."</td>";
           echo "</tr>";
         }
         echo "</table>";
         oci_free_statement($requete);
       ?>
     </div>
   </main>
 
  <?php include("include/footer.php");?>
</body>
</html>
