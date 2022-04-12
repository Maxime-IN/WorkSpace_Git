function VerificationEmail(emailStr) {
	var checkTLD = 1;
	var knownDomsPat = /^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum|fr)$/;
	var emailPat = /^(.+)@(.+)$/;
	var specialChars = "\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
	var validChars = "\[^\\s" + specialChars + "\]";
	var quotedUser = "(\"[^\"]*\")";
	var ipDomainPat = /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
	var atom = validChars + '+';
	var word = "(" + atom + "|" + quotedUser + ")";
	var userPat = new RegExp("^" + word + "(\\." + word + ")*$");
	var domainPat = new RegExp("^" + atom + "(\\." + atom +")*$");
	var matchArray = emailStr.match(emailPat);
	if (matchArray == null) { return false; }
	var user = matchArray[1];
	var domain = matchArray[2];
	for (i=0; i<user.length; i++) {
		if (user.charCodeAt(i) > 127) { return false; }
	}
	for (i=0; i<domain.length; i++) {
		if (domain.charCodeAt(i) > 127) { return false; }
	}
	if (user.match(userPat) == null) { return false; }
	var IPArray=domain.match(ipDomainPat);
	if (IPArray != null) {
		for (var i=1; i<=4; i++) {
			if (IPArray[i] > 255) { return false; }
		}
		return true;
	}
	var atomPat = new RegExp("^" + atom + "$");
	var domArr = domain.split(".");
	var len = domArr.length;
	for (i=0; i<len; i++) {
		if (domArr[i].search(atomPat) == -1) { return false; }
	}
	if (checkTLD && domArr[domArr.length-1].length!=2 && domArr[domArr.length-1].search(knownDomsPat)==-1) { return false; }
	if (len < 2) { return false; }
	return true;
}

function Controle_Constat() {
	var msg;
	msg="";
	var nom = document.form_constat.nom.value;
	var prenom = document.form_constat.prenom.value;
	var email = document.form_constat.email.value;
	var lieu = document.form_constat.lieu.value;
	var constat = document.form_constat.constat.value;
	var tel = document.form_constat.tel.value;
	var ville = document.form_constat.ville.value;
	var cp = document.form_constat.cp.value;
	
	if(VerificationEmail(email)==false){
		msg="Adresse Mail non valide";
	}
	
	if(nom.length==0){
		if (msg != "" ){
			msg += ", ";
		}
		msg += "Nom obligatoire";
	}
	
	if(tel.length<8){
		if (msg != "" ){
			msg += ", ";
		}
		msg += "T&eacute;l&eacute;phone obligatoire";
	}
	
	if(tel.cp<5){
		if (msg != "" ){
			msg += ", ";
		}
		msg += "Code Postal obligatoire";
	}
	if(ville.cp<4){
		if (msg != "" ){
			msg += ", ";
		}
		msg += "Ville obligatoire";
	}
	
	if(prenom.length==0){
		if (msg != "" ){
			msg += ", ";
		}
		msg += "Pr&eacute;nom obligatoire";
	}
	
	
	if(constat.length==0){
		if (msg != "" ){
			msg += ", ";
		}
		msg += "Infos obligatoire";
	}
	
	if(lieu.length==0){
		if (msg != "" ){
			msg += ", ";
		}
		msg += "Lieu obligatoire";
	}
	
	if(msg!=""){
		document.getElementById("messageconstat").innerHTML="<div class=\"alert alert-danger\" role=\"alert\">&nbsp;&nbsp;&nbsp;Impossible d'envoyer le message : "+msg+"</div>";
		return false;
	}else{
		return true;
		// Envoi du Formulaire..
		Action("g-recaptcha-response="+document.form_contact.g-recaptcha-response.value+"&nom="+document.form_contact.nom.value+"&prenom="+document.form_contact.prenom.value+"&email="+document.form_contact.email.value+"&message="+document.form_contact.message.value+"&monfichier="+document.form_contact.monfichier.value+"&ajax=1");	
		document.getElementById("messageconstat").innerHTML="<div class=\"alert alert-success\" role=\"alert\">nbsp;&nbsp;&nbsp;Message envoy&eacute; avec succ&egrave;s</div>";
		document.messageconstat.nom.value="";
		document.messageconstat.prenom.value="";
		document.messageconstat.email.value="";
		document.messageconstat.adresse.value="";
		document.messageconstat.constat.value="";
		return false;
	}

}


function Controle_Contact() {
	var msg;
	msg="";
	var nom = document.form_contact.nom.value;
	var prenom = document.form_contact.prenom.value;
	var email = document.form_contact.email.value;
	var message = document.form_contact.message.value;
	
	if(VerificationEmail(email)==false){
		msg="Adresse Mail non valide";
	}
	
	if(nom.length==0){
		if (msg != "" ){
			msg += ", ";
		}
		msg += "Nom obligatoire";
	}
	
	if(message.length==0){
		if (msg != "" ){
			msg += ", ";
		}
		msg += "Message obligatoire";
	}
	
	if(msg!=""){
		document.getElementById("messagecontact").innerHTML="<div class=\"alert alert-danger\" role=\"alert\">&nbsp;&nbsp;&nbsp;Impossible d'envoyer le message : "+msg+"</div>";
		return false;
	}else{
		// Envoi du Formulaire..
		if(document.form_contact.monfichier.value!=""){
			return true;
		}else{
			return true;
			Action("g-recaptcha-response="+document.form_contact.g-recaptcha-response.value+"&nom="+document.form_contact.nom.value+"&prenom="+document.form_contact.prenom.value+"&email="+document.form_contact.email.value+"&message="+document.form_contact.message.value+"&monfichier="+document.form_contact.monfichier.value+"&ajax=1");	
			document.getElementById("messagecontact").innerHTML="<div class=\"alert alert-success\" role=\"alert\">nbsp;&nbsp;&nbsp;Message envoy&eacute; avec succ&egrave;s</div>";
			document.form_contact.nom.value="";
			document.form_contact.prenom.value="";
			document.form_contact.email.value="";
			document.form_contact.message.value="";
		}
		return false;
	}

}

function isIE () {
  var myNav = navigator.userAgent.toLowerCase();
  return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
}

function isMon(mMontant){
        var sep = 0;
        var dec = 0;
        resnb = "";
	
        for(var i = 0 ; i < mMontant.length ; i++){
                
                if ("0123456789.,".indexOf(mMontant.charAt(i)) == -1 ){
                        return false;
                }
                if ((mMontant.charAt(i) == '.') || (mMontant.charAt(i) == ',')){
                        sep++;
                        if (sep > 1) {
                                return false;
                        }
                        resnb += '.';
                }else{
                        if (sep > 0){
                                dec ++;
                                if (dec > 2){
                                        return false;
                                }
                        }
                        resnb += mMontant.charAt(i);
                }
				//alert(resnb)
        }
}


function Controle_Paiement() {
	document.getElementById("messageerreur").innerHTML="";
	// Verification du Paiement...
	var msg="";
	var nom = document.form_paiement.nom.value;
	var prenom = document.form_paiement.prenom.value;
	var email = document.form_paiement.email.value;
	var dossier = document.form_paiement.dossier.value;
	var montant = document.form_paiement.montant.value;
	montant=montant.trim();

	if(nom.length==0){
		if (msg != "" ){
			msg += "<br> ";
		}
		msg += "- Nom";
	}

	if(dossier.length==0){
		if (msg != "" ){
			msg += "<br> ";
		}
		msg += "- Dossier";
	}else{
		if(dossier.length>15){
			msg += "- Le Dossier ne peut excéder 10 caractères";
		}else{
			if(dossier.length<6){
				msg += "- Le Dossier doit faire plus de 5 caractères";
			}
		}
	}

	if(VerificationEmail(email)==false){
		if (msg != "" ){
			msg += "<br>";
		}
		msg+="- Adresse Mail";
	}
	
	if(isMon(montant)==false){
		if (msg != "" ){
			msg += "<br>";
		}
		msg += "- Le montant doit être un numérique";
	}

	if(montant<=1){
		if (msg != "" ){
			msg += "<br>";
		}
		msg += "- Montant (doit être supérieur à 1 euro)";
	}

	if(msg!=""){
		document.getElementById("messageerreur").innerHTML="<img src=\"img/alert.png\">&nbsp;&nbsp;&nbsp;<font color=\"red\">Impossible de passer le paiement, vérifiez les champs : <br>"+msg+"<br></font>";
		return false;
	}

	if (isIE () && isIE () < 9) {
		// is IE version less than 9
		return true;
	} else {
		 // is IE 9 and later or not IE
		 // Requête Paiement..
		var post = "nom="+document.form_paiement.nom.value+"&prenom="+document.form_paiement.prenom.value+"&email="+document.form_paiement.email.value+"&dossier="+document.form_paiement.dossier.value+"&phone="+document.form_paiement.phone.value+"&montant="+document.form_paiement.montant.value
		
		ActionPaiement(post);
		$('#confirm_paiement').modal('show')
		return false;
	}
	
}

function Action(post)
{
		var xhr_object = null; 
	     var mess = "";
	   if(window.XMLHttpRequest) // Firefox 
	      xhr_object = new XMLHttpRequest(); 
	   else if(window.ActiveXObject) // Internet Explorer 
	      xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
	   else { // XMLHttpRequest non supporté par le navigateur 
	      alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
	      return mess; 
	   } 
		
	   xhr_object.open("POST", "formulaire-contact.php", true);
	  
	   xhr_object.onreadystatechange = function() { 
	      if(xhr_object.readyState == 4) {
			  // DEBUG MODE
			 mess = this.responseText; // DEBUG MODE
			 if(mess!="ok"){
				alert(mess);
			 }
			 //return this.responseText;
			 // --- ICI le retour (c'est à dire tout ce qui est écrit dans le fichier de traitement)
			 // --- est interprété, donc il suffi d'écrire du code JS dans traitement.php pour
			 // --- qu'il soit interprété au retour.
	         eval(this.responseText);
			 return mess;
		  }
	   } 
	 
	   xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	   // --- ICI TU PASSE TES ARGUMENTS AU SCRIPT :
	   var data =post;
	   xhr_object.send(data);
	
}

function ActionPaiement(post)
{
		var xhr_object = null; 
	     
	   if(window.XMLHttpRequest) // Firefox 
	      xhr_object = new XMLHttpRequest(); 
	   else if(window.ActiveXObject) // Internet Explorer 
	      xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
	   else { // XMLHttpRequest non supporté par le navigateur 
	      alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
	      return; 
	   } 
		
	   xhr_object.open("POST", "prepai.php", true);
	  
	   xhr_object.onreadystatechange = function() { 
	      if(xhr_object.readyState == 4) {
			 var mess = ""; // DEBUG MODE
			 mess = this.responseText; // DEBUG MODE
			  document.getElementById("confirmationpaiement").innerHTML=this.responseText;
			 //return this.responseText;
			 // --- ICI le retour (c'est à dire tout ce qui est écrit dans le fichier de traitement)
			 // --- est interprété, donc il suffi d'écrire du code JS dans traitement.php pour
			 // --- qu'il soit interprété au retour.
	         eval(this.responseText);
			
		  }
	   } 
	 
	   xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	   // --- ICI TU PASSE TES ARGUMENTS AU SCRIPT :
	   var data =post;
	   xhr_object.send(data);

}


$(document).ready(function() {

		// Si le navigateur ne prend pas en charge le placeholder
		if ( document.createElement('input').placeholder == undefined ) {

			// Champ avec un attribut HTML5 placeholder
			$('[placeholder]')
				// Au focus on clean si sa valeur &eacute;quivaut à celle du placeholder
				.focus(function() {
					if ( $(this).val() == $(this).attr('placeholder') ) {
						$(this).val(''); }
				})
				// Au blur on remet le placeholder si le champ est laiss&eacute; vide
				.blur(function() {
					if ( $(this).val() == '' ) {
						$(this).val( $(this).attr('placeholder') ); }
				})
				// On d&eacute;clenche un blur afin d'initialiser le champ
				.blur()
				// Au submit on clean pour &eacute;viter d'envoyer la valeur du placeholder
				.parents('form').submit(function() {
					$(this).find('[placeholder]').each(function() {
						if ( $(this).val() == $(this).attr('placeholder') ) {
							$(this).val(''); }
					});
				});
		}	

	});
	
