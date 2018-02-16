<?php
	include("../include/fonction.php");
	connexionbdd();
	extract($_GET);

	$resultat = "";
	
		$stmt = $GLOBALS["db"]->prepare("SELECT nom_article FROM articles WHERE nom_article LIKE ':val$'");
		$stmt -> bindParam(":val", $val);
		$stmt->execute();
		
		if($val == ""){
			$resultat = "vide";
		}
		else{
			for($i = 0; $data = $stmt->fetch() && $i < 5; $i++){
				$resultat += "<li>".htmlentities($data)."</li>";
			}
		}

	echo $resultat;
?>