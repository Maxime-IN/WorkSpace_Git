<?php

// Configuration Globale
include('_config/_etude.php'); 
include('_Serveur/rgpd.php'); 
include('_Serveur/_fonctions.php');
include('_config/_config_client.php');

session_start();

?>

<!DOCTYPE html>
<html lang="fr">

  <head>
	<!-- Description Site Internet -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $Global['DescriptionSite']; ?>">
    <meta name="author" content="Aptitude Logiciels">
	<meta name="application-name" content="<?php echo $Global['URL']; ?>"/>

    <link rel="icon" type="image/png" href="img/favicon.png" />

    <title><?php echo $Global['TitreSite']; ?></title>
	
	<!-- SEO -->
	<meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo $Global['URL']; ?>">
    <meta property="og:locale" content="fr">
    <meta property="og:url" content="http://<?php echo $Global['URL']; ?>">
    <meta property="og:title" content="<?php echo $Global['TitreSite']; ?>">
    <meta property="og:description" content="<?php echo $Global['DescriptionSite']; ?>">

    <!-- Bootstrap Core CSS -->
    <link href="constant/bootstrap/css/bootstrap.min.css" rel="stylesheet">	
	
    <!-- Police -->
    <link href="constant/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="constant/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">	
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
	
    <!-- CSS -->
    <link href="css/base.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
	
	<!-- Captcha -->
	<script src="https://webservices.inthuiss.com/captcha/captcha.js"></script>
	<script src="https://webservices.inthuiss.com/commun/rgpd.js"></script>

		
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <a class="menu-toggle rounded" href="#">
      <i class="fas fa-bars"></i>
    </a>
    <nav id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="sidebar-brand">
          <a class="js-scroll-trigger" href="#page-top">Menu</a>
        </li>
        <li class="sidebar-nav-item">
          <a class="js-scroll-trigger" href="#page-top">Accueil</a>
        </li>
        <li class="sidebar-nav-item">
          <a class="js-scroll-trigger" href="#etude">Présentation</a>
        </li>
		<li class="sidebar-nav-item">
          <a class="js-scroll-trigger" href="#tarif">Tarif</a>
        </li>    		
        <li class="sidebar-nav-item">
          <a class="js-scroll-trigger" href="#paiement">Paiement</a>
        </li>
        <li class="sidebar-nav-item">
          <a class="js-scroll-trigger" href="#contact">Contact</a>
        </li>
      </ul>
    </nav>

    <!-- Header -->
    <header class="masthead">	
	  
      <div class="container text-center my-auto">
		<img src="img/marianne.png" class="img-fluid img-accueil" >
		<div class="message_fond2">
        <h1 class="mb-1"><?php echo $Global['AccrocheAccueil']; ?></h1>
        <h3 class="mb-5 rouge">
          <em><?php echo $Global['AccrocheAccueil_Bas']; ?>
		  </em>
        </h3>
		<?php 
		// Gestion Phrase Accroche 2
		if($Global['AccrocheAccueil_Bas2']!=""){
		?>
		<h5 class="mb-6">
          <em><?php echo $Global['AccrocheAccueil_Bas2']; ?>
		  </em>
        </h5>
		<?php } ?>		
        <a class="btn btn-primary btn-xl js-scroll-trigger" href="#paiement">Paiement en Ligne</a>
		</div>
      </div>
      <div class="overlay"></div>
    </header>

    <!-- Notre Etude -->
    <section class="content-section bg-light" id="etude">
      <div class="container">
        <div class="row">		  
          <div class="col-lg-10 mx-auto text-center">
              <h2><i class="fa fa-balance-scale"></i>&nbsp;&nbsp;<strong>ACTIVITÉS DE L'ÉTUDE</strong></h2><br>
		      <div class="row">
				  <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
					<span class="service-icon rounded-circle mx-auto mb-3">
					  <img src="img/icon_constat.png" alt="Constat" height="50px" width="50px">
					</span>
					<h4>
					 <strong>Constats</strong>
					</h4>
				  </div>
				  <div class="col-lg-2 col-md-6">
					<span class="service-icon rounded-circle mx-auto mb-3">
					  <img src="img/icon_conc.png" alt="Recouvrement" height="50px" width="50px">
					</span>
					<h4>
					  <strong>Consultations juridiques</strong>
					</h4>
				  </div>
				  <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
					<span class="service-icon rounded-circle mx-auto mb-3">
					  <img src="img/icon_signification.png" alt="Signification" width="50px">
					</span>
					<h4>
					  <strong>Significations</strong>
					</h4>
				  </div>
				  <div class="col-lg-2 col-md-6 mb-5 mb-md-0">
					<span class="service-icon rounded-circle mx-auto mb-3">
					  <img src="img/icon_execution.png" alt="Execution" height="50px" width="50px">
					</span>
					<h4>
					  <strong>Exécution</strong>
					</h4>
				  </div>
				  <div class="col-lg-2 col-md-6">
					<span class="service-icon rounded-circle mx-auto mb-3">
					  <img src="img/icon_recouvrement.png" alt="Recouvrement" height="50px" width="50px">
					</span>
					<h4>
					  <strong>Recouvrement forcé ou amiable</strong>
					</h4>
				  </div>
				  <div class="col-lg-2 col-md-6">
					<span class="service-icon rounded-circle mx-auto mb-3">
					  <img src="img/icon_actes.png" alt="Rédactions d'actes" height="50px" width="50px">
					</span>
					<h4>
					  <strong>Rédaction d'actes</strong>
					</h4>
				  </div>
			    </div>
			<br>            
		  </div>
		 
		  <div class="col-lg-12">
            <p class="lead">
			<strong>Les constats :</strong><br>
			Vous souhaitez vous protéger face à une situation conflictuelle ou constituer un dossier pour entamer une procédure judiciaire : pensez à faire réaliser un constat par un huissier de justice. Maître GARCIA vous conseillera sur l’utilité de son intervention selon la situation de fait et de droit que vous lui exposerez. La compétence territoriale de l’étude en matière de constat est nationale.<br>
			Quelques exemples : un constat peut notamment être utile si vous subissez un litige avec votre voisin, si vous souhaitez fournir la preuve du contenu d’une page Internet - d’un SMS - d'un message vocal, si vous souhaitez prouver l’état d’un bâtiment avant ou après la réalisation de travaux, démontrer la présentation ou non d’un enfant dans le cadre du droit de visite et d'hébergement, faire procéder à un état des lieux, justifier de l'affichage d'un permis de construire ou d'une déclaration préalable et bien d’autres situations...
			</p>
			<p class="lead">
			<strong>La signification des actes :</strong><br>
			L'étude peut intervenir pour signifier les actes dans la Sarthe (72), la Mayenne (53) et en Maine-et-Loire (49). Les décisions de justice doivent notamment être signifiées. De plus, tout document peut être signifié à toute personne. Maître GARCIA peut vous conseiller sur l’opportunité de son action en la matière. Si la signification d'une acte est opportune, elle se rendra au domicile ou sur le lieu de travail de la personne physique concernée ou bien au siège social de la société requise, afin de porter à la connaissance de cette personne un fait, un événement, un document, et le cas échéant afin de lui réclamer un impayé.
			</p>
			<p class="lead">
			<strong>L'exécution des décisions de justice et de tout autre titre exécutoire :</strong><br>
			Le juge a fait droit à vos demandes ; votre adversaire, qui a perdu le procès ne s’exécute pas ? Vous pouvez transmettre votre décision de justice à l’étude de Maître GARCIA afin que votre jugement soit exécuté. L’exécution d’une décision de justice se traduit par l’action de votre huissier de justice qui met en œuvre les procédures de saisie adaptées à la situation patrimoniale et financière de votre débiteur. Un chèque impayé ? Maître GARCIA peut agir et délivrer elle-même un titre exécutoire pour engager la procédure de recouvrement forcé à l'encontre de votre débiteur.
			</p>
			<p class="lead">
			<strong>Le recouvrement :</strong><br>
			Un impayé ? Vous souhaitez procéder au recouvrement des sommes qui vous sont dues ? Vous pouvez confier votre dossier à l’étude de Maître GARCIA. Vous jugerez de l’opportunité de faire procéder au recouvrement amiable ou judiciaire de votre créance à la suite des conseils qui vous seront apportés par Maître GARCIA. Une procédure judiciaire implique que le juge "valide" votre créance envers un débiteur afin d'autoriser l'huissier de justice à effectuer des saisies à son encontre. Votre huissier de justice aura le droit, dans ce cadre judiciaire, de saisir les biens, les comptes bancaires, les salaires de votre débiteur. L’étude peut intervenir dans la Sarthe (72), la Mayenne (53) et en Maine-et-Loire (49) en matière de recouvrement judiciaire.
			<br><br>
			Si vous ne souhaitez pas de procédure judiciaire, et que vous préférez minimiser les frais de procédure tout en faisant intervenir un professionnel du recouvrement, vous pouvez aussi confier le recouvrement des sommes qui vous sont dues à l’étude de Maître GARCIA qui agira dans un cadre amiable ; le recouvrement amiable peut parfois s’avérer opportun et être souhaité par certains créanciers. La compétence en matière de recouvrement amiable est nationale.
			</p>
			<p class="lead">
			<strong>La consultation juridique :</strong><br>
			Les huissiers de justice reçoivent une formation juridique très riche, à la fois précise et variée au cours de leur cursus universitaire et durant leur vie professionnelle. Ils sont aussi des juristes de proximité accessibles. Si vous avez besoin d’un conseil juridique, Maître GARCIA peut vous recevoir à l'étude sur rendez-vous ; elle vous apportera son avis et ses conseils au vu des éléments de fait et de droit que vous lui exposerez. Vous aurez ainsi l’avis d’un professionnel qui vous guidera face à une situation pour laquelle vous vous posez bon nombre de questions (le coût moyen d'une consultation juridique d'une demi-heure  environ à l'étude de Maître GARCIA est de 60 euros HT).
			</p>
			<p class="lead">
			<strong>La rédaction d’actes :</strong><br>
			Le saviez-vous ? Votre huissier de justice peut rédiger divers actes et formalités juridiques tels que des : assignations (en paiement notamment), baux (bail d’habitation, bail dérogatoire...), requêtes, ruptures de PACS, sommations, reconnaissances de dettes…<br>
			Avez-vous pensé à demander à votre huissier de justice de rédiger une sommation de faire, de ne pas faire, de payer, adaptée à votre cas particulier ?<br>
			Cet acte peut régler purement et simplement votre litige ou vous permettre de constituer votre dossier en vue d’initier une procédure judiciaire à l’encontre de votre adversaire.<br>
			Maître GARCIA peut également rédiger une sommation interpellative afin de consigner la réponse de votre adversaire à une ou plusieurs questions posées. La réponse pourra vous servir de preuve notamment devant le juge. Renseignez-vous en contactant l’étude.<br>
			</p>
		  </div>		 	
		  <div class="col-lg-10 mx-auto text-center">
			  <br>
              <h2><i class="fa fa-balance-scale"></i>&nbsp;&nbsp;<strong>NOTRE COMPÉTENCE</strong></h2><br>
			  <p class="lead">En matière de recouvrement judiciaire et de signification d'actes, l’étude peut intervenir sur l'ensemble des communes des départements de la Sarthe (72) du Maine-et-loire (49) et de la Mayenne (53) .<br></p>	
		      <br><div class="center"><img class="img-fluid" src="img/Carte.png" alt="" height="300px"></div><br>
			  <p class="lead">En matière de recouvrement amiable ou de constats, l’étude peut intervenir sur l'ensemble du territoire national français.</p>	
		  </div>
		   <div class="col-lg-10 mx-auto text-center">
			  <br>
              <h2><i class="fa fa-balance-scale"></i>&nbsp;&nbsp;<strong>TARIFS</strong></h2><br>
			  <p class="lead">
			  Exception faite de ses interventions en matière de constat, de recouvrement amiable, de conseil ou d'autres activités dites "hors tarif", les activités de l'huissier de justice sont majoritairement soumises à un tarif unique fixé par décret. Le prix des prestations des huissiers de justice est identique quel que soit le client ou la zone géographique. Le tarif est soit fixe, soit proportionnel.<br>
			La loi n°2015-990 du 6 août 2015, les décrets n°2016-230 du 26 février 2016, n°2016-1369 du 12 octobre 2016 et n° 2020-179 du 28 février 2020 ainsi que les arrêtés des 26 février 2016, 27 février 2018 et du 28 février 2020 fixent les tarifs réglementés des huissiers de justice qui sont insérés dans le Code de commerce.
			Le détail du tarif est accessible sur l'<a target="_blank" href="https://www.legifrance.gouv.fr/jorf/id/JORFTEXT000041663389">Arrêté du 28 février 2020</a><br><br>
              En dehors des actes réglementés dans le tarif précité, l'huissier de justice fixe librement le coût de ses prestations s'agissant notamment : d'une intervention pour effectuer des constatations, des consultations juridiques, de la représentation à une audience de saisie des rémunérations, de la rédaction et de la signification d'une sommation interpellative, de la rédaction d'un acte sous seing privé.... En fonction des éléments que vous apporterez, un devis pourra vous être remis. N'hésitez pas à contacter l'étude pour apporter les précisions nécessaires qui permettront de vous communiquer le tarif correspondant à votre demande.
				<br></p>	
		     </div>
		  <?php if($Global['AvecFormulaireConstat']==true){			  
			$date = new DateTime();
			$DateFr= $date->format('d/m/Y'); 			  
		  ?>
		  <!-- Formulaire -->
		  <div class="col-lg-10 mx-auto text-center">
			<br><a name="constatform"></a>
            <h2><i class="fa fa-camera"></i>&nbsp;&nbsp;<strong>DEMANDER UN CONSTAT</strong></h2>
            <p class="lead mb-5">Rapide et direct, utilisez notre formulaire de demande de constat :<br><i>* Champs Obligatoires</i></p>
			<form method="post" action="formulaire-constat.php" name="form_constat" onsubmit="return Controle_Constat()" class="contact">
					<div id="messageconstat">
					<?php 
					if(isset($_SESSION['retour_constat'])){
						// Gestion du retour par POST.
						if($_SESSION['retour_constat']==""){
							// Déjà Envoyé
						}else{
							// Gestion de l'Erreur..
							if($_SESSION['retour_constat']!="ok"){
								echo '<div class="alert alert-danger" role="alert">
									 Impossible d\'envoyer le message : '.$_SESSION['retour_constat'].' 
									</div>';								
							}else{
								echo '<div class="alert alert-success" role="alert">
									  Message envoy&eacute; avec succ&egrave;s
									</div>';
							}
							$_SESSION['retour_constat']="";
						}
					}
					?>
					</div><br>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<input type="text" class="form-control input-form name" required="required" name="nom" placeholder="Nom *">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<input type="text" class="form-control input-form name" required="required" name="prenom" placeholder="Prénom *">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<input type="text" class="form-control input-form" name="enseigne" placeholder="Société">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<input type="text" class="form-control input-form" name="SIRET" placeholder="SIRET ou RCS">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<input type="text" class="form-control input-form" name="adresse" placeholder="Adresse">
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<input type="text" class="form-control input-form" required="required" name="cp" placeholder="Code Postal *">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<input type="text" class="form-control input-form" required="required" name="ville" placeholder="Ville *">
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<input type="text" class="form-control input-form" required="required" name="tel" placeholder="Téléphone *">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<input type="text" class="form-control input-form email " required="required" name="email" id="email" placeholder="Email *">
							</div>
						</div>						
						<div class="col-lg-12">
							<div class="form-group">
								<textarea name="constat" id="constat" class="form-control" required="required" rows="4" placeholder="Précisions sur la Date, Heure et informations sur le constat *"></textarea>
							</div>
						</div>							
						<div class="col-lg-12">
							<div class="form-group">
								<textarea name="lieu" id="lieu" class="form-control" required="required" rows="4" placeholder="Lieu du constat (ville, rue, code immeuble,...) *"></textarea>
							</div>
						</div>
						<div class="col-lg-12">
							<div id="CaptchaConstat"></div><br>
						</div>						
						<div class="col-lg-12">				
							<div align="center" class="form-group" ><button  id="constatbutton" disabled class="btn btn-primary button">Envoyer</button>
							</div>
						</div>
					</div>
			</form>
			<!-- Fin de Formulaire -->
		  <?php } ?>
        </div>			
		</div>
    </section>

    <!-- Paiement en ligne -->
    <section class="paiementcb" id="paiement">
      <div class="container text-center">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <h2><i class="fa fa-credit-card"></i>&nbsp;&nbsp;<strong>PAIEMENT EN LIGNE</strong></h2>
			<?php
			if(isset($_GET['etat'])){		
			?>
			<script type="text/javascript">
				window.onload=function(){
					window.location.href="#paiement";
				};
			</script>
			<?php
			include('_config/_config.php');
			echo '<div class="row " style="color:#000000"><div class="col-lg"><div class="form-group">';
			echo $Paiement->PUBLIC_RetourPaiement();
			
			echo '<center><a style="color: #000000" class="btn btn-primary" href="index.php#paiement" role="button"><b><i class="fa fa-external-link"></i>&nbsp;Refaire un Paiement</a></b></center></div></div></div>';
			
			}else{
			
			if(isset($_POST['dossier'])){
			
			// Création du Lien...
			// Dans le cas ou le javascript ne fonctionne pas...
			
			?>
			<div class="row " style="color:#000000"><div class="col-lg"><div class="form-group">
			<p class="lead text-center">Confirmation du Paiement</p><span color="#000000"> 
			<?php
				
				include ('prepai.php');
				echo '</span></div></div></div>';
				}else{
				
			?>
            <p class="lead mb-5">Pour effectuer un paiement en ligne sécurisé, munissez-vous du numéro de référence de votre dossier (10 caractères) et de votre carte de paiement.<br>
			<div id="messageerreur"></div>
			
			<!-- Formulaire Paiement -->
			<form action="#paiement" name="form_paiement" onsubmit="return Controle_Paiement()" class="form_paiement" method="POST">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<input type="text" class="form-control input-form name" name="nom" placeholder="Nom">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<input type="text" class="form-control input-form name" name="prenom" placeholder="Prénom">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<input type="text" class="form-control input-form name" name="phone" placeholder="Téléphone">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<input type="text" class="form-control input-form " name="dossier" placeholder="Numéro de Dossier">
					</div>
				</div>
				
				<div class="col-lg-12">
					<div class="form-group">
						<input type="text" class="form-control input-form email " name="email" placeholder="Email">
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="form-group">
						<input type="text" class="form-control input-form montant " name="montant" placeholder="Montant">
					</div>
				</div>
				<div class="col-lg-1">					
					<div class="form-group">
						<button class="btn btn-primary button" >Payer</button>
					</div>
				</div>
			</div>
			</form>
			<!-- Fin Formulaire Paiement -->
			<?php 
			}
			}				
			?>
			<br>
			<br>
			<a  class="btn btn-primary js-scroll-trigger" target="_blank" href="doc/rib.pdf"><i class="fa fa-file-pdf"></i>&nbsp;RIB</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a  class="btn btn-primary js-scroll-trigger" target="_blank" href="doc/odv.pdf"><i class="fa fa-file-pdf"></i>&nbsp;Ordre de Virement</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact -->
    <section class="content-section bg-light" id="contact">
      <div class="container text-center">
        <div class="row">
          <div class="col-lg-10 mx-auto">
		     
		    <!-- Informations -->
			<h2><i class="fa fa-address-book"></i>&nbsp;&nbsp;<strong>CONTACT</strong></h2>
			<br>
			<div class="row">
			  <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
				<span class="service-icon rounded-circle mx-auto mb-3">
				  <img src="img/icon_adresse.png" alt="Adresse" height="50px" width="50px">
				</span>
				<h4>
				  <strong>Adresse</strong>
				</h4>
				<p class="text-faded mb-0"><?php echo $Global['NomEtude'];?><br><?php echo $Global['Adresse'];?><br><?php echo $Global['CPVille'];?></p>
			  </div>
			  <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
				<span class="service-icon rounded-circle mx-auto mb-3">
				  <img src="img/icon_contact.png" alt="Contact" height="50px" width="50px">
				</span>
				<h4>
				  <strong>Contact</strong>
				</h4>
				<p class="text-faded mb-0">Tel : <?php echo $Global['Telephone'];?><br>Port : 06 18 33 08 14<?php if($Global['Fax']!=""){ ?><br>Fax : <?php echo $Global['Fax']; }?><br><a href="mailto:<?php echo $Global['EmailSecure'];?>"><?php echo $Global['EmailSecure'];?></a></p>
			  </div>
			  <div class="col-lg-3 col-md-6 mb-5 mb-md-0">
				<span class="service-icon rounded-circle mx-auto mb-3">
				  <img src="img/icon_horaires.png" alt="Horaires" height="50px" width="50px">
				</span>
				<h4>
				  <strong>Accueil physique</strong>
				</h4>
				<p class="text-faded mb-0">Ouverture des bureaux au public :<br>
				Du lundi au jeudi :<br>14H - 17H<br>
				Le vendredi : 10H - 12H
				</p>
			  </div>
			  <div class="col-lg-3 col-md-6 mb-5 mb-md-0">
				<span class="service-icon rounded-circle mx-auto mb-3">
				  <img src="img/icon_support.png" alt="Horaires" height="50px" width="50px">
				</span>
				<h4>
				  <strong>Accueil téléphonique</strong>
				</h4>
				<p class="text-faded mb-0">
				Du lundi au jeudi : 9H - 12H et 14H - 17H<br>
				Le vendredi : 9H - 12H et 14H - 16H<br><br>
				</p>
			  </div>   			  
			</div>
			<p class="lead mb-5">
			  En dehors de ces horaires, pour un constat, un rendez-vous ou en cas d’urgence<br>vous pouvez composer le 06 18 33 08 14.  
			  </p>
		     <br>
		    <!-- Formulaire -->
            <h2><i class="fa fa-envelope"></i> MESSAGES & DOCUMENTS</h2>
            <p class="lead mb-5">Vous souhaitez nous adresser un acte à signifier :</p>
			<form enctype="multipart/form-data" method="post" action="formulaire-contact.php" name="form_contact" onsubmit="return Controle_Contact()" class="contact">
					<div id="messagecontact">
					<?php 
					if(isset($_SESSION['retour'])){
						// Gestion du retour par POST.
						if($_SESSION['retour']==""){
							// Déjà Envoyé
						}else{
							// Gestion de l'Erreur..
							if($_SESSION['retour']!="ok"){
								echo '<div class="alert alert-danger" role="alert">
									 Impossible d\'envoyer le message : '.$_SESSION['retour'].' 
									</div>';								
							}else{
								echo '<div class="alert alert-success" role="alert">
									  Message envoy&eacute; avec succ&egrave;s
									</div>';
							}
							$_SESSION['retour']="";
						}
					}
					?>
					</div><br>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<input type="text" class="form-control input-form name" required="required" name="nom" placeholder="Nom">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<input type="text" class="form-control input-form name" name="prenom" placeholder="Prénom">
							</div>
						</div>
						
						<div class="col-lg-12">
							<div class="form-group">
								<input type="text" class="form-control input-form email " required="required" name="email" placeholder="Email">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<input type="file" class="form-control input-form file " name="monfichier" placeholder="Pièce Jointe">
								(Fichier PDF et Word avec un poid maximal de 5 Mo)
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<textarea name="message" id="message" class="form-control" required="required" rows="8" placeholder="Votre message"></textarea>
							</div>
						</div>		
						<div class="col-lg-12">
							<div id="CaptchaContact"></div><br>
						</div>
						<div class="col-lg-12">
							<div align="center" class="form-group"><button id="contactbutton" disabled class="btn btn-primary button">Envoyer</button>
							</div>
						</div>
					</div>
			</form>
			<!-- Fin de Formulaire -->
			
          </div>
        </div>	   
      </div>
    </section>

    <!-- Carte -->
    <section id="contact" class="map">
      <div id="carte" height="100%"></div>
      <br/>
      <small>
        <a href="<?php echo $Global['LienCarte']; ?>"></a>
      </small>
    </section>

    <!-- Footer -->
    <footer class="footer text-center">
      <div class="container">    
        <p class="text-muted small mb-0">Copyright &copy; <a target="_blank" href="https://www.aptitude-logiciels.com">Aptitude Logiciels</a> <?php echo date('Y'); ?> - <a href="#" data-toggle="modal" data-target="#mentions" >Mentions L&eacute;gales</a></p>
      </div>
    </footer>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded js-scroll-trigger" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript -->
    <script src="constant/jquery/jquery.min.js"></script>
    <script src="constant/bootstrap/js/bootstrap.bundle.min.js"></script>
	
	<!-- Google maps -->
	<script>
	function initMap() {
		'use strict';
		var var_location = new google.maps.LatLng(<?php echo $Global['Latitude'] ?>, <?php echo $Global['Longitude'] ?>),

			var_mapoptions = {
				center: var_location,
				zoom: 14,
				fullscreenControl: true,
				scrollwheel: false
			},
			var_map = new google.maps.Map(document.getElementById("carte"),
					var_mapoptions),
			var_marker = new google.maps.Marker({
				position: var_location,
				map: var_map,
				title: "<?php echo $Global['TitreSite']; ?>"
			});
		var_marker.setMap(var_map);
	}
	AjouteCaptcha("CaptchaContact","contactbutton","7nBQ76qyXq8t4B6Y","btn btn-success btn-lg","fa");
	AjouteCaptcha("CaptchaConstat","constatbutton","7nBQ76qyXq8t4B6Y","btn btn-success btn-lg","fa");
	
	</script>	
	<script async defer
	  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCULb8aXWPyU9La6mmFG4LZBgCGeqvCA7w&callback=initMap">
	</script>

    <!-- Plugin JavaScript -->
    <script src="constant/jquery-easing/jquery.easing.min.js"></script>

    <!-- Scripts -->
    <script src="js/base.min.js"></script>
	
	<!-- Site Javascript -->
	<script  type="text/javascript" src="js/js.js"></script>
	
	<!-- Captcha RPGD -->
	<script>
   
    </script> 
	
	<!-- Modal Mentions -->
	<div class="modal fade" id="mentions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">Mentions L&eacute;gales</h4>
		  </div>
		  <div class="modal-body">
			<b>Site Internet</b><br>
			<u>Identification du D&eacute;clarant</u><br>
			<?php echo $Global['NomEtude']; ?><br>
			Siret : <?php echo $Global['SIRET']; ?>  Code APE : <?php echo $Global['APE']; ?><br>
			TVA Intracommunautaire : <?php echo $Global['NumTVA']; ?><br>
			Si&egrave;ge Social : <?php echo $Global['Adresse']; ?> - <?php echo $Global['CPVille']; ?><br>
			T&eacute;l&eacute;phone : <?php echo $Global['Telephone']; ?><br><br>
			
			<u>Contact technique et commercial</u><br>
			<?php echo getenv('Aptitude_Nom'); ?><br>
            <?php echo getenv('Aptitude_Adresse'); ?><br>
            <?php echo getenv('Aptitude_CPVILLE'); ?><br>
            RCS <?php echo getenv('Aptitude_RCS'); ?> – TVA <?php echo getenv('Aptitude_TVA'); ?><br>
			Contact : <a target="blank" href="http://www.aptitude-logiciels.com">Aptitude Logiciels</a><br><br>

			<u>Conception et r&eacute;alisation</u><br>
			<?php echo getenv('Aptitude_Nom'); ?><br>
            <?php echo getenv('Aptitude_Adresse'); ?><br>
            <?php echo getenv('Aptitude_CPVILLE'); ?><br>
            RCS <?php echo getenv('Aptitude_RCS'); ?> – TVA <?php echo getenv('Aptitude_TVA'); ?><br>
			Contact : <a target="blank" href="http://www.aptitude-logiciels.com">Aptitude Logiciels</a><br><br>

			Cr&eacute;dit photos sous licence sous licence CC BY 2.0<br>
			<br>
			<b>Politique de protection des données à caractère personnel</b>
		   <?php 
		   // Affichage des Mentions RGPD
		   RGPD_Mentions($Global['Email'],$Global['NomEtude']." - ".$Global['Adresse']." ".$Global['CPVille'],'white','u','btn btn-primary button','fa');
		   ?>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
		  </div>
		</div>
	  </div>
	</div>
	
	<?php 
	RPGD_Modal();
	?>
  </body>

</html>
