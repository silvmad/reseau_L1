<?php 
 session_start();
 $login = $_SESSION['login'];
 function nettoyer($x){
 if ($x){
 $x = trim($x);
 $x = stripslashes($x);
 $x = htmlspecialchars($x);}
 return $x;}

//si on a reçu des informations de connexion
if (isset($_POST['login']) && isset($_POST['mdp'])){
 $server = "localhost";
 $user_log = "agricoulis";
 $passe_log = "mdpagricoulis";
 $base_log = "agricoulis";
 $con_log = mysqli_connect($server, $user_log, $passe_log, $base_log);
 if (! $con_log) echo "Pas de connexion : " . mysqli_connect_error();

 $log = nettoyer($_POST['login']);
 $mdp = nettoyer($_POST['mdp']);

 //récupération de la ligne correspondant au nom d'utilisateur entré
 $res_log = mysqli_query($con_log, "SELECT * FROM agricoulis.utilisateurs WHERE login='$log'");
 $usertab = mysqli_fetch_assoc($res_log);
 $mdp_hash_db = $usertab['mdp'];

 //si le mot de passe correspond on lance la session et on redirige
 $mdp_ok = password_verify($mdp, $mdp_hash_db);
 if ($mdp_ok){
  session_start();
  $_SESSION['id'] = $usertab['id'];
  $_SESSION['login'] = $usertab['login'];
  header('Location: home.php');
  }
 }
?>

<!Doctype html>
<html>
  
  <head>
    <title>Agricoulis</title>
    <meta charset="utf-8">

    <link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
    <meta name="DC.Title" content="Agricoulis">
    <meta name="DC.Creator" content="Victor Matalonga">
    <meta name="DC.Subject" content="Association Agricoulis, agriculture">
    <meta name="DC.Description" content="Page web de l'association Agricoulis">
    <meta name="DC.Publisher" content="Association Agricoulis">
    <meta name="DC.Date" content="27/03/2019">
    <meta name="DC.Type" content="Texte">
    <meta name="DC.Type" content="Images">
    <meta name="DC.Type" content="Contenu interactif">
    <meta name="DC.Format" content="Texte">
    <meta name="DC.Format" content="HTML">
    <meta name="DC.Format" content="Images">
    <meta name="DC.Language" content="Fr">
    <meta name="DC.Rights" content="Licence Creative Commons CC BY NC SA">

    <link rel="stylesheet" href="style.css">
  </head>

  <body>

    <div id="page">

      <div id="entete">
	<div id="connexion"><div id='titre'><a href=index.php>Agricoulis</a></div>
	  
	    <?php 
	     if (isset ($login)) echo "Connecté en tant que $login<br>
                <button class=\"head_bouton\" onclick=\"window.location.href ='home.php';\">Espace perso</button>
		<button class=\"head_bouton\" id=\"bouton_bas\" onclick=\"window.location.href ='deconnexion.php';\">Déconnexion</button>";
		else echo "<button class=\"head_bouton\" onclick=\"aff('connec')\">Connexion</button>
		<br>
		<button class=\"head_bouton\" id=\"bouton_bas\" onclick=\"window.location.href ='creation-compte.php';\">S'inscrire</button>"
	     ?>
        
	  </div>
        

	
	<div id="soustitre">Une exploitation agricole collective en Cévennes.</div>
      </div>


      <div id="menu">
	<button class="menu" onclick="aff('index')">Accueil</button><br>	
	<br>
	<button class="menu" onclick="aff('chataigneraie')">Châtaigneraie</button><br>
	<br>
	</a><button class="menu" onclick="aff('vergers')">Vergers et petits fruits</button><br>
	<br>
	<button class="menu" onclick="aff('tisanes')">Tisanes et plantes médicinales</button><br>
	<br>
	<button class="menu" onclick="aff('catalogue')">Catalogue</button><br>
	<br>
      </div>

      <div id="corps">

	<div id="index"> <!--style="display : block;"-->
	<p>Agricoulis est une exploitation agricole collective sous forme
	  associative dont l'activité est
	  située autour du hameau de Coulis sur la commune de
	  <a href="http://www.bonnevaux.com/" target="_blank">Bonnevaux.</a></p>
	<img src=hameau_coulis.JPG alt="Photo du hameau de Coulis"  title="Le hameau de Coulis">
	<p>Depuis 2010, l'association Agricoulis s'est donnée pour mission de
	  reconquérir les espaces agricoles abandonnés depuis près d'un siècle de la
	  vallée de Coulis et d'y installer un collectif de paysan-ne-s s'organisant
	  de façon horizontale, sans hiérarchie et dans le respect des besoins et
	  des possibilités de chacun-e-s.</p>
	<p>L'exploitation est entièrement en
	  agriculture biologique, certifiée par ecocert. Vous pouvez télécharger
	  notre certificat <a href="http://certificat.ecocert.com/client.php?id=C44BF548-A4BE-467A-8FAD-93E739C436A0&source=agencebio" target="_blank">ici</a>.</p>
	</div>

	<div id="chataigneraie"><!-- style="display : none"-->
	  <h2>Châtaigneraie</h2>
	  <p>L'association restaure depuis 2013 plusieurs parcelles de châtaigneraie
	    abandonnées depuis parfois plus d'un siècle. Deux techniques de
	    restauration ont été mises en oeuvres : élagage sévère et greffage sur
	    rejets.<br>
	    Les anciens arbres greffés encore en vie ont été conservés ce qui
	    permet la récolte en attendant que les arbres élagués et
	    greffés entrent en production.</p>
	  <img src="chataigneraie.JPG" alt="Photo d'un châtaigner équipé de son 
	       filet de récolte" title="Châtaigneraie équipée pour la récolte">
	  <p>Les châtaignes sont transformées par nos soins en crème de marrons,
	    délice de châtaigne (une crème de marrons allégée en sucre) et en
	    châtaignes au naturel.</p>
	  <p>Sondage : Que préférez-vous ?</p>
	  <?php
	   #récupération du vote
	   $vote = nettoyer($_POST['vote']);
	   
	   #connection au serveur mysql
	   $server = "localhost";
	   $user = "usersondage";
	   $passe = "mdpsondage";
	   $base = "sondage";
	   $con = mysqli_connect($server, $user, $passe, $base);

	   #Si on vote pour la première fois
	   if($vote && !isset($_COOKIE['a_vote'])) {
	   #On ajoute la vote dans la base de données
	   mysqli_query($con, "UPDATE sondage.creme SET nb_votes = nb_votes + 1 WHERE type='$vote';");
	   #On ajoute un cookie qui empêche de voter une deuxième fois tant qu'il est
	   #présent.
	   setcookie('a_vote', 'oui', time()+365*24*60*60);}

	   #Si le cookie est présent on affiche un message.
	   if(isset($_COOKIE['a_vote'])) echo "Vous avez déjà voté pour ce sondage";
	   #Sinon on affiche le formulaire du sondage.
	   else echo "<form method='post' action='index.php'>
	  <input type='radio' name='vote' value='creme'> La crème de marron (60% de sucre dans le 
	  produit fini).<br>
	  <input type='radio' name='vote' value='delice'> Le délice de châtaigne (50% de sucre dans le produit fini).<br>
	  <input type='submit'></form>";
#Récupération du nombre de votes pour 'creme'.
$res_cr = mysqli_query($con, "SELECT nb_votes FROM sondage.creme WHERE type='creme';");
$votes_cr = mysqli_fetch_array($res_cr);
#Récupération du nombre de votes pour 'delice'.
$res_del = mysqli_query($con, "SELECT nb_votes FROM sondage.creme WHERE type='delice';");
$votes_del = mysqli_fetch_array($res_del);

#Extraction des nombres depuis les tableaux retournés.
$votes_cr = $votes_cr[0];
$votes_del = $votes_del[0];

#Calcul du nombre de votes total.
$nb_votes = $votes_cr + $votes_del;

#Si il y a au moins un vote (évite l'erreur de division par 0).
if($nb_votes) {
#Calcul des pourcentages.
$pc_cr = round(($votes_cr * 100) / $nb_votes, 2);
$pc_del = round(($votes_del * 100) / $nb_votes, 2);
#Affichage du tableau des résultats.
echo "<p>$nb_votes personnes ont voté pour ce sondage.</p>";
echo '<p>Résultats : </p>';
echo "<table><tr><td>Crème</td><td>$votes_cr ($pc_cr%)</td></tr>
  <tr><td>Délice</td><td>$votes_del ($pc_del%)</td></tr></table>";}
?>
	</div>

	<div id="vergers">
	  <h2>Vergers et petits fruits</h2>
	  <p>Nous avons planté en 2010 un petit verger d'un trentaine d'arbre
	    d'essence différentes : pommiers, poiriers, amandiers, pêchers...</p>
	  <p>De plus la vallée recelait de nombreux pommiers de variété rustique
	    et locale que nous récoltons et transformons en jus de pomme.</p>
	  <p>Nous avons également plusieurs parcelles de petits fruits : groseilles,
	    cassis, caseilles (un croisement entre cassis et groseille), myrtilles,
	    framboises, groseilles à maquereau. Nous transformons ces fruits en
	    gelée. </p>
	</div>

	<div id="tisanes">
	  <h2>Tisanes et plantes médicinales</h2>
	  <p>Nous cultivons des plantes aromatiques et médicinales depuis 2018 pour
	    en faire des tisanes et à terme des hydrolats et sels aux herbes. Une
	    partie de ces plantes provient de cueillette sauvage.</p>
	  <img src="mélange_tisane.JPG" alt="Photo d'un mélange de plantes et fleurs sèches prêtes pour l'ensachage." title="Mélange de plantes et fleurs séchées.">
	</div>

	<div id="catalogue">
	  <h1>Catalogue et prix des produits</h1>
	  <table border="1">
	    <tr>
	      <td>Crème de Marrons</td><td>4,50€ le pot de 400g<br>50€ le carton de 12 pots</td>
	    </tr>
	    <tr>
	      <td>Délice de Châtaignes</td><td>4,50€ le pot de 400g<br>50€ le carton de 12 pot</td>
	    </tr>
	    <tr>
	      <td>Châtaignes au naturel</td><td>4€ le pot de 250g</td>
	    </tr>
	    <tr>
	      <td>Condiment à base d'ail des ours</td><td>4,50€ le pot de 200g</td>
	    </tr>
	    <tr>
	      <td>Gelée de groseilles</td><td>4€ le pot de 245g</td>
	    </tr>
	    <tr>
	      <td>Sirop de cerises</td><td>5€ les 50cl</td>
	    <tr>
	      <td>Tisane en mélange</td><td>3,50€ / 20g ou 4,50€ / 30g</tr>
	    <tr>
	      <td>Tisane simple</td><td>3€ le sachet</td>
	    </tr>
	  </table>
	  <p>Vous trouverez une version pdf de ce tableau <a href="Fly Agricool  Verso 2018.pdf" target="_blank">ici</a>.</p>
	  <p>Le détail des tisanes en mélange est disponible <a href="Fly Tisane VersoFinal.pdf" target="_blank">ici</a>.</p>
	</div>

	<div id="connec">
	  <?php
           //formulaire de connexion
	   if (isset($mdp) && !$mdp_ok) echo "<p>Mot de passe incorrect";
	   ?>
	   <form method='post' action='index.php'>
	     <p>Nom d'utilisateur<br>
	       <input type='text' name='login'></p>
	     <p>Mot de passe<br>
	       <input type='password' name='mdp'></p>
	     <input type='submit' value='Connexion'>
	     <a href='mdp_oublie.php'>Mot de passe oublié</a>
	   </form>
	</div>

	<div id="crea_cpt">

	</div>
	
      </div>

      <div id="pied">
	Contact : Association Agricoulis, Coulis 30450 Bonnevaux <br>
	<a href="mailto:assoagricoulis@laposte.net">assoagricoulis@laposte.net</a> 
	/ 04 66 56 61 95
      </div>

    </div>

    <?php
    if (isset($_POST['login']) && !$mdp_ok) echo "<script>aff('connec');</script>";
    if (isset($_POST['vote'])) echo "<script>aff('chataigneraie');</script>"; 
    if (isset($_SESSION['aff_connec'])) {
      echo "<script>aff('connec');</script>";
      unset($_SESSION['aff_connec']);
    }
    ?>

    <script src="agricoulis.js"></script>
  </body>
</html>
