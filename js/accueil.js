$(document).ready(function(){

	var clickOnce = false;
	var clickOnce2 = false;

/********************  --  POPUPconnexion  --  ********************/
	
	$("#x").click(function(e){		//ferme le popup connexion et enleve le flou de la page
		e.preventDefault();
		$("#popup").hide();
		$("body").find(".blur").removeClass("blur");
		$("#boutonInscription").prop("disabled", false);
		$("#boutonConnexion").prop("disabled", false);
	});
	
	$("#motDePasse").keyup(function(e){		//verification d'erreur du MDP quand il est trop court
		if(clickOnce){
			$("#mdpErreur").text("Mot de passe trop court !").toggle($("#motDePasse").val().length < 4);
		}
	});
	
	$("#bouton").click(function(e){		//quand on clique sur le bouton d'envoie de connexion
		e.preventDefault();
		$("#idErreur").text("Veuillez saisir votre identifiant !").toggle($("#identifiant").val().length == 0);
		if($("#motDePasse").val().length == 0)
			$("#mdpErreur").text("Veuillez saisir votre Mot de passe !").show();
		else
			$("#mdpErreur").text("Mot de passe trop court !").toggle($("#motDePasse").val().length < 4);
		
		if($(".msgErreur:visible").length == 0){
			$.post("../php/verificationConnexion.php",
					{identifiant: $("#identifiant").val(), motDePasse: $("#motDePasse").val()},
					function(reponse){
						console.log("Réponse reçue du serveur: ",reponse);
						switch (reponse){
							case "0":
								$("#idErreur").text("Identifiant non valide !").show();
								$("#mdpErreur").text("Mot de passe non valide !").show();
								break;
							case "1":
								$("#mdpErreur").text("Mot de passe non valide !").show();
								break;
							case "2":
								$("#idErreur").text("Identifiant non valide !").show();
								break;
							case "3":
								$("#mdpErreur").text("Mot de passe non valide !").show();
								break;
							case "7":
								$("#formulaireConnexion").attr("action", "../page/Index.php");
								$("#formulaireConnexion").submit();
								break;
							default:
								alert("Erreur !");
						}
					}
			);
		}
		clickOnce = true;		//pour activer la verification d'erreur de MDP trop court
	});

/********************  --  POPUPinscription  --  ********************/
	
	$("#x2").click(function(e){		//ferme le popup inscription et enleve le flou de la page
		e.preventDefault();
		$("#popup2").hide();
		$("body").find(".blur").removeClass("blur");
		$("#boutonInscription").prop("disabled", false);
		$("#boutonConnexion").prop("disabled", false);
	});
	
	$("#motDePasse2").keyup(function(e){		//verification d'erreur du MDP quand il est trop court
		if(clickOnce2){
			$("#mdpErreur2").text("Mot de passe trop court !").toggle($("#motDePasse2").val().length < 4);
		}
	});
	
	$("#bouton2").click(function(e){		//quand on clique sur le bouton d'envoie de connexion
		e.preventDefault();
		$("#pseudoErreur2").text("Veuillez saisir votre Pseudo !").toggle($("#pseudo").val().length == 0);
		if($("#mail").val().length == 0)
			$("#mailErreur2").text("Veuillez saisir votre Email !").show();
		else
			$("#mailErreur2").text("Email invalide !").toggle(!(/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/i.test($("#mail").val())));
		if($("#motDePasse2").val().length == 0)
			$("#mdpErreur2").text("Veuillez saisir votre Mot de passe !").show();
		else
			$("#mdpErreur2").text("Mot de passe trop court !").toggle($("#motDePasse2").val().length < 4);
		
		
		if($(".msgErreur2:visible").length == 0){
			$.post("../php/verificationInscription.php",
					{pseudo: $("#pseudo").val(), mail: $("#mail").val(), mdp: $("#motDePasse2").val()},
					function(reponse){
						console.log("Réponse reçue du serveur: ",reponse);
						switch (reponse){
							case "0":
								$("#pseudoErreur2").text("pseudo non valide !").show();
								$("#mailErreur2").text("Email non valide !").show();
								$("#mdpErreur2").text("Mot de passe non valide !").show();
								break;
							case "1":
								$("#mailErreur2").text("Email non valide !").show();
								$("#mdpErreur2").text("Mot de passe non valide !").show();
								break;
							case "2":
								$("#pseudoErreur2").text("pseudo non valide !").show();
								$("#mdpErreur2").text("Mot de passe non valide !").show();
								break;
							case "3":
								$("#mdpErreur2").text("Mot de passe non valide !").show();
								break;
							case "4":
								$("#pseudoErreur2").text("pseudo non valide !").show();
								$("#mailErreur2").text("Email non valide !").show();
								break;
							case "5":
								$("#mailErreur2").text("Email non valide !").show();
								break;
							case "6":
								$("#pseudoErreur2").text("pseudo non valide !").show();
								break;
							case "7":
								$("#formulaireInscription").attr("action", "../php/inscription.php");
								$("#formulaireInscription").submit();
								break;
							default:
								alert("Erreur !");
						}
					}
			);
		}
		clickOnce2 = true;		//pour activer la verification d'erreur de MDP trop court
	});

/********************  --  FLOU  --  ********************/
	
	$("html").click(function(e){		//lorseque l'on clique en dehors du popup
		if($("#popup").css("display") != "none" && !($(e.target).is("#boutonConnexion"))){
			if(!$(e.target).is("#popup") && !$("#popup").find("*").is(e.target)){
				$("#popup").hide();
				$(".msgErreur").hide();
				$("body").find(".blur").removeClass("blur");
				clickOnce = false;
				$("#boutonInscription").prop("disabled", false);
				$("#boutonConnexion").prop("disabled", false);
			}
		}
	
		if($("#popup2").css("display") != "none" && !($(e.target).is("#boutonInscription"))){		//cas popup inscription
			if(!$(e.target).is("#popup2") && !$("#popup2").find("*").is(e.target)){
				$("#popup2").hide();
				$(".msgErreur2").hide();
				$("body").find(".blur").removeClass("blur");
				clickOnce2 = false;
				$("#boutonInscription").prop("disabled", false);
				$("#boutonConnexion").prop("disabled", false);
			}
		}
	});
	
	$("#boutonConnexion").click(function(e){		//lorsque l'on clique sur le bouton pour se connecter
		e.preventDefault();
		$("#popup").show();
		$("body").find("*").each(function(){
				if(!($(this).is("#popup")) && !$(this).is($("#popup").find("*")))
					$(this).addClass("blur");
		});
		$(this).prop("disabled", true);
		$("#boutonInscription").prop("disabled", true);
	});
	
	$("#boutonInscription").click(function(e){		//lorsque l'on clique sur le bouton pour s'inscrire
		e.preventDefault();
		$("#popup2").show();
		$("body").find("*").each(function(){
				if(!($(this).is("#popup2")) && !$(this).is($("#popup2").find("*")))
					$(this).addClass("blur");
		});
		$(this).prop("disabled", true);
		$("#boutonConnexion").prop("disabled", true);
	});

/********************  --  CheckBox  --  ********************/

	$(".check").on("click", ".in_tri", function(e){
		
	});

/********************  --  SUGGESTION  --  ********************/

	$("nav").on("keyup", "#search", function(e){
		$.get("../php/suggestion.php",
			{val: $("#search").val()},
			function(reponse){
				console.log("Réponse reçue du serveur: ", reponse);
				switch (reponse){
					case "":
						$("#suggestion").hide();
						$("#search").addClass("erreurChamp");
						break;
					case "vide":
						$("#suggestion").hide();
						$("#search").removeClass("erreurChamp");
						break;
					default:
						$("#suggestion").html(response);
						$("#suggestion").show();
						$("#search").removeClass("erreurChamp");
						affichage();
						break;
				}
			}
		);
	});

	$("nav").on("click", "#suggestion li", function(e){
		e.preventDefault();
		$("#search").val($(this).text());
		$("#suggestion").hide();
		affichage();
	});

	$("nav").on("click", "#bouton_filtre", function(e){
		affichage();
	});

/********************  --  AFFICHAGE  --  ********************/

	function affichage(){
		var tag = "";
		$(".input_filtre").attr("checked", true).each(function(){
			tag += $(this).val() + "|";
		});
		var tri = ($("#input_prix").is("selected")? "prix" : $("#input_poids").is("selected")? "poids" : "");
		console.log(tag);
		console.log(tri);
		$.get("../php/affichage.php",
			{tag: tag, tri: tri, search: $("#search").val()},
			function(reponse){
				console.log("Réponse reçue du serveur: ", reponse);
				switch (reponse){
					case "":
						break;
					default:
						break;
				}
			}
		);
	}

});