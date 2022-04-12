<?php
$LogActif=true;


if(isset($_POST['dossier'])){
	$Nom=$_POST['nom'];
	$Prenom=$_POST['prenom'];
	require "_config/_etude.php";
	include('_config/_config.php'); // Classe
	
	$Telephone=$_POST['phone'];
	$Dossier=$_POST['dossier'];
	$Email=$_POST['email'];
	$Montant=$_POST['montant'];	
	$Nom=str_replace('\"', '', $Nom);
	$Prenom=str_replace('\"', '', $Prenom);
	
	
	echo $Paiement->PUBLIC_GenerePaiementSimple($Nom,$Prenom,$Montant,$Email,$Dossier,$Telephone,"");
}else{
	echo '<font color="red">Erreur lors de la pr&eacute;paration du paiement..</font>';
}

?>