<?php

// On charge la class générale dans le site internet
include('_Serveur/GestionSiteInternet.php');

// Paramètre Global Site Internet
$IDUTILISATEURS_WEB = 144;

// On charge la Connexion
$GestionSiteInternet = new GestionSiteInternet();
// On identifie le Site Internet
$GestionSiteInternet->Connexion($IDUTILISATEURS_WEB);


?>