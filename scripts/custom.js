$(document).ready(function(){


	/* ++Registeren */
	$("#view-organisatie-form").hide();
	
	$("#rd-gebruiker").click(function(){
		$("#view-organisatie-form").hide();
		$("#view-gebruiker-form").show();
	});
	
	$("#rd-organisatie").click(function(){
		$("#view-organisatie-form").show();
		$("#view-gebruiker-form").hide();
	});
	/* --Registeren */
	
	
});