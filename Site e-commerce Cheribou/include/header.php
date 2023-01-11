<link href="include\header.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" />


<header>
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lemon" />
  <a href="index.php"><img src="include\images\Logo.png" height=120 alt="image logo" id="logo"></img></a>
  <h1>CHERIBOU</h1>
  <img src="include\images\DrapeauFR.jpg" height=80 alt="image france" id="imageFR" />
  <nav class="firstnavbar">
    <ul>
      <li><a href="#">Nos boutiques</a></li>
      <li>
        <form method="POST">
          <input type="search" placeholder="Search" name="search">
        </form>

      </li>
      <li class="boxparent">
        <div class="box">
          <a
              <?php 
              
              if(!isset($_SESSION)){
                session_start();
              }
              if(isset($_SESSION['access'])){ //si la session existe
                if($_SESSION['access'] == "oui"){ #si le client est connecté
                  $LoginMail = $_SESSION['nom']; #on récupère son id (adresse mail) pour mettre dans l'URL
                  echo "href='InfosCompte.php?nomC=".$LoginMail."'"; #le bouton "compte" redirige le client vers la page de description du compte 
                }
                else{#sinon si il n'est pas connecté
                  echo "href='Compte.php?acces=login'"; #le bouton "compte" redirige vers les formulaires
                }
              }
              else{#sinon si la session n'existe pas
                echo "href='Compte.php?acces=login'"; #le bouton "compte" redirige vers les formulaires
              }
              
             ?>><i class="fas fa-user"></i></a>
        </div>
        <div class="box">
          <a href="panier.php"><i class="fas fa-shopping-cart"></i></a>
        </div>
      </li>
    </ul>
  </nav>

  <nav class="secondnavbar">
    <ul>
      <li class="deroulant"><a href="#">Bonbons &ensp;</a>
        <ul class="sous">
          <li>
            <h3>Marques</h3>
            <ul class="sousitems">
              <li><a <?php echo "href='bonbon.php?nomP=Dragibou'"; ?>>Dragibou</a></li>
              <li><a <?php echo "href='bonbon.php?nomP=Nounoursou'"; ?>>Nounoursou</a></li>
              <li><a <?php echo "href='bonbon.php?nomP=Tete broulou'"; ?>>Tête broulou</a></li>
              <li><a <?php echo "href='bonbon.php?nomP=Carambou'"; ?>>Carambou</a></li>
              <li><a <?php echo "href='bonbon.php?nomP=Malabou'"; ?>>Malabou</a></li>
              <li><a <?php echo "href='bonbon.php?nomP=Toudoudou'"; ?>>Toudoudou</a></li>
            </ul>
          </li>

          <li>
            <h3>Formats</h3>
            <ul class="sousitems">
              <li><a <?php echo "href='bonbon.php?nomF=Grand Sachet'"; ?>>Grand sachet</a></li>
              <li><a <?php echo "href='bonbon.php?nomF=Mini Sachet'"; ?>>Mini sachet</a></li>
              <li><a <?php echo "href='bonbon.php?nomF=10cm'"; ?>>Cône 10cm</a></li>
              <li><a <?php echo "href='bonbon.php?nomF=25cm'"; ?>>Cône 25cm</a></li>
              <li><a <?php echo "href='bonbon.php?nomF=50cm'"; ?>>Cône 50cm</a></li>
            </ul>
          </li>
          <li>
            <h3>Gouts</h3>
            <ul class="sousitems">
              <li><a <?php echo "href='bonbon.php?nomG=Aucun'"; ?>>Aucun</a></li>
              <li><a <?php echo "href='bonbon.php?nomG=Chocolat'"; ?>>Chocolat</a></li>
              <li><a <?php echo "href='bonbon.php?nomG=Acide&nomG=Fraise(acide)&nomG=Coca(acide)&nomG=Caramel(acide)'"; ?>>Acide</a></li>
              <li><a <?php echo "href='bonbon.php?nomG=Fraise&nomG=Fraise(acide)'"; ?>>Fraise</a></li>
              <li><a <?php echo "href='bonbon.php?nomG=Coca&nomG=Coca(acide)'"; ?>>Coca</a></li>
              <li><a <?php echo "href='bonbon.php?nomG=Caramel&nomG=Caramel(acide)'"; ?>>Caramel</a></li>
              <li><a <?php echo "href='bonbon.php?nomG=fraise + coca(acide)'"; ?>>Fraise-coca</a></li>
            </ul>
          </li>
          <li>
            <h3>Préferences alimentaires</h3>
            <ul class="sousitems">
              <li><a <?php echo "href='bonbon.php?nomPref=Bonbon vegetarien'"; ?>>Bonbon végétarien</a></li>
              <li><a <?php echo "href='bonbon.php?nomPref=Bonbon vegan'"; ?>>Bonbon végan</a></li>
              <li><a <?php echo "href='bonbon.php?nomPref=Bonbon sans gluten'"; ?>>Bonbon sans gluten</a></li>
              <li><a <?php echo "href='bonbon.php?nomPref=Aucune'"; ?>>Aucune</a></li>
            </ul>
          </li>

        </ul>
      </li>
      <li><a href="#">Nouveautés</a></li>
      <li><a href="#">Offres</a></li>
      <li><a href="#">Spécial</a></li>
      <li><a href="#">Votre bonbon</a></li>
    </ul>
  </nav>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  
</header>
<?php #gestion de la barre de recherche


if (isset($_POST['search'])) { #si la barre de recherche est nom vide
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
}

?>