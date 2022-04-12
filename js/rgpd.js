function GestionBouton(IdLien, IdBouton){
	StatutBouton = document.getElementById(IdBouton).disabled;
	 
	if(StatutBouton == true){
		document.getElementById(IdBouton).disabled = false;
	}
	else{
		document.getElementById(IdBouton).disabled = true;
	}
}

// Activation Bouton Connexion
function AfficheModaleContact(){	
	$('#confirm_formulaire').modal('show')
	return false;	
}

function AfficheFormulaireRPGDConstat(){	
	document.getElementById("AfficheConsentementConstat").innerHTML=document.getElementById("confirmationformulaire_constat").innerHTML;	 
	return false;	
}
function AfficheFormulaireRPGD(){	
	document.getElementById("AfficheConsentementContact").innerHTML=document.getElementById("confirmationformulaire").innerHTML;	 
	return false;	
}
//-->