<?php

// Config Locale
require "_config/_etude.php";

// Config Serveur
require "_Serveur/_fonctions.php";

session_start();

$message_non_envoye="erreur";
$message_envoye="ok";

// on teste si le formulaire a été soumis
if (!isset($_POST['message']))
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
			$_SESSION['retour']="Captcha non valide (1)";
			header("Location: index.php#contact");
			exit(); 
		}else{
			echo "Captcha non valide (1)";
			exit();
		}
	}else{
		if(SRV_AptitudeCaptcha($_POST["IDCaptcha-reponse"],$CAPTCHA_ClePublic,$CAPTCHA_ClePrive)!=""){
			if($Ajax==false){
				$_SESSION['retour']="Captcha non valide (2)";
				header("Location: index.php#contact");
				exit(); 
			}else{
				echo "Captcha non valide (2)";
				exit();
			}
		}
	}

	
	
	// Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
	if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error'] == 0)
	{
		// Testons si le fichier n'est pas trop gros
		if ($_FILES['monfichier']['size'] <= 7000000)
		{
				// Testons si l'extension est autorisée
				$infosfichier = pathinfo($_FILES['monfichier']['name']);
				$extension_upload = $infosfichier['extension'];
				$extensions_autorisees = array('pdf', 'doc', 'docx');
				if (in_array($extension_upload, $extensions_autorisees))
				{
						// On peut valider le fichier et le stocker définitivement
						$NomFichier='_upload/' . basename($_FILES['monfichier']['name']);
						$Fichier=basename($_FILES['monfichier']['name']);
						move_uploaded_file($_FILES['monfichier']['tmp_name'], '_upload/' . basename($_FILES['monfichier']['name']));
						$AvecPJ=true;
				}
		}else{
			if($Ajax==false){
				$_SESSION['retour']="Impossible d'envoyer le mail. La pièce jointe est trop lourde";
				header("Location: index.php#contact");
				exit();
			 }else{
				echo "Impossible d'envoyer le mail. La pièce jointe est trop lourde";
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
	$message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';
	$nom = utf8_decode($nom);
	$prenom = utf8_decode($prenom);
	$message = utf8_decode($message);
	$objet="Formulaire Contact - ".$_SERVER['HTTP_HOST'].' par '.$nom.' '.$prenom;
	
	require "_class/class.phpmailer.php"; 
	$mail = new PHPmailer(); 
	$mail->IsMail(); 
	$mail->IsHTML(true); 
	$mail->Host='localhost'; 
	$mail->SetFrom("postmaster@aptitude-logiciels.com","Contact Site Internet"); 
	$mail->AddAddress($Global['Email']); 
	$mail->AddReplyTo($email);      
	if($NomFichier!=""){
		$mail->AddAttachment($NomFichier);      
	}
	$mail->Subject=$objet; 
	$mail->Body='<html><body><head></head><body>'; 
	$mail->Body.='Bonjour,<br>Un message vient de vous &ecirc;tre envoy&eacute; par <b>'.$nom.' '.$prenom.'</b> depuis votre site internet<br><br>'; 
	$mail->Body.='Voici les informations : <br>'; 
	$mail->Body.='<b>Nom</b> : '.$nom.'<br>'; 
	$mail->Body.='<b>Pr&eacute;nom</b> : '.$prenom.'<br>'; 
	$mail->Body.='<b>Email</b> : '.$email.'<br>'; 
	$mail->Body.='<b>Message</b> : <br>'.($message).'<br><br><br>Cordialement,<br>Aptitude Logiciels'; 
	$mail->Body.='</body></html>'; 

	if(!$mail->Send()){ //Teste si le return code est ok. 
	  $erreur= $mail->ErrorInfo; //Affiche le message d'erreur (ATTENTION:voir section 7) 
	  if($Ajax==false){
		$_SESSION['retour']="Erreur lors de l'envoi : ".$erreur;
		header("Location: index.php#contact");
		exit();
	 }else{
		echo "Erreur lors de l'envoi : ".$erreur;
	 }
	} 
	else{      
	  if($Ajax==false){
		$_SESSION['retour']="ok";
		header("Location: index.php#contact");
		exit();
	 }else{
		echo "ok";
	 }
	} 
	unset($mail); 
}
?>
