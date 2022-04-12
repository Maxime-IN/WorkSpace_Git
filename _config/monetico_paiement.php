<?php

class MoneticoSystem{
	
	// G�n�ralit�s
	var $requete=array(); // Requ�te � envoy� au Serveur SPPLUS
	var $contrib="Paiement"; // Identification Service
	var $currency="EUR"; // Monnaie Utilis� �
	var $mode="PRODUCTION"; // TEST ou R�el -- 
	
	// Gestion du Paiement
	var $MONETICOPAIEMENT_VERSION="3.0"; 
	var $MONETICOPAIEMENT_URLSERVER="https://p.monetico-services.com/test/"; 
	var $MONETICOPAIEMENT_PHASE2BACK_RECEIPT="version=2\ncdr=%s"; 
	var $MONETICOPAIEMENT_PHASE2BACK_MACOK="0"; 
	var $MONETICOPAIEMENT_PHASE2BACK_MACNOTOK="1\n"; 
	var $MONETICOPAIEMENT_PHASE2BACK_FIELDS="%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*"; 
	var $MONETICOPAIEMENT_phase1go_fields="%s*%s*%s%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s*%s"; 
	var $MONETICOPAIEMENT_URLPAYMENT="paiement.cgi"; 
	var $MONETICOPAIEMENT_URLOK="http://huissier-garcia-72.fr/test/index.php?etat=OK";
	var $MONETICOPAIEMENT_URLKO="http://huissier-garcia-72.fr/test/index.php?etat=KO"; 
	var $DestinataireMail="intins.maxime@aptitude-logiciels.com"; 
	var $cleHmac = "1E3B0526D8F470536225E5BB812391A238812291";
	
	/**
     * @var []
     */
    private $responseInterfaceParameters;

	// Travail
	var $codeHTML; // Code HTML pour l'affichage du Lien
	var $Signature;
	var $LogActif=true;
	var $EnvoyerEmail=true;
	var $CheminImages="images/";
	var $receipt;
	
	// Param�tres ETUDE
	var $EPTNumber="";
	var $KeySite="";	// Certificat de Production
	var $CompanyCode="";	// Certificat de Production
	var $NomEtude="";
	
	// Informations Transaction
	var $Trans_NoDossier;
	var $Trans_MontantTransaction;
	var $Trans_IdentifiantTransaction;
	var $Trans_NomPrenom;
	var $Trans_Email;
	var $Trans_Telephone;
	var $Trans_TexteLibre;
	var $Trans_Montant;
	var $Trans_TexteEmail;
	var $AvecBoutonAccueil=true;
	var $contexte_commande;
	// Param�tres Visuels
	var $TempsRedirection=5;
	var $Message_Succes="Redirection vers le site dans 5 Secondes";
	var $Message_Erreur="Redirection vers le site dans 5 Secondes";
	var $Couleur="#000";
	
	//*********************************************************************//
	// SYSTEME DE CREATION DE TRANSACTION
	//*********************************************************************//
	
	function Configure($EPTNumber,$KeySite,$CompanyCode,$NomEtude,$mode="PRODUCTION",$CheminImages="images/",$AvecBoutonAccueil=true,$Couleur="#000"){
		$this->mode=$mode;
		$this->EPTNumber=$EPTNumber;
		$this->KeySite=$KeySite;
		$this->CompanyCode=$CompanyCode;
		$this->NomEtude=$NomEtude;
		$this->CheminImages=$CheminImages;
		$this->AvecBoutonAccueil=$AvecBoutonAccueil;
		$this->Couleur=$Couleur;
	}
	
	// Fonction : ChargeParametreDefaut
	// R�sum� : Charge les param�tres G�n�raux qui sont communs � toutes les �tudes
	function ChargeParametreDefaut() {
		$timeLocal = time();
		define ("CLE_MAC", $this->cleHmac);//initialisation de la cl�
		define ("MONETICOPAIEMENT_KEY", $this->KeySite);
		define ("MONETICOPAIEMENT_EPTNUMBER", $this->EPTNumber);
		define ("MONETICOPAIEMENT_VERSION", $this->MONETICOPAIEMENT_VERSION);
		define ("MONETICOPAIEMENT_URLSERVER", $this->MONETICOPAIEMENT_URLSERVER);
		define ("MONETICOPAIEMENT_URLOK", $this->MONETICOPAIEMENT_URLOK);
		define ("MONETICOPAIEMENT_URLKO", $this->MONETICOPAIEMENT_URLKO);
		define ("MONETICOPAIEMENT_COMPANYCODE", $this->CompanyCode);
		define ("MONETICOPAIEMENT_PHASE2BACK_RECEIPT",$this->MONETICOPAIEMENT_PHASE2BACK_RECEIPT);
		define ("MONETICOPAIEMENT_PHASE2BACK_MACOK",$this->MONETICOPAIEMENT_PHASE2BACK_MACOK);
		define ("MONETICOPAIEMENT_PHASE2BACK_MACNOTOK",$this->MONETICOPAIEMENT_PHASE2BACK_MACNOTOK);
		define ("MONETICOPAIEMENT_PHASE2BACK_FIELDS", $this->MONETICOPAIEMENT_PHASE2BACK_FIELDS);
		define ("MONETICOPAIEMENT_phase1go_fields", $this->MONETICOPAIEMENT_phase1go_fields);
		define ("MONETICOPAIEMENT_URLPAYMENT", $this->MONETICOPAIEMENT_URLPAYMENT);
	}
	
	// Fonction : NouvelleTransactionSimple
	// R�sum� : Effectue un Paiement Simple
	function NouvelleTransactionSimple($IdentifiantTransaction,$Montant,$Nom,$Dossier,$Email,$Travail,$DossierVisible,$TexteEmail) {
		// Variables
		$this->Trans_IdentifiantTransaction=$IdentifiantTransaction;
		$this->Trans_MontantTransaction=$IdentifiantTransaction;
		$this->Trans_NomPrenom=$Nom;
		$this->Trans_NoDossier=$Dossier;
		$this->Trans_Montant=$Montant;
		$this->Trans_Email=$Email;
		$this->Trans_TexteEmail=$TexteEmail;

		// cr�ation du nouveau parametre obligatoire (json avec infos utilisateur)
		$this->contexte_commande = array(
			"billing" => array(
	       	"addressLine1" => "31_Place_de_la_Republique",
       		"city" => "MAMERS",
   			"country" => "FR",
			"postalCode" => "72600",
	      ),
		);
		// Chargement par d�faut
		$this->ChargeParametreDefaut(); 		
	}
	
	// Fonction : Par_Email -> Mise en place du param�tre email
	function Par_Email($email){
		$this->Trans_Email=$email;
	}
	
		// Fonction : Par_Email -> Mise en place du param�tre email
	function Par_Telephone($phone){
		$this->Trans_Telephone=$this->NettoieTout($phone);
	}	


	// Fonction : Par_Info -> Mise en place du param�tre informations
	function Par_Info($information){
		$valeur = $this->NettoieTout($information);
		$this->Trans_TexteLibre=$valeur;
		$this->EcritLog("Info : ".$this->NettoieTout($information));
	}
	
	// Fonction : GenereLien
	// R�sum� : Renvoi le code HTML du lien
	function GenereLien() {	
		// On inclue la Classe Syst�me de Monetico
    	require_once("MoneticoPaiement_Ept.inc.php");
		$CleReference=$this->Trans_IdentifiantTransaction;
		$sDate = date("d/m/Y:H:i:s");
		$oEpt = new MoneticoPaiement_Ept("FR");     		   
		
		// G�n�ration du Code HTML
		$codeHTML='<form action="'.$oEpt->sUrlPaiement.'" method="post" id="PaymentRequest"><p>';

		//boucle d'affichage des inputs cach�s
		foreach ($this->getFormFields() as $key => $value) {
			$codeHTML .= ' <input type="hidden" name="'.$key.'" value="'.htmlentities($value).'"/>';
		}

		$codeHTML.='
			<input type="submit" name="bouton" id="bouton" value="Payer" />
			</p>
		</form>';
		$this->EcritLog("Nouvelle Transaction ".$CleReference);
		return $codeHTML;
	}

	//Gestion de la cl� HMAC 3dsecureV2
	   public function getFormFields()
    {
        $formFields = $this->getFormFieldsWithoutMac(); //param�tres sans HMAC
        $seal = $this->sealFields($formFields, CLE_MAC); //cryptage des param�tres pour cr�ation cl� HMAC
        $formFields['MAC'] = $seal; //alimentation du param�tre HMAC
        return $formFields;
    }
    //cr�ation du taleau de retour pour hmac
	 public function getFormFieldsWithoutMac()
    {
    	require_once("MoneticoPaiement_Ept.inc.php");
    	$oEpt = new MoneticoPaiement_Ept("FR");   
    	// MAC computation
		$contexte_commande_Trans = base64_encode(utf8_encode(json_encode($this->contexte_commande)));
        $formFields = [];
        // Payment terminal
        $formFields["TPE"] = htmlentities($oEpt->sNumero);
        $formFields["societe"] = htmlentities($oEpt->sCodeSociete);
        $formFields["lgue"] = htmlentities($oEpt->sLangue);
        $formFields["version"] = htmlentities($oEpt->sVersion);

        // Payment informations
        $formFields["reference"] = htmlentities($this->Trans_IdentifiantTransaction);
        $formFields["date"] = date("d/m/Y:H:i:s");
        $formFields["montant"] = htmlentities($this->Trans_Montant . $this->currency);
        $formFields["contexte_commande"] = htmlentities($contexte_commande_Trans);
     	$formFields["ThreeDSecureChallenge"] = htmlentities("no_preference");
     	$formFields["texte-libre"] = htmlentities($this->Trans_NoDossier . "-".$this->Trans_TexteLibre);
     	$formFields["url_retour_ok"] = $oEpt->sUrlOK.'&idtrans='.$this->Trans_IdentifiantTransaction;
     	$formFields["url_retour_err"] = $oEpt->sUrlKO.'&idtrans='.$this->Trans_IdentifiantTransaction;

        return $formFields;
    }
     function sealFields($fields, $key)
    {
        $stringToSeal = $this->getStringToSeal($fields);
        return $this->sealString($stringToSeal, $this->getUsableKey($key));
    }

     function validateSeal($fields, $key, $expectedSeal)
    {
        if ($fields !== null) {
            $computedSeal = $this->sealFields($fields, $key);
            return strtoupper($computedSeal) === strtoupper($expectedSeal) ? true : false;
        }
        return false;
    }
     function getStringToSeal($formFields)
    {
        // The string to be sealed is composed of all the form fields sent
        // 1. ordered alphabetically (numbers first, then capitalized letter, then other letters)
        // 2. represented using the format key=value
        // 3. separated by "*" character
        // Please refer to technical documentation for more details
        ksort($formFields);
        array_walk($formFields, function (&$item, $key) {
            $item = "$key=$item";
        });
        return implode('*', $formFields);
    }

     function sealString($stringToSeal, $key)
    {
        $MAC = hash_hmac(
            "sha1",
            $stringToSeal,
            hex2bin($key)
        );

        return $MAC;
    }

     function getUsableKey($key)
    {
        $hexStrKey = substr($key, 0, 38);
        $hexFinal = "" . substr($key, 38, 2) . "00";

        $cca0 = ord($hexFinal);

        if ($cca0 > 70 && $cca0 < 97)
            $hexStrKey .= chr($cca0 - 23) . substr($hexFinal, 1, 1);
        else {
            if (substr($hexFinal, 1, 1) == "M")
                $hexStrKey .= substr($hexFinal, 0, 1) . "0";
            else
                $hexStrKey .= substr($hexFinal, 0, 2);
        }

        return $hexStrKey;
    }	

	
	//*********************************************************************//
	// SYSTEME DE VERIFICATION DE TRANSACTION
	//*********************************************************************//	
	function VerifieRetour(){		
		
		$this->ChargeParametreDefaut();
		$receivedData = $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET : $_POST;
        //reception des parametres
        if (array_key_exists("MAC", $receivedData)) {
           //traitement du MAC
            $receivedSeal = $receivedData['MAC'];
            unset($receivedData['MAC']); // removes the MAC field itself
			// on v�rifie le sceau
            $isSealValidated = $this->validateSeal($receivedData, CLE_MAC, $receivedSeal);
            if ($isSealValidated) {
			//si valide -> 
			switch($receivedData['code-retour']) {
				case "Annulation" :
					// Paiement refus�
					// Ins�rez votre code ici (envoi d'email / mise � jour base de donn�es)
					// Attention : une autorisation peut toujours �tre d�livr�e pour ce paiement
					break;

				case "payetest":
					// Paiement accept� sur le serveur de test
					// Ins�rez votre code ici (envoi d'email / mise � jour base de donn�es)
					break;

				case "paiement":
					// Paiement accept� sur le serveur de production
					// Ins�rez votre code ici (envoi d'email / mise � jour base de donn�es)
					break;
				
				/*** SEULEMENT POUR LES PAIEMENTS FRACTIONNES ***/
				case "paiement_pf2":
				case "paiement_pf3":
				case "paiement_pf4":
					// Paiement accept� sur le serveur de production pour l'�ch�ance #N
					// Le code de retour est du type paiement_pf[#N]
					// Ins�rez votre code ici (envoi d'email / mise � jour base de donn�es)
					// Le montant du paiement pour cette �ch�ance se trouve dans $MoneticoPaiement_bruteVars['montantech']
					break;

				case "Annulation_pf2":
				case "Annulation_pf3":
				case "Annulation_pf4":
					// Paiement refus� sur le serveur de production pour l'�ch�ance #N
					// Le code de retour est du type Annulation_pf[#N]
					// Ins�rez votre code ici (envoi d'email / mise � jour base de donn�es)
					// Le montant du paiement pour cette �ch�ance se trouve dans $MoneticoPaiement_bruteVars['montantech']
					break;
			}

                $codeRetour = $receivedData["code-retour"];
                $isSandboxPayment = $codeRetour === "payetest";
                $isPaymentValidated = substr($codeRetour, 0, strlen("paiement")) === "paiement";

                if ($isPaymentValidated && !$isSandboxPayment) {
                  return $receivedData['code-retour'];
                }
            }
            
        } else {
        	return "Erreur Syst�me";
        }
	}
	
	//*********************************************************************//
	// SYSTEME 
	//*********************************************************************//
	
	// Fonction : EcritLog
	// R�sum� : Ecrit une ligne dans le LOG
	function EcritLog($texte){
	
		$date = date("d-m-Y");
		$heure = date("H:i");

		$filename = '_log.txt';
		$somecontent = $date." a ".$heure." -- ".$texte." \r\n";

		// Assurons nous que le fichier est accessible en �criture
		if (is_writable($filename)) {

			// Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
			// Le pointeur de fichier est plac� � la fin du fichier
			// c'est l� que $somecontent sera plac�
			if (!$handle = fopen($filename, 'a')) {
				return "Impossible d'ouvrir le fichier ($filename)";
			}

			// Ecrivons quelque chose dans notre fichier.
			if (fwrite($handle, $somecontent) === FALSE) {
				return "Impossible d'&eacute;crire dans le fichier ($filename)";
			}

			fclose($handle);
			
			return "";
				
		} else {
			return "Le fichier $filename est pas accessible en &eacute;criture.";
		}
	
	}
	
	
	// Fonction : EnleveAccents
	// R�sum� : Enleve tous les caract�res avec accents
	function EnleveAccents($string){
	
		$string=strtr($string,'���������������������������������������������������',
							'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY�');
		$interdit=array(">", "<",  ":", "*","\\", "/", "|", "?", "\"","�","\n","^");
		$string = str_replace($interdit, "", $string);
		$string = preg_replace("/\\\'/","", $string); 
		$string = str_replace("�", "e ", $string);
		$string = str_replace("�", "e ", $string);
		$string = str_replace("�", "e ", $string);
     $string = str_replace("&", "", $string);
		return $string;
	}
	
	// Fonction : EnleveAccents
	// R�sum� : Enleve tous les caract�res avec accents
	function NettoieTout($string){
	
		$string=strtr($string,'���������������������������������������������������',
							'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY�');
		$interdit=array(">", "<",  ":", "*","\\", "/", "|", "?","'","\'","\"","�","\r\n","\n\r","\n","...",";",",","!","-","\n\r","^");
		$string = str_replace($interdit, "", $string);
		$string = preg_replace("/\\\'/","", $string); 
		$string = str_replace("�", "e ", $string);
		$string = str_replace("�", "e ", $string);
		$string = str_replace("�", "", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace('"', "", $string);
		$string = str_replace("\"", "", $string);
		$string = trim($string, '"');
    $string = str_replace("&", "", $string);
		return $string;
	}
 
	 function NettoieTel($Tel){
	   $telephone=preg_replace('/[^0-9]/', '',$Tel);
	   return $telephone;
	 }
		
	//*********************************************************************//
	// GESTION BDD
	//*********************************************************************//
	//


	function SQL_Ajoute($idtrans,$texte)
	{
		global $ConnexionSQL;
		$MontantTransaction = $this->Trans_Montant;
		$NomPrenom = $this->Trans_NomPrenom;
		$NoDoss = $this->Trans_NoDossier;		
		$AdresseIP = $_SERVER["REMOTE_ADDR"];
	    $RequeteSQL = "INSERT INTO paiements VALUES (:idtrans,current_date,current_time,:MontantTransaction,'En Attente..',:NomPrenom,:NoDoss,'','En Attente..',:AdresseIP,:Email,:texte,0,0,:Trans_Telephone,:Trans_Info)";
        $reponse = $ConnexionSQL->prepare($RequeteSQL);
        $reponse->bindParam(':idtrans', $idtrans, PDO::PARAM_INT);
        $reponse->bindParam(':MontantTransaction', $MontantTransaction, PDO::PARAM_STR);
        $reponse->bindParam(':NomPrenom', $NomPrenom, PDO::PARAM_STR);
        $reponse->bindParam(':NoDoss', $NoDoss, PDO::PARAM_STR);
        $reponse->bindParam(':AdresseIP', $AdresseIP, PDO::PARAM_STR);
        $reponse->bindParam(':Email', $this->Trans_Email, PDO::PARAM_STR);		
        $reponse->bindParam(':texte', $texte, PDO::PARAM_STR);
        $reponse->bindParam(':Trans_Telephone', $this->Trans_Telephone, PDO::PARAM_STR);
        $reponse->bindParam(':Trans_Info', $this->Trans_Info, PDO::PARAM_STR);
		if (!$reponse->execute()) {
			// Erreur SQL
			$this->GereRequetePDO('SystemPay.SQL_Ajoute',$reponse->error);
		}
	}
	
	function GereRequetePDO()
	{
		global $ConnexionSQL;
		$Contexte="Erreur";
		$ValeurRetour=print_r($ConnexionSQL->errorInfo());
		$MessageErreur="<br>PDO::errorInfo() (".$Contexte.") :<br>Erreur<br>".$ValeurRetour;
		//die($MessageErreur);
		die('Erreur de Preparation');
	}
	
	function SQL_Maj($idtrans,$retour,$debug)
	{
		global $ConnexionSQL;
		if($retour=="OK"){
			if(is_numeric($idtrans)){
				$sql = "UPDATE paiements SET resultat=:retour, debug_retour=:debug,valide=1 WHERE ordre=:idtrans";
				$reponse = $ConnexionSQL->prepare($sql);
				$reponse->bindParam(':idtrans', $idtrans, PDO::PARAM_INT);
				$reponse->bindParam(':retour', $retour, PDO::PARAM_STR);
				$reponse->bindParam(':debug', $debug, PDO::PARAM_STR);
				if (!$reponse->execute()) {
					// Erreur SQL
					$this->GereRequetePDO('Monetico.SQL_Maj(1)',$reponse->error);
				}
				// ENVOI DU MAIL..
				$sql = "SELECT * FROM paiements WHERE ordre=:idtrans";
				$reponse = $ConnexionSQL->prepare($sql);
				$reponse->bindParam(':idtrans', $idtrans, PDO::PARAM_INT);
				if (!$reponse->execute()) {
					// Erreur SQL		
					$this->GereRequetePDO('Monetico.SQL_Maj(3)',$reponse->error);					
				}else{
					$row = $reponse->fetch();
					$this->EnvoiEmail($row['texteemail'],$row['nodoss']);
				}
			}else{
				$this->EcritLog("Tentative de Piratage : Recu en Argument SQL_MAJ -> ".$idtrans);
			}
			
		}else{
			if(is_numeric($idtrans)){
				$sql = "UPDATE paiements SET resultat=:retour, debug_retour=:debug WHERE ordre=:idtrans";
				$reponse = $ConnexionSQL->prepare($sql);
				$reponse->bindParam(':idtrans', $idtrans, PDO::PARAM_INT);
				$reponse->bindParam(':retour', $retour, PDO::PARAM_STR);
				$reponse->bindParam(':debug', $debug, PDO::PARAM_STR);
				if (!$reponse->execute()) {
					// Erreur SQL
					$this->GereRequetePDO('Monetico.SQL_Maj(2)',$reponse->error);
				}
			}else{
				$this->EcritLog("Tentative de Piratage : Recu en Argument SQL_MAJ -> ".$idtrans);
			}
		}
		
	}
	
	
	public function PUBLIC_GenerePaiementSimple($Nom,$Prenom,$Montant,$Email,$Dossier,$Telephone,$Message)
	{
		$titre="";
		$TexteAEnvoyer ="";
		$IDTransaction=0;
		$MontantTransaction=0;
		$HTML=""; 
		$D�tailPaiement=array();
		$MessErr="";		
		if(isset($Montant)){
			if($Email==""){
				$MessErr.="- Adresse Email non Valide<br>";
			}
			if($Dossier==""){
				$MessErr.="- Num�ro de Dossier non Valide<br>";
			}
			if($Montant==0){
				$MessErr.="- Montant de la transaction non Valide<br>";
			}
		}else{
			$MessErr="<b>Aucune donn&eacute;e n'as &eacute;t&eacute; envoy&eacute;e</b>";
		}
		if($MessErr==""){
			$D�tailPaiement['Nom']="";
			$D�tailPaiement['Nom']=utf8_decode($this->NettoieTout($Nom." ".$Prenom));
			$D�tailPaiement['Email']=$Email;
			$D�tailPaiement['Dossier']=$Dossier;
			$D�tailPaiement['DossierVisible']=$Dossier;
			$D�tailPaiement['Montant']=$Montant;
			$D�tailPaiement['Montant'] = str_replace( ",", ".", $D�tailPaiement['Montant']); 
			$D�tailPaiement['Montant'] += 0.00;
			$MontantTransaction = $D�tailPaiement['Montant'];
			$D�tailPaiement['Telephone']=$this->NettoieTel($Telephone);
			// Nettoyage des Variables
			$D�tailPaiement['Dossier']=$this->NettoieTout($D�tailPaiement['Dossier']);
			$D�tailPaiement['DossierVisible']=$this->NettoieTout($D�tailPaiement['Dossier']);
			$D�tailPaiement['Nom']=$D�tailPaiement['Nom'];
			$D�tailPaiement['Detail']=utf8_decode($Message);
			$D�tailPaiement['Detail']=str_replace( "�", "", $D�tailPaiement['Detail']);
			
			$D�tailPaiement['RefDossNomPrenom']=$D�tailPaiement['Dossier']."_".$D�tailPaiement['Nom'];
			
			settype($MontantTransaction, "double");
			$IDTransaction=$this->SQL_RenvoiIDTrans();
			
			// Cr�ation d'un Email Type
			$message_html="<center><b>PAIEMENT - ".$this->NomEtude."<br></b></center><hr><br><i>Le ".date("d/m/Y")." &agrave; ".date("H:i:s")." - Num&eacute;ro Dossier : ".$D�tailPaiement['DossierVisible']."<br></i><br><br>Bonjour,<br>"; 
			$message_html.="Un <font color=\"red\"><b>paiement</b></font> d'un montant de <b>".$D�tailPaiement['Montant']." euros </b>vient d'&ecirc;tre pass&eacute;e par ".$D�tailPaiement['Nom']." pour le Dossier ".$D�tailPaiement['DossierVisible']."<br><br><b><u>Informations :</u></b>"; 
			$message_html.="<br>Identifiant Transaction : ".$IDTransaction."";
			$message_html.="<br>Dossier : ".$D�tailPaiement['DossierVisible']."";
			$message_html.="<br>Nom : ".$D�tailPaiement['Nom']."";
			$message_html.="<br>Montant : ".$D�tailPaiement['Montant']." euros";
			if($D�tailPaiement['Email']!=""){
			$message_html.="<br>Adresse Email : ".$D�tailPaiement['Email']."";
			}
			if($D�tailPaiement['Telephone']!=""){
			$message_html.="<br>Telephone : ".$D�tailPaiement['Telephone']."";
			}
			if($D�tailPaiement['Detail']!=""){
			$message_html.="<br>Detail : ".$D�tailPaiement['Detail']."";
			}
			$message_html.="<br><br>Cordialement, <br>Aptitude Logiciels"; 	

			// R�cup�ration d'un ID Transaction
			
			$this->NouvelleTransactionSimple($IDTransaction,$D�tailPaiement['Montant'],$D�tailPaiement['Nom'],$D�tailPaiement['Dossier'],$D�tailPaiement['Email'],"",$D�tailPaiement['DossierVisible'],$message_html);
			
			if ( $D�tailPaiement['Email'] != '@'){
				$this->Par_Email($D�tailPaiement['Email']);
			}
			if($D�tailPaiement['Telephone']!=""){
				$this->Par_Telephone($D�tailPaiement['Telephone']);
			}
			if($D�tailPaiement['Detail']!=""){
				$this->Par_Info($D�tailPaiement['Detail']);
			}

			$this->SQL_Ajoute($IDTransaction,$message_html);
			// Affichage du R�sultat	
			$HTML.='<center><br><form name="form_ref_doss" class="valide" style="color:'.$this->Couleur.'"><table border=0 >';
			$HTML.='<tr><td width=200px><b>R&eacute;f&eacute;rence Paiement</b></td><td width=200px>'.$IDTransaction."</td></tr>";
			if($D�tailPaiement['Nom']!=""){
				$HTML.='<tr><td><b>Nom & Pr&eacute;nom</b></td><td>'.$Nom." ".$Prenom."</td></tr>";
			}
			$HTML.='<tr><td><b>Email</b></td><td>'.$D�tailPaiement['Email']."</td></tr>";
			$HTML.='<tr><td><b>Dossier</b></td><td>'.$D�tailPaiement['DossierVisible']."</td></tr>";
			$HTML.='<tr><td><b>Montant</b></td><td>'.round($MontantTransaction, 2)." &nbsp;&euro;</td></tr>";
			$HTML.='</table></form>
					<br>
						'.$this->GenereLien().'</center>
					
				';
				
			return $HTML;
		}else{
			return $MessErr;
		}
		
	}
	
	public function PUBLIC_RetourPaiement()
	{				
		// initialisation des variables locales
		global $ConnexionSQL;
		$montant    = 0;
		$reference  = 0;
		$etat       = 0;
		$email      = "";
		$params 	= $_GET;
		$AdresseIP = $_SERVER["REMOTE_ADDR"];
		if(!isset($_GET['etat']) OR !isset($_GET['idtrans'])){

			return "Le chargement de la page est interdit car aucune donn&eacute;e n'as &eacute;t&eacute; re&ccedil;u (retourP 1)";
		}else{
			
			// G�n�ration SPPLUS
			// Cr�ation de l'objet SPPLUS
			if($_GET['etat']=="OK"){
				$etat = 1;
			}else{
				$etat = 0;
			}
			
			$idtrans=$_GET['idtrans'];
			if(!is_numeric($idtrans)){
				return "Le chargement de la page est interdit car aucune donn&eacute;e n'as &eacute;t&eacute; re&ccedil;u (retourP 2)";
			}else{
				// Lecture de la Transaction..
				if(is_numeric($idtrans)){
					$sql = "SELECT * FROM paiements WHERE ordre=:idtrans";
					$reponse = $ConnexionSQL->prepare($sql);
					$reponse->bindParam(':idtrans', $idtrans, PDO::PARAM_INT);
					if (!$reponse->execute()) {
						// Erreur SQL
						$this->GereRequetePDO('Monetico.PUBLIC_RetourPaiement(1)',$reponse->error);
					}else{
						if ($reponse->rowCount() == 1) {
							$row = $reponse->fetch();
							$Num=$row['ordre'];
							// Initialisation des variables
							$montant=$row['montant'];
							$reference=$row['ordre']."-".$row['nodoss'];
							$email=$row['Email'];							
							if($AdresseIP!=$row['AdresseIP']){
								$this->EcritLog("Tentative de Piratage : Recu en Argument SQL_MAJ -> ".$idtrans." - $AdresseIP");
								return "Le chargement de la page est interdit car aucune donn&eacute;e n'as &eacute;t&eacute; re&ccedil;u";
							}
						}else{
							$this->EcritLog("Tentative de Piratage : Recu en Argument SQL_MAJ -> ".$idtrans);
							return "Le chargement de la page est interdit car aucune donn&eacute;e n'as &eacute;t&eacute; re&ccedil;u";
						}
					}
				}else{
					$this->EcritLog("Tentative de Piratage : Recu en Argument SQL_MAJ -> ".$idtrans);
					return "Le chargement de la page est interdit car aucune donn&eacute;e n'as &eacute;t&eacute; re&ccedil;u";
				}
			}				

			// Message de Retour..
			$HTML='<center><table border=0 algin="center" style="color:'.$this->Couleur.'">';
			$HTML.='<tr><td width ="100px"><b>Dossier</b></td><td width ="300px">'.$reference.'</td></tr>';
			$HTML.='<tr><td width ="100px"><b>Email</b></td><td width ="300px">'.$email.'</td></tr>';
			$HTML.='<tr><td width ="100px"><b>Montant</b></td><td width ="300px">'.$montant.' &#8364</td></tr>';
			$HTML.='</table></center>';
			
			if ($etat == 1){
			// le paiement est accept� : on affiche un message de remerciements
				$HTML.= "<br/><span style=\"font-weight: bold; font-family: Arial;font-size:16px;margin-left:40px;color:".$this->Couleur."\"><center><img src=\"".$this->CheminImages."succes.png\" height=29 width=29>&nbsp;&nbsp;Votre paiement a &eacute;t&eacute; accept&eacute;.</center></span><br>";		
			}else{
				// le paiement est refus� : on affiche un message de refus
				$HTML.= "<br><span style=\"font-weight: bold; font-family: Arial;font-size:16px;margin-left:40px;color:".$this->Couleur."\"><center><img src=\"".$this->CheminImages."erreur.png\" height=30 width=30>&nbsp;&nbsp;Votre paiement a &eacute;t&eacute; refus&eacute;.</center></span><br>";
				}
        	 if($this->AvecBoutonAccueil==true){
				$HTML.= "<br/><span style=\"font-weight: bold; font-family: Arial;font-size:16px;margin-left:40px\"><br><center><a href=\"index.php\">Accueil</a></center></span>";
			}
			return $HTML;
		}
	}
	
	public function PUBLIC_RetourPaiementAuto(){
		
			$etat       = 0;
			
			// G�n�ration SPPLUS
			// Cr�ation de l'objet SPPLUS
            $this->ChargeParametreDefaut();
            $receivedData = $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET : $_POST;
            //reception des parametres
            var_dump($receivedData);
            if (array_key_exists("MAC", $receivedData)) {
                //traitement du MAC
                $receivedSeal = $receivedData['MAC'];
                unset($receivedData['MAC']); // removes the MAC field itself
                // on v�rifie le sceau
                $isSealValidated = $this->validateSeal($receivedData, CLE_MAC, $receivedSeal);
                if ($isSealValidated) {
                    //si valide ->
                    switch($receivedData['code-retour']) {
                        case "Annulation" :
                            // Paiement refus�
                            // Ins�rez votre code ici (envoi d'email / mise � jour base de donn�es)
                            // Attention : une autorisation peut toujours �tre d�livr�e pour ce paiement
                            break;

                        case "payetest":
                            // Paiement accept� sur le serveur de test
                            // Ins�rez votre code ici (envoi d'email / mise � jour base de donn�es)
                            break;

                        case "paiement":
                            // Paiement accept� sur le serveur de production
                            // Ins�rez votre code ici (envoi d'email / mise � jour base de donn�es)
                            break;
                    }

                    $codeRetour = $receivedData["code-retour"];
                    $isSandboxPayment = $codeRetour === "payetest";
                    $isPaymentValidated = substr($codeRetour, 0, strlen("paiement")) === "paiement";

                    if ($isPaymentValidated && !$isSandboxPayment) {
                        $ResultatTexte = $receivedData['code-retour'];
                    }
                }
                  return "Le chargement de la page est interdit car aucune donn&eacute;e n'as &eacute;t&eacute; re&ccedil;u";

            } else {
                $ResultatTexte = "Erreur Syst�me, pas de mac reconnu".var_dump($receivedData);
            }

			if($ResultatTexte=="paiement" OR $ResultatTexte=="payetest"){		
				if($this->LogActif==true) { $this->EcritLog('Paiement Valid� : '.$receivedData['reference']); }
				$ResultatTexte="OK";
				// Paiement OK
				$etat=1;
			}else{
				if($this->LogActif==true) { $this->EcritLog('Paiement Erreur : '.$receivedData['reference']."/".$ResultatTexte); }
				$res=$ResultatTexte;
				$etat=2;
			}
			
			/////////////////////////////////////////////
			// MISE A JOUR DE LA BASE DE DONNES
			/////////////////////////////////////////////
			
			// Initialisation des variables
			$IDTrans=intval($receivedData['reference']); // reference de paiement en 6 caract�res & nettoyage pour X caract�res
			// On met toutes les variables pour debug en cas de besoin
			$debug = "";
			ksort($receivedData);
			foreach ($receivedData as $nom => $valeur)
			{
				$debug .= $nom."-->".$valeur."\n";
			}
			
			// Maj
			$this->SQL_Maj($IDTrans,$ResultatTexte,$debug);
	}
	
	function SQL_RenvoiIDTrans()
	{	
		global $ConnexionSQL;
		$Num = 0;
		$sql = "SELECT numero FROM ordre WHERE id_access = 'Session' LIMIT 1";
		$reponse = $ConnexionSQL->prepare($sql);              
		if (!$reponse->execute()) {
			// Erreur SQL
			$this->GereRequetePDO('SystemPay.SQL_RenvoiIDTrans(1)',$reponse->error);
		}		
		if ($reponse->rowCount() == 1) {
			$row = $reponse->fetch();
			$Num=$row['numero'];
			$Num=$Num+1;
			$sql = "UPDATE ordre SET numero=$Num WHERE id_access = 'Session'";
		}else{
			$Num=$Num+1;
			$sql = "INSERT INTO ordre VALUES ('Session',$Num)";
		}
		
		$reponse = $ConnexionSQL->prepare($sql);
		if (!$reponse->execute()) {
			// Erreur SQL
			$this->GereRequetePDO('SystemPay.SQL_RenvoiIDTrans(2)',$reponse->error);
		}
		
		return $Num;
	}
	
	function EnvoiEmail($Html,$NoDoss){	
	
		// Envoi de l'email
		$MessageHTML=$Html;
		/////////////////////////////////////////////
		// ENVOI DU MAIL
		/////////////////////////////////////////////

		$sujet = 'Paiement Etude - '.$NoDoss;
		$headers = "From: \"PAIEMENT WEB\"<paiements@aptitude-logiciels.com>\n";
		$headers .= "Reply-To: paiements@aptitude-logiciels.com\n";
		$headers .= "Content-Type: text/html; charset=\"iso-8859-15\"";
		if(mail ($this->DestinataireMail,$sujet,$MessageHTML,$headers))
		{
				//echo  "L'email a bien �t� envoy�.";
		}
		else
		{
				//echo  "Une erreur c'est produite lors de l'envois de l'email.";
		}			
		return true;
	}
}

?>