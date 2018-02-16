<?php
	function connexionbdd(){
		$bd_nom_serveur='localhost';
		$bd_login='root';
		$bd_mot_de_passe='';
		$bd_nom_bd='rodrigue';
		
		global $db;

		try{
			$GLOBALS["db"] = new PDO("mysql:host=".$bd_nom_serveur.";dbname=".$bd_nom_bd, $bd_login, $bd_mot_de_passe);
			$GLOBALS["db"]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			die('<p> La connexion a la base de donnees a echoue. Erreur ['.$e->getCode().'] : '.$e->getMessage().'</p>');
		}
	}
	
/*************************************/

	function actualiserSession(){
		if(isset($_SESSION['membre_id']) && intval($_SESSION['membre_id']) != 0){
			$sql ="SELECT membre_id, membre_pseudo, membre_mdp FROM membres WHERE membre_id = :id";
			$stmt = $GLOBALS["db"]->prepare($sql);
			$id = intval($_SESSION['membre_id']);
			$stmt -> bindParam(":id", $id);
			$stmt->execute();
			$data = $stmt->fetch();
			
			if(isset($data["membre_pseudo"]) && $data["membre_pseudo"] != ""){
				if($_SESSION['membre_mdp'] != $data['membre_mdp']){
					$informations = Array(/*Mot de passe de session incorrect*/
									true,
									'Session invalide',
									'Le mot de passe de votre session est incorrect, vous devez vous reconnecter.',
									'',
									'membres/connexion.php',
									5
									);
					require_once('../information.php');
					vider_cookie();
					session_destroy();
					exit();
				}
				else{
					$_SESSION['membre_id'] = $data['membre_id'];
					$_SESSION['membre_pseudo'] = $data['membre_pseudo'];
					$_SESSION['membre_mdp'] = $data['membre_mdp'];
				}
			}
		}
		
		else{
			if(isset($_COOKIE['membre_id']) && isset($_COOKIE['membre_mdp'])){
				if(intval($_COOKIE['membre_id']) != 0){
					$sql ="SELECT membre_id, membre_pseudo, membre_mdp FROM membres WHERE membre_id = :id";
					$stmt = $GLOBALS["db"]->prepare($sql);
					$id = intval($_COOKIE['membre_id']);
					$stmt -> bindParam(":id", $id);
					$stmt->execute();
					$data = $stmt->fetch();
					
					if(isset($data['membre_pseudo']) && $data['membre_pseudo'] != ''){
						if($_COOKIE['membre_mdp'] != $data['membre_mdp']){
							vider_cookie();
							session_destroy();
							exit();
						}
						
						else{
							$_SESSION['membre_id'] = $data['membre_id'];
							$_SESSION['membre_pseudo'] = $data['membre_pseudo'];
							$_SESSION['membre_mdp'] = $data['membre_mdp'];
						}
					}
				}
				
				else{
					vider_cookie();
					session_destroy();
					exit();
				}
			}
			
			else{
				if(isset($_SESSION['membre_id']))
					unset($_SESSION['membre_id']);
				vider_cookie();
			}
		}
	}
	
/*************************************/

	function connexion(){
		if(isset($_SESSION["membre_id"])){
			$informations = Array(/*Membre qui essaie de se connecter alors qu'il l'est déjà*/
								true,
								'Vous êtes déjà connecté',
								'Vous êtes déjà connecté avec le pseudo <span class="pseudo">'.htmlspecialchars($_SESSION['membre_pseudo'], ENT_QUOTES).'</span>.',
								' - <a href="'.WEBSITE_URL.'/include/deconnexion.php">Se déconnecter</a>',
								WEBSITE_URL.'/page/Index.php',
								5
							);
		
			require_once('information.php');
			exit();
		}
		
		else{
			$sql = "SELECT membre_id, membre_pseudo, membre_mdp, membre_actif FROM membres WHERE membre_pseudo = :identifiant OR membre_mail = :identifiant";
			$stmt = $GLOBALS["db"] -> prepare($sql);
			$id = trim($_POST["identifiant"]);
			$stmt -> bindParam (":identifiant", $id);
			$stmt -> execute();
			
			if($data = $stmt->fetch()){
				if(hash("sha256", trim($_POST['motDePasse'])) == $data["membre_mdp"] && $data["membre_actif"] == 1){
					$_SESSION['membre_id'] = $data['membre_id'];
					$_SESSION['membre_pseudo'] = $data['membre_pseudo'];
					$_SESSION['membre_mdp'] = $data['membre_mdp'];

					unset($_SESSION['connexion_pseudo']);
				}
				else{
					$_SESSION['connexion_pseudo'] = $_POST['identifiant'];
					$informations = Array(/*Erreur de mot de passe*/
											true,
											"Mauvais mot de passe ou compte inactif",
											"Vous avez fourni un mot de passe incorrect ou votre compte n'est pas encore actif",
											"",
											WEBSITE_URL."/page/Index.php",
											5
										);
					require_once('information.php');
					exit();
				}
			}
			else{
				$informations = Array(/*Pseudo inconnu*/
										true,
										"Pseudo inconnu",
										"Le pseudo <span class='pseudo'>".htmlspecialchars($_POST["pseudo"], ENT_QUOTES)."</span> n'existe pas dans notre base de données. Vous avez probablement fait une erreur.",
										"",
										WEBSITE_URL."/page/Index.php",
										5
									);
				require_once('information.php');
				exit();
			}
		}
	}

/*************************************/

	function vider_cookie(){
		foreach($_COOKIE as $cle => $element)
		{
			setcookie($cle, '', time()-3600);
		}
	}
	
/*************************************/

	function checkId($identifiant){
		return (strlen($identifiant) > 3 && strlen($identifiant) < 32);
	}
	
/*************************************/
	
	function validPseudo($pseudo){
		if(!checkId($pseudo))
			return false;
		$sql_1 = "SELECT * FROM membres WHERE membre_pseudo = :pseudo";
		$sql_2 = "SELECT * FROM inscription WHERE pseudo = :pseudo";
		$stmt_1 = $GLOBALS["db"] -> prepare($sql_1);
		$stmt_1 -> bindParam(":pseudo", $pseudo);
		$stmt_1 ->execute();
		
		$stmt_2 = $GLOBALS["db"] -> prepare($sql_2);
		$stmt_2 -> bindParam(":pseudo", $pseudo);
		$stmt_2 ->execute();
		
		return (!$data_1 = $stmt_1->fetch() && !$data_2 = $stmt_2->fetch());
	}
	
/*************************************/

	function validId($identifiant){
		if(!checkId($identifiant))
			return false;
		$sql = "SELECT * FROM membres WHERE membre_pseudo = :identifiant OR membre_mail = :identifiant";
		$stmt = $GLOBALS["db"]->prepare($sql);
		$stmt -> bindParam(":identifiant", $identifiant);
		$stmt->execute();
		return ($data = $stmt->fetch());
	}

/*************************************/
	
	function checkMail($mail){
		return (preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is', $mail));
	}
	
/*************************************/
	
	function validMail($mail){
		if(!checkMail($mail))
			return false;
		$sql_1 = "SELECT * FROM membres WHERE membre_mail = :mail";
		$sql_2 = "SELECT * FROM inscription WHERE mail = :mail";
		$stmt_1 = $GLOBALS["db"]->prepare($sql_1);
		$stmt_1 -> bindParam(":mail", $mail);
		$stmt_1 ->execute();
		
		$stmt_2 = $GLOBALS["db"]->prepare($sql_2);
		$stmt_2 -> bindParam(":mail", $mail);
		$stmt_2 ->execute();
		
		return (!$data_1 = $stmt_1->fetch() && !$data_2 = $stmt_2->fetch());
	}
	
/*************************************/

	function checkMdp($mdp){
		return ($mdp != "" && strlen($mdp) > 3 && preg_match("#[0-9]{1,}#", $mdp) && preg_match("#[A-Z]{1,}#", $mdp));
	}
	
/************************************/

	function validMdp($identifiant, $mdp){
		if(!checkMdp($mdp) || !validId($identifiant))
			return false;
		$sql = "SELECT * FROM membres WHERE membre_pseudo = :identifiant OR membre_mail = :identifiant";
		$stmt = $GLOBALS["db"]->prepare($sql);
		$stmt -> bindParam(":identifiant", $identifiant);
		$stmt->execute();
		if ($data = $stmt->fetch())
			return (hash("sha256", $mdp) == $data["membre_mdp"]);
		return false;
	}
	
/************************************/
	
	function envoiEmail($pseudo, $mail){
		$cle = md5(microtime(TRUE)*100000);

		$stmt = $GLOBALS["db"]->prepare("UPDATE inscription SET cle=:cle WHERE mail=:mail");
		$stmt->bindParam(':cle', $cle);
		$stmt->bindParam(':mail', $mail);
		$stmt->execute();

		$destinataire = $mail;
		$sujet = "Activer votre compte";
		$entete = "MIME-Version: 1.0\nFrom: convalotrodrigue@gmail.com";

		$message = "Bienvenue,
		 
		Pour activer votre compte, veuillez cliquer sur le lien ci dessous
		ou copier/coller dans votre navigateur internet.
		 
		".WEBSITE_URL."/php/activation.php?pseudo=".urlencode($pseudo)."&cle=".urlencode($cle)."
		 
		 
		---------------
		Ceci est un mail automatique, Merci de ne pas y répondre.";

		ini_set("SMTP","ssl://smtp.gmail.com");
		ini_set("smtp_port","465");

		mail($destinataire, $sujet, $message, $entete);
	}
?>