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

$chaine = nettoyer($_GET['chaine']);
//si on a pas de chaine par GET on essaie de la récup par POST ainsi que les mdp
if (!$chaine) {
 $chaine = nettoyer($_POST['chaine']);
 $mdp = nettoyer($_POST['mdp']);
 $remdp = nettoyer($_POST['remdp']);
}
//Si on a une chaine on traite la réinitialisation de mdp
if ($chaine) {
 //On récupère dans la base la ligne correspondante à la chaine
 $res = mysqli_query($con, "SELECT * FROM agricoulis.reset_mdp WHERE chaine='$chaine';");
 //Si on a trouvé dans la base une ligne correspondant à la chaine on continue
 if ($res) {
  $res = mysqli_fetch_assoc($res);
  $time_reset = $res['time'];
  $time = time();
  //Si la requète n'a pas encore expiré on continue
  if ($time - $time_reset < 900 ) {
   //Si les deux mots de passe sont identiques on procède à la mise à jour de la base de données
   if (isset($mdp) && $mdp == $remdp) {
    $id = $res['id'];
    $mdp = password_hash($mdp, PASSWORD_DEFAULT);
    $res = mysqli_query($con, "UPDATE agricoulis.utilisateurs SET mdp='$mdp' WHERE id='$id';");
    if ($res) {
     echo "<p>Réinitialisation réussie !<br><a href='index.php'>Connectez-vous</a>";
     mysqli_query($con, "DELETE FROM agricoulis.reset_mdp WHERE chaine='$chaine'");
     }
     else echo "Désolé la réinitialisation n'a pas fonctionné, réessayez plus tard.";
   } 
   //Sinon on affiche le formulaire de réinitialisation
   else {
    if (isset($mdp) && $mdp != $remdp) echo "Le mot de passe et sa répétition ne sont pas identiques.";
    echo "<p><form method='post' action='mdp_reset.php'>Entrez votre nouveau mot de passe 
       <input type='password' name='mdp'><br>
       Retapez votre nouveau mot de passe <input type='password' name='remdp'><br>
       <input type='hidden' name='chaine' value='$chaine'>
       <input type='submit' value='Envoyer'>";
   }
  }
  //Si la requète a expiré on affiche une erreur
  else echo "Cette page a expiré, veuillez refaire votre demande de réinitialisation.";
 }
 //Si on a pas trouvé dans la base de ligne correspondant à la chaîne, on affiche un message d'erreur
 else echo "Il y a eu un problème, veuillez refaire votre demande de réinitialisation";
}
//Si pas de chaine l'utilisateur est arrivé ici par hasard, on affiche un message d'erreur.
else echo "<p>Vous vous êtes perdu on dirait ! <a href='index.php'>Retour à l'accueil</a>";

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
