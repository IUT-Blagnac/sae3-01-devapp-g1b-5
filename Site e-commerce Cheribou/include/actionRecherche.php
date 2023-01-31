<?php

if (isset($_POST['search'])) { #si la barre de recherche est nom vide
  /*
  switch ($_POST['search']) { #on met en place un switch case
    case "Dragibou": #case pour dragibou
      header('location: bonbon.php?nomP=Dragibou'); #redirection
      break;
    case "Nounoursou": #case pour nounoursou
      header('location: bonbon.php?nomP=Nounoursou'); #redirection
      break;
    case "Tête broulou": #case pour tête broulou
      header('location: bonbon.php?nomP=Tête broulou'); #redirection
      break;
    case "Carambou": #case pour carambou
      header('location: bonbon.php?nomP=Carambou'); #redirection
      break;
    case "Malabou": #case pour malabou
      header('location: bonbon.php?nomP=Malabou'); #redirection
      break;
    case "Toudoudou": #case pour toudoudou
      header('location: bonbon.php?nomP=Toudoudou'); #redirection
      break;
    default: #si rien trouvé
      header('location: bonbon.php?msgErreur=Aucun resultat trouvé'); #redirection avec message d'erreur
      break;


  }
  */
  header('location: ../bonbon.php?Search='.$_POST['search'].''); #redirection
}
?>