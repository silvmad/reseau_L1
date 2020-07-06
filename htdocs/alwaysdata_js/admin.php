<?php
session_start();
if (isset($_SESSION['mdp_a'])) $_POST['mdp'] = $_SESSION['mdp_a'];
$mdp = "admin";
if (!isset($_POST['mdp']) || (isset($_POST['mdp']) && $_POST['mdp'] != $mdp)) {
?>
<form method='post' action='admin.php'>Mot de passe : <input type='password' name='mdp'><br>
<input type='submit'>
</form>
<?php
}

else { 
session_start();
$_SESSION['mdp_a'] = $_POST['mdp'];
$server = "mysql-assoagricoulis.alwaysdata.net";
$user = "176690_agri";
$passe = "mdpagricoulis";
$base = "assoagricoulis_site";
$con = mysqli_connect($server, $user, $passe, $base);
if (! $con) echo "Pas de connexion : " . mysqli_connect_error();

if (isset($_POST['suppr'])) mysqli_query($con, "DELETE FROM assoagricoulis_site.commandes WHERE num='{$_POST['num']}';");
if (isset($_POST['nouveau_statut']))
   mysqli_query($con, "UPDATE assoagricoulis_site.commandes SET statut='{$_POST['nouveau_statut']}' WHERE num='{$_POST['num']}';");
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
    <div id='titre' style="float : none; background-color : rgba(28, 129, 158, 0.8);"><a href=index.php>Agricoulis</a></div>
    <div id="soustitre">Une exploitation agricole collective en Cévennes.</div>
    </div>

<div id="menu">
	<button class="menu" onclick="aff('comm_cours')">Commandes en cours</button><br><br>
	<button class="menu" onclick="aff('comm_ter')">Commandes terminées</button>
</div>

    <div id="corps">
    
    <div id="index"><h2>Espace d'administration</h2></div>
<!--En cours-->
    <div id="comm_cours">
    <h2>Commandes en cours</h2>
<?php
$res_cours = mysqli_query($con, "SELECT * FROM assoagricoulis_site.commandes WHERE (statut='Attente de paiement' OR statut='En cours de préparation');");
if (!$res_cours) echo "<p>Problème d'accès à la base de données, réessayez plus tard";
$nb_commandes = mysqli_num_rows($res_cours);
while ($assoc = mysqli_fetch_assoc($res_cours))
{
echo "<p><table>
     <thead style='border : medium solid #000000;
    border-collapse : collapse;
    width : 100%;
    margin : auto;'><tr><td>Produit</td><td>Quantité</td><td>Prix</td></tr></thead>";
$total = 0;
if ($assoc['pcm']) {
  $prix = $assoc['pcm']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Crème de marron (pots)</td><td>{$assoc['pcm']}</td><td>$prix</td></tr>";
  }
if ($assoc['ccm']) {
  $prix = $assoc['ccm']*50;
  $total = $total + $prix;
  echo "<tr><td>Crème de marron (carton)</td><td>{$assoc['ccm']}</td><td>$prix</td></tr>";
  }
if ($assoc['pdc']) {
  $prix = $assoc['pdc']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Délice de châtaignes (pots)</td><td>{$assoc['pdc']}</td><td>$prix</td></tr>";
  }
if ($assoc['cdc']) {
  $prix = $assoc['cdc']*50;
  $total = $total + $prix;
  echo "<tr><td>Délice de châtaignes (cartons)</td><td>{$assoc['cdc']}</td><td>$prix</td></tr>";
  }
if ($assoc['pcn']) {
  $prix = $assoc['pcn']*4;
  $total = $total + $prix;
  echo "<tr><td>Châtaignes au naturel (pots)</td><td>{$assoc['pcn']}</td><td>$prix</td></tr>";
  }
if ($assoc['pado']) {
  $prix = $assoc['pado']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Condiment à base d'Ail des ours.</td><td>{$assoc['pado']}</td><td>$prix</td></tr>";
  }
if ($assoc['pgg']) {
  $prix = $assoc['pgg']*4;
  $total = $total + $prix;
  echo "<tr><td>Gelée de groseille (pots)</td><td>{$assoc['pgg']}</td><td>$prix</td></tr>";
  }
if ($assoc['bsc']) {
  $prix = $assoc['bsc']*5;
  $total = $total + $prix;
  echo "<tr><td>Sirop de cerise</td><td>{$assoc['bsc']}</td><td>$prix</td></tr>";
  }
if ($assoc['tcal']) {
  $prix = $assoc['tcal']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Calament</td><td>{$assoc['tcal']}</td><td>$prix</td></tr>";
  }
if ($assoc['tcam']) {
  $prix = $assoc['cdc']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Camomille</td><td>{$assoc['pcm']}</td><td>$prix</td></tr>";
  }
if ($assoc['ttil']) {
  $prix = $assoc['ttil']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Tilleul</td><td>{$assoc['ttil']}</td><td>$prix</td></tr>";
  }
if ($assoc['tasdl']) {
  $prix = $assoc['tasdl']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane au saut du lit</td><td>{$assoc['tasdl']}</td><td>$prix</td></tr>";
  }
if ($assoc['tdoedm']) {
  $prix = $assoc['tdoedm']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane des ogres et des moineaux</td><td>{$assoc['tdoedm']}</td><td>$prix</td></tr>";
  }
if ($assoc['talhdg']) {
  $prix = $assoc['talhdg']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane à l'heure du goûter</td><td>{$assoc['talhdg']}</td><td>$prix</td></tr>";
  }
if ($assoc['tecel']) {
  $prix = $assoc['tecel']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane entre chien et loup</td><td>{$assoc['tecel']}</td><td>$prix</td></tr>";
  }
if ($assoc['tpf']) {
  $prix = $assoc['tpf']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane premier frimas</td><td>{$assoc['tpf']}</td><td>$prix</td></tr>";
  }
if ($assoc['tct']) {
  $prix = $assoc['tct']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane Cévennes tis'</td><td>{$assoc['tct']}</td><td>$prix</td></tr>";
  }
if ($assoc['tla']) {
  $prix = $assoc['tla']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane l'Acrobate</td><td>{$assoc['tla']}</td><td>$prix</td></tr>";
  }
if ($assoc['tplm']) {
  $prix = $assoc['tplm']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane prenons le maquis</td><td>{$assoc['tplm']}</td><td>$prix</td></tr>";
  }
echo "<tbody style='border : medium solid #000000;
    border-collapse : collapse;
    width : 100%;
    margin : auto;'><tr><td>Total :</td><td></td><td>$total</td></tr></tbody>";
echo "<tbody style='border : medium solid #000000;
    border-collapse : collapse;
    width : 100%;
    margin : auto;'><tr><td>Adresse de livraison</td><td colspan='2'>{$assoc['nom']} {$assoc['prenom']}, {$assoc['adresse']} {$assoc['code_postal']} {$assoc['ville']}</td></tr></tbody>";
echo "<tbody style='border : medium solid #000000;
    border-collapse : collapse;
    width : 100%;
    margin : auto;'><tr><td>Statut</td><td colspan='2' style='text-align:center'>{$assoc['statut']}</td></tr></tbody></table> ";
echo "Changer le statut de la commande 
<form method='post' action='admin.php'>
  <select name='nouveau_statut'>
    <option></option>
    <option value='Attente de paiement'>Attente de paiement</option>
    <option value='En cours de préparation'>En cours de préparation</option>
    <option value='Envoyée'>Envoyée</option>
  </select>
  <input type='hidden' name='num' value='{$assoc['num']}'>
  <input type='hidden' name='page' value='en_cours'>
  <input type='checkbox' name='suppr'>Supprimer la commande
  <input type='submit' value='Enregistrer'>
</form>";
}
?>
    </div>

<!--Terminées-->
    <div id="comm_ter">
    <h2>Commandes terminées</h2>
<?php
$res_ter = mysqli_query($con, "SELECT * FROM assoagricoulis_site.commandes WHERE statut='Envoyée';");
if (!$res_ter) echo "<p>Problème d'accès à la base de données, réessayez plus tard";
$nb_commandes = mysqli_num_rows($res_ter);
while ($assoc = mysqli_fetch_assoc($res_ter))
{
echo "<p><table>
     <thead style='border : medium solid #000000;
    border-collapse : collapse;
    width : 100%;
    margin : auto;'><tr><td>Produit</td><td>Quantité</td><td>Prix</td></tr></thead>";
$total = 0;
if ($assoc['pcm']) {
  $prix = $assoc['pcm']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Crème de marron (pots)</td><td>{$assoc['pcm']}</td><td>$prix</td></tr>";
  }
if ($assoc['ccm']) {
  $prix = $assoc['ccm']*50;
  $total = $total + $prix;
  echo "<tr><td>Crème de marron (carton)</td><td>{$assoc['ccm']}</td><td>$prix</td></tr>";
  }
if ($assoc['pdc']) {
  $prix = $assoc['pdc']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Délice de châtaignes (pots)</td><td>{$assoc['pdc']}</td><td>$prix</td></tr>";
  }
if ($assoc['cdc']) {
  $prix = $assoc['cdc']*50;
  $total = $total + $prix;
  echo "<tr><td>Délice de châtaignes (cartons)</td><td>{$assoc['cdc']}</td><td>$prix</td></tr>";
  }
if ($assoc['pcn']) {
  $prix = $assoc['pcn']*4;
  $total = $total + $prix;
  echo "<tr><td>Châtaignes au naturel (pots)</td><td>{$assoc['pcn']}</td><td>$prix</td></tr>";
  }
if ($assoc['pado']) {
  $prix = $assoc['pado']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Condiment à base d'Ail des ours.</td><td>{$assoc['pado']}</td><td>$prix</td></tr>";
  }
if ($assoc['pgg']) {
  $prix = $assoc['pgg']*4;
  $total = $total + $prix;
  echo "<tr><td>Gelée de groseille (pots)</td><td>{$assoc['pgg']}</td><td>$prix</td></tr>";
  }
if ($assoc['bsc']) {
  $prix = $assoc['bsc']*5;
  $total = $total + $prix;
  echo "<tr><td>Sirop de cerise</td><td>{$assoc['bsc']}</td><td>$prix</td></tr>";
  }
if ($assoc['tcal']) {
  $prix = $assoc['tcal']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Calament</td><td>{$assoc['tcal']}</td><td>$prix</td></tr>";
  }
if ($assoc['tcam']) {
  $prix = $assoc['cdc']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Camomille</td><td>{$assoc['pcm']}</td><td>$prix</td></tr>";
  }
if ($assoc['ttil']) {
  $prix = $assoc['ttil']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Tilleul</td><td>{$assoc['ttil']}</td><td>$prix</td></tr>";
  }
if ($assoc['tasdl']) {
  $prix = $assoc['tasdl']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane au saut du lit</td><td>{$assoc['tasdl']}</td><td>$prix</td></tr>";
  }
if ($assoc['tdoedm']) {
  $prix = $assoc['tdoedm']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane des ogres et des moineaux</td><td>{$assoc['tdoedm']}</td><td>$prix</td></tr>";
  }
if ($assoc['talhdg']) {
  $prix = $assoc['talhdg']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane à l'heure du goûter</td><td>{$assoc['talhdg']}</td><td>$prix</td></tr>";
  }
if ($assoc['tecel']) {
  $prix = $assoc['tecel']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane entre chien et loup</td><td>{$assoc['tecel']}</td><td>$prix</td></tr>";
  }
if ($assoc['tpf']) {
  $prix = $assoc['tpf']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane premier frimas</td><td>{$assoc['tpf']}</td><td>$prix</td></tr>";
  }
if ($assoc['tct']) {
  $prix = $assoc['tct']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane Cévennes tis'</td><td>{$assoc['tct']}</td><td>$prix</td></tr>";
  }
if ($assoc['tla']) {
  $prix = $assoc['tla']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane l'Acrobate</td><td>{$assoc['tla']}</td><td>$prix</td></tr>";
  }
if ($assoc['tplm']) {
  $prix = $assoc['tplm']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane prenons le maquis</td><td>{$assoc['tplm']}</td><td>$prix</td></tr>";
  }
echo "<tbody style='border : medium solid #000000;
    border-collapse : collapse;
    width : 100%;
    margin : auto;'><tr><td>Total :</td><td></td><td>$total</td></tr></tbody>";
echo "<tbody style='border : medium solid #000000;
    border-collapse : collapse;
    width : 100%;
    margin : auto;'><tr><td>Adresse de livraison</td><td colspan='2'>{$assoc['nom']} {$assoc['prenom']}, {$assoc['adresse']} {$assoc['code_postal']} {$assoc['ville']}</td></tr></tbody>";
echo "<tbody style='border : medium solid #000000;
    border-collapse : collapse;
    width : 100%;
    margin : auto;'><tr><td>Statut</td><td colspan='2' style='text-align:center'>{$assoc['statut']}</td></tr></tbody></table> ";
echo "Changer le statut de la commande 
<form method='post' action='admin.php'>
  <select name='nouveau_statut'>
    <option></option>
    <option value='Attente de paiement'>Attente de paiement</option>
    <option value='En cours de préparation'>En cours de préparation</option>
    <option value='Envoyée'>Envoyée</option>
  </select>
  <input type='hidden' name='num' value='{$assoc['num']}'>
  <input type='hidden' name='page' value='termine'>
  <input type='checkbox' name='suppr'>Supprimer la commande
  <input type='submit' value='Enregistrer'>
</form>";
}
?>
    </div>

    </div><!--corps-->

    <div id="pied">
    </div>

    </div><!--page-->

    <script src="agricoulis.js"></script>
    <?php
    if ($_POST['page'] == 'en_cours') echo "<script>aff('comm_cours');</script>";
    if ($_POST['page'] == 'termine') echo "<script>aff('comm_ter');</script>";
    ?>
  </body>

</html>
<?php
}
?>
