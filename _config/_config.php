<?php
global $ConnexionSQL;

require('monetico_paiement.php');
require('Secure.php');

// Connexion SQL..
$dbhost = "localhost";
$user = "garcia";
$password = "X5N4pmbEm5A9e4Hh5G9";
$db = "garcia";

try {
    $ConnexionSQL = new PDO('mysql:host='.$dbhost.';dbname='.$db.';charset=utf8', $user, $password);
	$ConnexionSQL->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
} catch (PDOException $e) {
    print "Erreur Connexion au Serveur SQL : " . $e->getMessage() . "<br/>";
    die();
	exit();
}

// Instance de Paiement..
$Paiement = new MoneticoSystem();     		
$Paiement->Configure("7469256","1E3B0526D8F470536225E5BB812391A238812291","selarlgarc","SELARL GARCIA SYLVIANIE","PRODUCTION","img/",false); 

?>

