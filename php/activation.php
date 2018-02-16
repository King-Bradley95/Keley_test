<?php
	require("../include/fonction.php");
	require("../include/constant.php");
	connexionbdd();
	extract($_GET);
 
	$stmt = $GLOBALS["db"]->prepare("SELECT pseudo, mail, mdp, cle FROM inscription WHERE pseudo = :pseudo");
	$stmt -> bindParam(":pseudo", $pseudo);
	$stmt->execute();
	
	if($data = $stmt->fetch()){
		$pseudo_db = $data["pseudo"];
		$mail_db = $data["mail"];
		$mdp_db = $data["mdp"];
		$cle_db = $data["cle"];
	}
	
	if(isset($cle_db)){
		if($cle == $cle_db){
			$stmt_1 = $GLOBALS["db"]->prepare("INSERT INTO membres (membre_id, membre_pseudo, membre_mail, membre_mdp, membre_actif, membre_derniere_visite) VALUES (0, :pseudo, :mail, :mdp, 1, NOW())");
			$stmt_1 ->bindParam(':pseudo', $pseudo_db);
			$stmt_1 ->bindParam(':mail', $mail_db);
			$stmt_1 ->bindParam(':mdp', $mdp_db);
			
			$stmt_2 = $GLOBALS["db"] -> prepare("DELETE FROM inscription WHERE pseudo = :pseudo ");
			$stmt_2 -> bindParam(':pseudo', $pseudo);
			if($stmt_1 -> execute() && $stmt_2 -> execute()){
				$informations = Array(
								true,
								"Information",
								"Votre compte a bien été activé...",
								"",
								WEBSITE_URL."/page/Index.php",
								5
							);
		
				require_once("../include/information.php");
				exit();
			}
		}
		else{
			$informations = Array(
							true,
							"Erreur",
							"Erreur ! Votre compte ne peut être activé...",
							"",
							WEBSITE_URL."/page/Index.php",
							5
						);
	
			require_once("../include/information.php");
			exit();
		}
	}
	else{
		$informations = Array(
						true,
						"Erreur",
						"Erreur ! Votre compte ne peut être activé...",
						"",
						WEBSITE_URL."/page/Index.php",
						5
					);
	
		require_once("../include/information.php");
		exit();
	}
	/*INSERT INTO membres
  (membre_id, membre_pseudo, membre_mail, membre_mdp, membre_cle, membre_actif, membre_admin, membre_derniere_visite)
   VALUES
      (0, OLD.pseudo, OLD.mail, OLD.mdp, OLD.cle, 1, 0, CURRENT_TIMESTAMP)*/
?>