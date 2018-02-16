<?php
	require("../include/fonction.php");
	require("../include/constant.php");
	connexionbdd();
	extract($_POST);
	
	$_SESSION["erreur"] = 0;
	
	if(isset($_POST["pseudo"]) && isset($_POST["mail"]) && isset($_POST["mdp"])){
		if(!validPseudo(trim($_POST["pseudo"])))
			$_SESSION["erreur"]++;
		if(!validMail(trim($_POST["mail"])))
			$_SESSION["erreur"]+=2;
		if(!checkMdp(trim($_POST["mdp"])))
			$_SESSION["erreur"]+=4;
	}
	else{
		header('Location: ../page/Index.php');
		exit();
	}
	
	if(isset($_SESSION["erreur"]) && $_SESSION["erreur"] == 0){
		$query=$GLOBALS["db"] -> prepare("INSERT INTO inscription (pseudo, mail, mdp, cle, date_inscription) VALUES (:pseudo, :mail, :mdp, 0, NOW())");
		$query->bindParam(":pseudo", $pseudo);
		$query->bindParam(":mail", $mail);
		$mdpHash = hash("sha256", $mdp);
		$query->bindParam(":mdp", $mdpHash);
		if(!$query->execute()){
			$informations = Array(
							true,
							"Erreur",
							"Une erreur interne est survenue...",
							"",
							WEBSITE_URL."../page/Index.php",
							5
						);
	
			require_once('information.php');
			exit();
		}
	}
	else{
		$erreur = "";
		switch($_SESSION["erreur"]){
			case "1":
				$erreur="Pseudo invalide";
				break;
			case "2":
				$erreur="Email invalide";
				break;
			case "3":
				$erreur="Pseudo et/ou Email invalide";
				break;
			case "4":
				$erreur="Mot de passe invalide";
				break;
			case "5":
				$erreur="Pseudo et/ou mot de passe invalide";
				break;
			case "6":
				$erreur="Email et/ou mot de passe invalide";
				break;
			case "7":
				$erreur="Pseudo, Email et/ou mot de passe invalide";
				break;
			default:
				$erreur="";
		}
		$informations = Array(
							true,
							"Erreur",
							$erreur,
							"",
							WEBSITE_URL.'/page/Index.php',
							3
						);
	
		require_once('information.php');
		exit();
	}
	
	envoiEmail($pseudo, $mail);
	$informations = Array(
						false,
						"RecapInscription",
						"Un Email vous as été envoyer sur votre boite Mail, merci de bien vouloir verifier votre messagerie et cliquer sur le lien afin d'activer votre compte.",
						'',
						WEBSITE_URL.'/page/Index.php',
						5
					);
?>