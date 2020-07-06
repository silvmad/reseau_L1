<?php
session_start();
$login = $_SESSION['login'];
$id = $_SESSION['id'];

$server = "localhost";
$user = "agricoulis";
$passe = "mdpagricoulis";
$base = "agricoulis";
$con = mysqli_connect($server, $user, $passe, $base);
if (! $con) echo "Pas de connexion : " . mysqli_connect_error();

$array = $_SESSION['array'];
$commande_ok = false;

//On recherche une commande faite au même moment par le même utilisateur
$res = mysqli_query($con, "SELECT * FROM agricoulis.commandes WHERE time={$array['time']} AND id=$id");

//Si on en trouve pas on ajoute la commande à la base de données.
if (mysqli_num_rows($res) == 0){
 $res = mysqli_query($con, "INSERT INTO agricoulis.commandes VALUES ({$_SESSION['id']}, {$array['pcm']}, {$array['ccm']}, {$array['pdc']}, {$array['cdc']}, {$array['pcn']}, {$array['pado']}, {$array['pgg']}, {$array['bsc']}, {$array['tcal']}, {$array['tcam']}, {$array['ttil']}, {$array['tasdl']}, {$array['tdoedm']}, {$array['talhdg']}, {$array['tecel']}, {$array['tpf']}, {$array['tct']}, {$array['tla']}, {$array['tplm']}, {$array['total']}, '{$array['nom']}', '{$array['prenom']}', '{$array['adresse']}', '{$array['code_postal']}', '{$array['ville']}', 'Attente de paiement', {$array['time']}, NULL);");

 //si l'ajout à la base de données a réussi
 if ($res) $commande_ok = true;
 }
//Sinon c'est que la commande a déjà été ajoutée à la base
else $commande_ok = true;


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
    <div id="connexion"><div id='titre'><a href=index.php>Agricoulis</a></div>
	  
	    <?php 
	     if (isset ($login)) echo "Connecté en tant que $login<br>
                <button class=\"head_bouton\" onclick=\"window.location.href ='home.php';\">Espace perso</button>
		<button class=\"head_bouton\" id=\"bouton_bas\" onclick=\"window.location.href ='deconnexion.php';\">Déconnexion</button>";
		else echo "<button class=\"head_bouton\" onclick=\"aff('connec')\">Connexion</button>
		<br>
		<button class=\"head_bouton\" id=\"bouton_inscr\" onclick=\"window.location.href ='creation-compte.php';\">S'inscrire</button>"
	     ?>
        
      </div>
    <div id="soustitre">Une exploitation agricole collective en Cévennes.</div>
    </div>

    <div id="corps" style="background-color : rgba(255, 190, 0, 0.7); width : 98%;">


<?php
if ($commande_ok) echo "<p>Votre commande a bien été enregistrée ! 
<p>Elle vous sera envoyée dès réception de votre paiement.
<p>Vous pouvez payer par chèque à l'ordre de l'association Agricoulis, à envoyer à l'adresse suivante :
<p>Association Agricoulis, Coulis 30450 Bonnevaux.
<p style='font-size : 3em;'>Attention, ce site n'est pas opérationnel, pour l'instant il n'est qu'un exercice, l'association Agricoulis n'effectue pas encore de vente en ligne, merci de ne pas envoyer de chèque.";
else echo "<p>Il y a eu un problème avec votre commande, veuilez réessayer.";
?>
<p><a href='home.php'>Retour à l'accueil</a>
    </div>

    <div id="pied">
    Contact : Association Agricoulis, Coulis 30450 Bonnevaux <br>
    <a href="mailto:assoagricoulis@laposte.net">assoagricoulis@laposte.net</a> 
    / 04 66 56 61 95
    </div>

    </div>

  </body>

</html>
