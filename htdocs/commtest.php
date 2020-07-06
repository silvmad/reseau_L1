<?php
function nettoyer($x){
  if ($x){
  $x = trim($x);
  $x = stripslashes($x);
  $x = htmlspecialchars($x);
  }
return $x;
}
echo "pre<br>";
print_r($_POST);
$max = count($_POST['article']);
echo 'sizeof ok <br>';
$articles = $_POST['article'];
$quantites = $_POST['quant'];
echo 'ok -> crea array<br>';
$array = [];
echo 'array cree<br>';
for ($i = 0; $i < $max; $i++)
  {
    $array["{$articles[$i]}"] = $quantites[$i];
  }
echo 'boucle ok<br>';
$array['nom'] = nettoyer($_POST['nom']);
$array['prenom'] = nettoyer($_POST['prenom']);
$array['adresse'] = nettoyer($_POST['adresse']);
$array['code_postal'] = nettoyer($_POST['code_postal']);
$array['ville'] = nettoyer($_POST['ville']);
$array['time'] = time();
echo 'array fini<br>';
print_r($array);
echo "post";
?>;
