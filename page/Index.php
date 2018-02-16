<?php
	session_start();
	header('Content-type: text/html; charset=utf-8');
	include("../include/fonction.php");
	connexionBdd();
	actualiserSession();
	require("../view/Accueil.php");
?>