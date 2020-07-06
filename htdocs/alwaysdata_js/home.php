<?php
session_start();
$login = $_SESSION['login'];
$id = $_SESSION['id'];
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
		else echo "<button class=\"head_bouton\" onclick=\"window.location.href ='index.php';\">Accueil</button>
		<br>
		<button class=\"head_bouton\" id=\"bouton_bas\" onclick=\"window.location.href ='creation-compte.php';\">S'inscrire</button>"
	     ?>
        
	  </div>
    <div id="soustitre">Une exploitation agricole collective en Cévennes.</div>
    </div>

    <div id="menu">
	<button class="menu" onclick="aff('nouv_comm')">Nouvelle commande</button><br><br>	
	<button class="menu" onclick="aff('comm_cours')">Commandes en cours</button><br><br>
	<button class="menu" onclick="aff('comm_ter')">Commandes terminées</button><br><br>
    </div>

    <div id="corps">

	<div id="index">
	 <?php
	 if (isset($login)) echo "<h2>Bienvenue, $login !</h2>";
         else echo "<p>Vous vous êtes perdu on dirait !<br> <a href='index.php'>Retour à l'accueil</a>";
	 ?>
	</div>

	<div id="nouv_comm">
<h2>Effectuer une commande</h2>
<form method='post' action='confirmer_commande.php'>

<table>
<tr><td>Produit</td><td>Prix unitaire</td><td>Quantité</td></tr>
<tr id="champ">
 <td><select name='article[]' onchange='prix(this);'>
  <option></option>
  <option label='4.5' value='pcm'>Crème de marron (pots de 400g)</option>
  <option label='50' value='ccm'>Crème de marron (carton de 12 pots)</option>
  <option label='4.5' value='pdc'>Délice de châtaignes (pots de 400g)</option>
  <option label='50' value='cdc'>Délice de châtaignes (carton de 12 pots)</option>
  <option label='4' value='pcn'>Châtaignes au naturel (pots de 250g)</option>
  <option label='4.5' value='pado'>Condiment à base d'ail des ours (pots de 200g)</option>
  <option label='4' value='pgg'>Gelée de groseille (pots de 245g)</option>
  <option label='5' value='bsc'>Sirop de cerise (50cl)</option>
  <option label='3' value='tcal'>Tisane Calament (20g)</option>
  <option label='3' value='tcam'>Tisane Camomille matricaire (15g)</option>
  <option label='3' value='ttil'>Tisane Tilleul (25g)</option>
  <option label='3.5' value='tasdl'>Tisane Au saut du lit (20g)</option>
  <option label='3.5' value='tdoedm'>Tisane Des ogres et des moineaux (20g)</option>
  <option label='3.5' value='talhdg'>Tisane A l'heure du goûter (20g)</option>
  <option label='3.5' value='tecel'>Tisane Entre chien et loup (20g)</option>
  <option label='3.5' value='tpf'>Tisane Premier frimas (20g)</option>
  <option label='3.5' value='tct'>Tisane Cévennes tis' (20g)</option>
  <option label='4.5' value='tla'>Tisane L'acrobate (30g)</option>
  <option label='3.5' value='tplm'>Tisane Prenons le maquis (25g)</option>
  </select>
 </td>
 <td class="prix">
 </td>
 <td>
  <input type='number' value='1' min='0' name='quant[]'>
</td>
</tr>
</table>
<p><button type='button' id="add">Ajouter ligne</button>
<p>Coordonnées :
<p><input type='text' name='nom' placeholder='Nom'> &nbsp <input type='text' name='prenom' placeholder='Prénom'>
<p><input type='text' name='adresse' placeholder="Numéro, Rue">
<input type='text' name='code_postal' placeholder="Code postal"> &nbsp <input type='text' name='ville' placeholder='Ville'>
<p><input type='submit' value='Commander'>
</form>
	</div>

	<div id="comm_cours">

<?php
$server = "mysql-assoagricoulis.alwaysdata.net";
$user = "176690_agri";
$passe = "mdpagricoulis";
$base = "assoagricoulis_site";
$con = mysqli_connect($server, $user, $passe, $base);
if (! $con) echo "Pas de connexion : " . mysqli_connect_error();

//On recherche dans la base les commandes en attente de paiement ou en cours de préparation
$res_cours = mysqli_query($con, "SELECT * FROM assoagricoulis_site.commandes WHERE id='$id'AND  (statut='Attente de paiement' OR statut='En cours de préparation');");
if (!$res_cours) echo "<p>Problème d'accès à la base de données, réessayez plus tard";

$nb_commandes = mysqli_num_rows($res_cours);
//On les affiche une par une
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
  echo "<tr><td>Crème de marron (pots)</td><td>{$assoc['pcm']}</td><td>$prix €</td></tr>";
  }
if ($assoc['ccm']) {
  $prix = $assoc['ccm']*50;
  $total = $total + $prix;
  echo "<tr><td>Crème de marron (carton)</td><td>{$assoc['ccm']}</td><td>$prix €</td></tr>";
  }
if ($assoc['pdc']) {
  $prix = $assoc['pdc']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Délice de châtaignes (pots)</td><td>{$assoc['pdc']}</td><td>$prix €</td></tr>";
  }
if ($assoc['cdc']) {
  $prix = $assoc['cdc']*50;
  $total = $total + $prix;
  echo "<tr><td>Délice de châtaignes (cartons)</td><td>{$assoc['cdc']}</td><td>$prix €</td></tr>";
  }
if ($assoc['pcn']) {
  $prix = $assoc['pcn']*4;
  $total = $total + $prix;
  echo "<tr><td>Châtaignes au naturel (pots)</td><td>{$assoc['pcn']}</td><td>$prix €</td></tr>";
  }
if ($assoc['pado']) {
  $prix = $assoc['pado']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Condiment à base d'Ail des ours.</td><td>{$assoc['pado']}</td><td>$prix €</td></tr>";
  }
if ($assoc['pgg']) {
  $prix = $assoc['pgg']*4;
  $total = $total + $prix;
  echo "<tr><td>Gelée de groseille (pots)</td><td>{$assoc['pgg']}</td><td>$prix €</td></tr>";
  }
if ($assoc['bsc']) {
  $prix = $assoc['bsc']*5;
  $total = $total + $prix;
  echo "<tr><td>Sirop de cerise</td><td>{$assoc['bsc']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tcal']) {
  $prix = $assoc['tcal']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Calament</td><td>{$assoc['tcal']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tcam']) {
  $prix = $assoc['cdc']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Camomille</td><td>{$assoc['pcm']}</td><td>$prix €</td></tr>";
  }
if ($assoc['ttil']) {
  $prix = $assoc['ttil']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Tilleul</td><td>{$assoc['ttil']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tasdl']) {
  $prix = $assoc['tasdl']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane au saut du lit</td><td>{$assoc['tasdl']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tdoedm']) {
  $prix = $assoc['tdoedm']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane des ogres et des moineaux</td><td>{$assoc['tdoedm']}</td><td>$prix €</td></tr>";
  }
if ($assoc['talhdg']) {
  $prix = $assoc['talhdg']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane à l'heure du goûter</td><td>{$assoc['talhdg']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tecel']) {
  $prix = $assoc['tecel']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane entre chien et loup</td><td>{$assoc['tecel']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tpf']) {
  $prix = $assoc['tpf']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane premier frimas</td><td>{$assoc['tpf']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tct']) {
  $prix = $assoc['tct']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane Cévennes tis'</td><td>{$assoc['tct']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tla']) {
  $prix = $assoc['tla']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane l'Acrobate</td><td>{$assoc['tla']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tplm']) {
  $prix = $assoc['tplm']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane prenons le maquis</td><td>{$assoc['tplm']}</td><td>$prix €</td></tr>";
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


}
?>
	</div>

	<div id="comm_ter">
<?php
$res_ter = mysqli_query($con, "SELECT * FROM assoagricoulis_site.commandes WHERE id='$id'AND statut='Envoyée';");
if (!$res_ter) echo "<p>Problème d'accès à la base de données, réessayez plus tard";
$nb_commandes = mysqli_num_rows($res_ter);
while ($assoc = mysqli_fetch_assoc($res_ter))
{
 $n = count($assoc);
echo "<p><table>
     <thead style='border : medium solid #000000;
    border-collapse : collapse;
    width : 100%;
    margin : auto;'><tr><td>Produit</td><td>Quantité</td><td>Prix</td></tr></thead>";
$total = 0;
if ($assoc['pcm']) {
  $prix = $assoc['pcm']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Crème de marron (pots)</td><td>{$assoc['pcm']}</td><td>$prix €</td></tr>";
  }
if ($assoc['ccm']) {
  $prix = $assoc['ccm']*50;
  $total = $total + $prix;
  echo "<tr><td>Crème de marron (carton)</td><td>{$assoc['ccm']}</td><td>$prix €</td></tr>";
  }
if ($assoc['pdc']) {
  $prix = $assoc['pdc']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Délice de châtaignes (pots)</td><td>{$assoc['pdc']}</td><td>$prix €</td></tr>";
  }
if ($assoc['cdc']) {
  $prix = $assoc['cdc']*50;
  $total = $total + $prix;
  echo "<tr><td>Délice de châtaignes (cartons)</td><td>{$assoc['cdc']}</td><td>$prix €</td></tr>";
  }
if ($assoc['pcn']) {
  $prix = $assoc['pcn']*4;
  $total = $total + $prix;
  echo "<tr><td>Châtaignes au naturel (pots)</td><td>{$assoc['pcn']}</td><td>$prix €</td></tr>";
  }
if ($assoc['pado']) {
  $prix = $assoc['pado']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Condiment à base d'Ail des ours.</td><td>{$assoc['pado']}</td><td>$prix €</td></tr>";
  }
if ($assoc['pgg']) {
  $prix = $assoc['pgg']*4;
  $total = $total + $prix;
  echo "<tr><td>Gelée de groseille (pots)</td><td>{$assoc['pgg']}</td><td>$prix €</td></tr>";
  }
if ($assoc['bsc']) {
  $prix = $assoc['bsc']*5;
  $total = $total + $prix;
  echo "<tr><td>Sirop de cerise</td><td>{$assoc['bsc']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tcal']) {
  $prix = $assoc['tcal']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Calament</td><td>{$assoc['tcal']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tcam']) {
  $prix = $assoc['cdc']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Camomille</td><td>{$assoc['pcm']}</td><td>$prix €</td></tr>";
  }
if ($assoc['ttil']) {
  $prix = $assoc['ttil']*3;
  $total = $total + $prix;
  echo "<tr><td>Tisane Tilleul</td><td>{$assoc['ttil']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tasdl']) {
  $prix = $assoc['tasdl']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane au saut du lit</td><td>{$assoc['tasdl']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tdoedm']) {
  $prix = $assoc['tdoedm']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane des ogres et des moineaux</td><td>{$assoc['tdoedm']}</td><td>$prix €</td></tr>";
  }
if ($assoc['talhdg']) {
  $prix = $assoc['talhdg']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane à l'heure du goûter</td><td>{$assoc['talhdg']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tecel']) {
  $prix = $assoc['tecel']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane entre chien et loup</td><td>{$assoc['tecel']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tpf']) {
  $prix = $assoc['tpf']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane premier frimas</td><td>{$assoc['tpf']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tct']) {
  $prix = $assoc['tct']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane Cévennes tis'</td><td>{$assoc['tct']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tla']) {
  $prix = $assoc['tla']*4.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane l'Acrobate</td><td>{$assoc['tla']}</td><td>$prix €</td></tr>";
  }
if ($assoc['tplm']) {
  $prix = $assoc['tplm']*3.5;
  $total = $total + $prix;
  echo "<tr><td>Tisane prenons le maquis</td><td>{$assoc['tplm']}</td><td>$prix €</td></tr>";
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


}
?>
	</div>

    </div>

    <div id="pied">
    Contact : Association Agricoulis, Coulis 30450 Bonnevaux <br>
    <a href="mailto:assoagricoulis@laposte.net">assoagricoulis@laposte.net</a> 
    / 04 66 56 61 95
    </div>

    </div>
    <script src="agricoulis.js"></script>
  </body>

</html>
