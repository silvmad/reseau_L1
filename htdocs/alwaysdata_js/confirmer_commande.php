<?php
session_start();
$login = $_SESSION['login'];
$id = $_SESSION['id'];

function nettoyer($x){
  if ($x){
  $x = trim($x);
  $x = stripslashes($x);
  $x = htmlspecialchars($x);
  }
return $x;
}
$server = "mysql-assoagricoulis.alwaysdata.net";
$user = "176690_agri";
$passe = "mdpagricoulis";
$base = "assoagricoulis_site";
$con = mysqli_connect($server, $user, $passe, $base);
if (! $con) echo "Pas de connexion : " . mysqli_connect_error();

//Pour des raisons de praticité on crée un tableau avec tous les post reçus
$max = count($_POST['article']);
$articles = $_POST['article'];
$quantites = $_POST['quant'];
$array = [];
for ($i = 0; $i < $max; $i++)
  {
    $array[$articles[$i]] = $quantites[$i];
  }
$array['nom'] = nettoyer($_POST['nom']);
$array['prenom'] = nettoyer($_POST['prenom']);
$array['adresse'] = nettoyer($_POST['adresse']);
$array['code_postal'] = nettoyer($_POST['code_postal']);
$array['ville'] = nettoyer($_POST['ville']);
$array['time'] = time();

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
//affichage de la commande et du formulaire de validation + calcul du prix
echo "<h2>Résumé de votre commande :</h2>
      <p><table style='background-color : white;'>
     <tr><td>Produit</td><td>Quantité</td><td>Prix</td></tr>";
if ($array['pcm']) {
  $prix = $array['pcm']*4.5;
  $total = $prix;
  echo "<tr><td>Crème de marron (pots)</td><td>{$array['pcm']}</td><td>$prix €</td></tr>";
  }
else $array['pcm'] = 0;
if ($array['ccm']) {
  $prix = $array['ccm']*50;
  $total = $total + $prix;
  echo "<tr><td>Crème de marron (carton)</td><td>{$array['ccm']}</td><td>$prix €</td></tr>";
  }
else $array['ccm'] = 0;
if ($array['pdc']) {
  $prix = $array['pdc']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Délice de châtaignes (pots)</td><td>{$array['pdc']}</td><td>$prix €</td></tr>";
  }
else $array['pdc'] = 0;
if ($array['cdc']) {
  $prix = $array['cdc']*50;
  $total = $total + $prix;
  echo "<tr><td>Délice de châtaignes (cartons)</td><td>{$array['cdc']}</td><td>$prix €</td></tr>";
  }
else $array['cdc'] = 0;
if ($array['pcn']) {
  $prix = $array['pcn']*4;
  $total = $total + $prix;
  echo "<tr><td>Châtaignes au naturel (pots)</td><td>{$array['pcn']}</td><td>$prix €</td></tr>";
  }
else $array['pcn'] = 0;
if ($array['pado']) {
  $prix = $array['pado']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Condiment à base d'Ail des ours.</td><td>{$array['pado']}</td><td>$prix €</td></tr>";
  }
else $array['pado'] = 0;
if ($array['pgg']) {
  $prix = $array['pgg']*4;
  $total = $total + $prix;
  echo "<tr><td>Gelée de groseille (pots)</td><td>{$array['pgg']}</td><td>$prix €</td></tr>";
  }
else $array['pgg'] = 0;
if ($array['bsc']) {
  $prix = $array['bsc']*5;
  $total = $total + $prix;
  echo "<tr><td>Sirop de cerise</td><td>{$array['bsc']}</td><td>$prix €</td></tr>";
  }
else $array['bsc'] = 0;
if ($array['tcal']) {
  $prix = $array['tcal']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Calament</td><td>{$array['tcal']}</td><td>$prix €</td></tr>";
  }
else $array['tcal'] = 0;
if ($array['tcam']) {
  $prix = $array['cdc']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Camomille</td><td>{$array['pcm']}</td><td>$prix €</td></tr>";
  }
else $array['tcam'] = 0;
if ($array['ttil']) {
  $prix = $array['ttil']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Tilleul</td><td>{$array['ttil']}</td><td>$prix €</td></tr>";
  }
else $array['ttil'] = 0;
if ($array['tasdl']) {
  $prix = $array['tasdl']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane au saut du lit</td><td>{$array['tasdl']}</td><td>$prix €</td></tr>";
  }
else $array['tasdl'] = 0;
if ($array['tdoedm']) {
  $prix = $array['tdoedm']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane des ogres et des moineaux</td><td>{$array['tdoedm']}</td><td>$prix €</td></tr>";
  }
else $array['tdoedm'] = 0;
if ($array['talhdg']) {
  $prix = $array['talhdg']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane à l'heure du goûter</td><td>{$array['talhdg']}</td><td>$prix €</td></tr>";
  }
else $array['talhdg'] = 0;
if ($array['tecel']) {
  $prix = $array['tecel']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane entre chien et loup</td><td>{$array['tecel']}</td><td>$prix €</td></tr>";
  }
else $array['tecel'] = 0;
if ($array['tpf']) {
  $prix = $array['tpf']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane premier frimas</td><td>{$array['tpf']}</td><td>$prix €</td></tr>";
  }
else $array['tpf'] = 0;
if ($array['tct']) {
  $prix = $array['tct']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane Cévennes tis'</td><td>{$array['tct']}</td><td>$prix €</td></tr>";
  }
else $array['tct'] = 0;
if ($array['tla']) {
  $prix = $array['tla']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane l'Acrobate</td><td>{$array['tla']}</td><td>$prix €</td></tr>";
  }
else $array['tla'] = 0;
if ($array['tplm']) {
  $prix = $array['tplm']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane prenons le maquis</td><td>{$array['tplm']}</td><td>$prix €</td></tr>";
  }
else $array['tplm'] = 0;
echo "<tfoot style='border : medium solid #000000;
    border-collapse : collapse;
    width : 100%;
    margin : auto;'><tr><td>Total :</td><td></td><td>$total €</td></tr></tfoot></table> 
    <p>Adresse de livraison : {$array['nom']} {$array['prenom']}, {$array['adresse']} {$array['code_postal']} {$array['ville']}
    <p><form method='post' action='commande-effectuee.php'><input type='submit' value='Confirmer la commande'></form>";
//l'input caché 'com' permet de reconnaître qu'une commande a bien été faite <input type='hidden' name='com' value='1'> (retiré)
$array['total'] = $total;
$_SESSION['array'] = $array; //On ajoute les informations de commande à la session
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
