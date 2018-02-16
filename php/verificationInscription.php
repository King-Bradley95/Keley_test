<?php
	require("../include/fonction.php");
	extract($_POST);
	$resultat=0;
	
	if(checkId($pseudo))
		$resultat++;
	if(checkMail($mail))
		$resultat+=2;
	if(checkMdp($mdp))
		$resultat+=4;

	echo $resultat;
?>