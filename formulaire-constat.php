<?php

// Config Locale
require "_config/_etude.php";

// Config Serveur
require "_Serveur/_fonctions.php";

session_start();

$message_non_envoye="erreur";
$message_envoye="ok";

// on teste si le formulaire a été soumis
if (!isset($_POST['constat']))
{
	// formulaire non envoyé
	echo "Erreur lors de l'envoi";
}
else
{	

	$NomFichier="";
	$Ajax=false;
	$AvecPJ=false;
	
	if(isset($_POST['ajax'])){
		$Ajax=true;
	}

	if(!isset($_POST['IDCaptcha-reponse'])){
		if($Ajax==false){
			$_SESSION['retour_constat']="Captcha non valide (1)";
			header("Location: index.php#constatform");
			exit(); 
		}else{
			echo "Captcha non valide (1)";
			exit();
		}
	}else{
		if(SRV_AptitudeCaptcha($_POST["IDCaptcha-reponse"],$CAPTCHA_ClePublic,$CAPTCHA_ClePrive)!=""){
			if($Ajax==false){
				$_SESSION['retour_constat']="Captcha non valide (2)";
				header("Location: index.php#constatform");
				exit(); 
			}else{
				echo "Captcha non valide (2)";
				exit();
			}
		}
	}
	
	
	function Rec($text)
	{
		$text = htmlspecialchars(trim($text), ENT_QUOTES);
		if (1 === get_magic_quotes_gpc())
		{
			$text = stripslashes($text);
		}
 
		$text = nl2br($text);
		return $text;
	};
	
	$nom     = (isset($_POST['nom']))     ? Rec($_POST['nom'])     : '';
	$prenom     = (isset($_POST['prenom']))     ? Rec($_POST['prenom'])     : '';
	$email   = (isset($_POST['email']))   ? Rec($_POST['email'])   : '';
	$enseigne   = (isset($_POST['enseigne']))   ? Rec($_POST['enseigne'])   : '';
	$SIRET   = (isset($_POST['SIRET']))   ? Rec($_POST['SIRET'])   : '';
	$adresse   = (isset($_POST['adresse']))   ? Rec($_POST['adresse'])   : '';
	$cp   = (isset($_POST['cp']))   ? Rec($_POST['cp'])   : '';
	$ville   = (isset($_POST['ville']))   ? Rec($_POST['ville'])   : '';
	$tel = (isset($_POST['tel'])) ? Rec($_POST['tel']) : '';
	$constat = (isset($_POST['constat'])) ? Rec($_POST['constat']) : '';
	$lieu = (isset($_POST['lieu'])) ? Rec($_POST['lieu']) : '';
	$nom = utf8_decode($nom);
	$enseigne = utf8_decode($enseigne);
	$adresse = utf8_decode($adresse);
	$prenom = utf8_decode($prenom);
	$message = utf8_decode($message);
	$lieu = utf8_decode($lieu);
	$ville = utf8_decode($ville);
	$constat = utf8_decode($constat);
	$objet="Formulaire Constat - ".$_SERVER['HTTP_HOST'].' par '.$nom.' '.$prenom;
	
	require "_class/class.phpmailer.php"; 
	$mail = new PHPmailer(); 
	$mail->IsMail(); 
	$mail->IsHTML(true); 
	$mail->Host='localhost'; 
	$mail->SetFrom("postmaster@aptitude-logiciels.com","Constat Site Internet"); 
	$mail->AddAddress($Global['Email']); 
	$mail->AddReplyTo($email);      
	if($NomFichier!=""){
		$mail->AddAttachment($NomFichier);      
	}
	$mail->Subject=$objet; 
	$mail->Body='<html><body><head></head><body>'; 
	$mail->Body.='Bonjour,<br>Une demande de constat vient de vous &ecirc;tre envoy&eacute; par <b>'.$nom.' '.$prenom.'</b> depuis votre site internet<br><br>'; 
	$mail->Body.='Voici les informations : <br>'; 
	$mail->Body.='<b>Nom</b> : '.$nom.'<br>'; 
	$mail->Body.='<b>Pr&eacute;nom</b> : '.$prenom.'<br>'; 
	$mail->Body.='<b>Email</b> : '.$email.'<br>'; 
	if($enseigne!=""){
		$mail->Body.='<b>Soci&eacute;t&eacute;</b> : '.$enseigne.' &nbsp;'.$SIRET.'<br>'; 
	}
	if($adresse!=""){
		$mail->Body.='<b>Adresse</b> : '.$adresse.'<br>'; 
	}
	$mail->Body.='<b>Ville</b> : '.$cp.' '.$ville.'<br>'; 
	$mail->Body.='<b>T&eacute;l&eacute;phone</b> : '.$tel.'<br>'; 
	$mail->Body.='<b>Infos Constat</b> : '.$constat.'<br>'; 
	$mail->Body.='<b>Lieu Constat</b> : '.$lieu.'<br><br><br>Cordialement,<br>Aptitude Logiciels'; 
	$mail->Body.='</body></html>'; 

	if(!$mail->Send()){ //Teste si le return code est ok. 
	  $erreur= $mail->ErrorInfo; //Affiche le message d'erreur (ATTENTION:voir section 7) 
	  if($Ajax==false){
		$_SESSION['retour_constat']="Erreur lors de l'envoi : ".$erreur;
		header("Location: index.php#constatform");
		exit();
	 }else{
		echo "Erreur lors de l'envoi : ".$erreur;
	 }
	} 
	else{      
	  if($Ajax==false){
		$_SESSION['retour_constat']="ok";
		header("Location: index.php#constatform");
		exit();
	 }else{
		echo "ok";
	 }
	} 
	unset($mail); 
}
?>
