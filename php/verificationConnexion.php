<?php
	include("../include/fonction.php");
	connexionbdd();
	extract($_POST);
	$resultat=0;

	if(validId($identifiant))
		$resultat++;
	if(checkMdp($motDePasse))
		$resultat+=2;
	if(validMdp($identifiant, $motDePasse))
		$resultat+=4;

	echo $resultat;
?>