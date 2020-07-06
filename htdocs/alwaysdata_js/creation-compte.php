<?php
session_start();
$login = $_SESSION['login'];
?>
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
    <div id="titre" style="padding : 1%, 1%, 1%, 5%; float : none; background-color : rgba(28, 129, 158, 0.8);"><a href=index.php>Agricoulis</a></div>
    <div id="soustitre">Une exploitation agricole collective en Cévennes.</div>
    </div>

    <div id="corps" style="background-color : rgba(255, 190, 0, 0.7); width : 98%;">
    <h2>Création de compte</h2>
    
<?php 
function nettoyer($x){
if ($x){
$x = trim($x);
$x = stripslashes($x);
$x = htmlspecialchars($x);
   }
return $x;
   }
$form = 1;
$login = nettoyer($_POST['login']);
$mdp = nettoyer($_POST['mdp']);
$remdp = nettoyer($_POST['remdp']);
$mail = nettoyer($_POST['mail']);

$server = "mysql-assoagricoulis.alwaysdata.net";
$user = "176690_agri";
$passe = "mdpagricoulis";
$base = "assoagricoulis_site";
$con = mysqli_connect($server, $user, $passe, $base);
if (!$con) echo "Pas de connexion : " . mysqli_connect_error();

//Si on a reçu tous les éléments
if ($login != NULL and $mdp != NULL and $remdp != NULL and $mail != NULL) {
  //recherche dans la base de donnée d'entrée ayant le même login ou mail
  $resmail = mysqli_query($con, "SELECT * FROM assoagricoulis_site.utilisateurs WHERE mail='$mail';");
  $reslog = mysqli_query($con, "SELECT * FROM assoagricoulis_site.utilisateurs WHERE login='$login';");
  if (mysqli_num_rows($resmail)>0)
    echo "<p>Un compte utilisant cette adresse mail existe déjà";
  else if (mysqli_num_rows($reslog)>0)
    echo "<p>Ce nom d'utilisateur est déjà utilisé";
  //vérifications du mot de passe
  else if ($mdp != $remdp) {
    echo "<p>Confirmation de mot de passe incorrecte.</p>";
    }
  else if (strlen($mdp) < 9)
    echo "<p>Le mot de passe doit faire minimum 9 caractères";
  else if (!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $mdp))
    {
    echo "<p>Le mot de passe doit contenir des caractères minuscules, majuscules et des chiffres.";
    }
  //si tout est ok on ajoute le nouvel utilisateur à la base après avoir chiffré le mot de passe
  else {
    $form = 0; //on affiche pas le formulaire
    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
    echo "<p>requète mysql";
    mysqli_query($con, "INSERT INTO assoagricoulis_site.utilisateurs VALUES ('$login', '$mail', '$mdp_hash', NULL);");
    session_start();
    $_SESSION['aff_connec'] = 1;
    echo "<p>Compte créé avec succès ! Vous pouvez désormais vous <a href=index.php>connecter</a>.</p>";
    }
  }


if ($form == 1) {
echo "<form method='post' action='creation-compte.php'>
    <p>Nom d'utilisateur<br>
    <input type='text' name='login'></p>
    <p>Mot de passe<br>
    <input type='password' name='mdp'></p>
    <p>Répéter le mot de passe<br>
    <input type='password' name='remdp'></p>
    <p>Adresse mail<br>
    <input type='text' name='mail'></p>
    <input type='submit' value='Créer le compte'>
    </form>
    ";
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
