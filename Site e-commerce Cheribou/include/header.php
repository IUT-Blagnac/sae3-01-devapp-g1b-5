<link href="include\header.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" />


<header>
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lemon" />
  <a href="index.php"><img src="include\images\Logo.png" height=120 alt="image logo" id="logo"></img></a>
  <h1>CHERIBOU</h1>
  <img src="include\images\DrapeauFR.jpg" height=80 alt="image france" id="imageFR" />
  <nav class="firstnavbar" style="font-size: 1.2em;">
    <ul>
      <li><a href="Boutique.php">Notre entreprise</a></li>
      <li>
        <form method="POST" action="include/actionRecherche.php">
          <input type="search" placeholder="Rechercher" name="search">
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

  <nav class="secondnavbar" style="font-size: 1.2em;">
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
              <li><a <?php echo "href='bonbon.php?nomG=fraise et coca(acide)'"; ?>>Fraise-coca</a></li>
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
      <li><a href="Nouveaute.php">Nouveautés</a></li>
      <li><a href="Promotion.php">Offres</a></li>
      <li><a href="recipient.php">Récipients</a></li>
    </ul>
  </nav>
  
</header>