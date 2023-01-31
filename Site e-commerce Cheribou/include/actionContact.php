<?php
if(isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['sujet']) && isset($_POST['message']) && isset($_POST['Valider'])){
  echo "<script language='Javascript' type='text/javascript'>
  alert('Message bien envoyé'); location.href='../contact.php';</script>";
}
else{
  echo "<script language='Javascript' type='text/javascript'>
  alert('Erreur: Vous devez remplir tous les champs'); location.href='../contact.php';</script>";
} 




?>