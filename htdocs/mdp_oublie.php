<!Doctype html>
<html>
  
  <head>
    <title>Agricoulis</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
  </head>

  <body>

    <div id="page">

    <div id="entete">
    <div id="titre" style="padding : 1%, 1%, 1%, 5%; float : none; background-color : rgba(28, 129, 158, 0.8);"><a href=index.php>Agricoulis</a>
    </div>
    <div id="soustitre">Une exploitation agricole collective en Cévennes.</div>
    </div>

    <div id="corps" style="background-color : rgba(255, 190, 0, 0.7); width : 98%;">

<?php
//fonction qui génère une chaine aléatoire
function genererChaineAleatoire($longueur = 20, $listeCar = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
 $chaine = "";
 $max = strlen($listeCar) - 1;
 for ($i = 0; $i < $longueur; ++$i) {
 $chaine .= $listeCar[random_int(0, $max)];
 }
 return $chaine;
}

function nettoyer($x){
if ($x){
$x = trim($x);
$x = stripslashes($x);
$x = htmlspecialchars($x);
   }
return $x;
   }

$server = "localhost";
$user = "agricoulis";
$passe = "mdpagricoulis";
$base = "agricoulis";
$con = mysqli_connect($server, $user, $passe, $base);
if (! $con) echo "Pas de connexion : " . mysqli_connect_error();
    
    //Affichage du formulaire si pas reçu de mail
    if (!isset($_POST['mail'])) echo "<h2>Mot de passe oublié</h2>
    <p>Entrez votre adresse, un mail vous sera envoyé avec un lien pour réinitialiser votre mot de passe.
    <p><form method='post' action='mdp_oublie.php'>
    Adresse mail : &nbsp<input type='text' name='mail'>
    <input type='submit' value='Envoyer'>
    </form>";

    //on a reçu un mail
    else {
     $mail = nettoyer($_POST['mail']);
     //On recherche dans la base un utilisateur ayant ce mail
     $res = mysqli_query($con, "SELECT * FROM agricoulis.utilisateurs WHERE mail='$mail';");
     //Si on en a trouvé un
     if (mysqli_num_rows($res) > 0) {
      $assoc = mysqli_fetch_assoc($res);
      $id = $assoc['id'];
      $time = time();
      $chaine = genererChaineAleatoire();
      //Ajout des information de réinitialisation à la table reset_mdp
      mysqli_query($con, "INSERT INTO agricoulis.reset_mdp VALUES ('$mail', '$chaine', '$id', '$time');");
      //envoi du mail
      mail($_POST['mail'], "Agricoulis : réinitialisation de mot de passe", "Bonjour,\r\nVous avez demandé la réinitialisation de votre mot de passe\r\nPour ce faire, veuillez suivre ce lien (disponible 15 minutes)\r\n
      http://assoagricoulis.alwaysdata.net/mdp_reset.php?chaine=$chaine");
      echo "Un mail a été envoyé à l'adresse $mail";
     }
     else echo "Aucun compte n'utilise cette adresse mail, veuillez réessayer.";
    }
    ?>
    </div>

    <div id="pied">
    Contact : Association Agricoulis, Coulis 30450 Bonnevaux <br>
    <a href="mailto:assoagricoulis@laposte.net">assoagricoulis@laposte.net</a> 
    / 04 66 56 61 95
    </div>

    </div>

  </body>

</html>
