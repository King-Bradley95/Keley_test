<?php
	include("../include/fonction.php");
	connexionbdd();
	extract($_GET);
echo $search;
echo $tag;
echo $tri;
	$sql = "SELECT * FROM articles WHERE nom_article LIKE ':val" + "*' AND tag_article LIKE '*" + ":tag_art" + "\|*";
	if($tri != "")
		$sql += " ORDER BY :tri_art";
	$sql_img = "SELECT blob_img FROM images WHERE nom_img LIKE '*':img'\|*'";
	$count = 1;
	$i = 1;
	$resultat = "";
	$res2 = "<ul>";

	$stmt = $GLOBALS["db"]->prepare($sql);
	$stmt_img = $GLOBALS["db"]->prepare($sql_img);
	$stmt -> bindParam(":val", $search);
	$stmt -> bindParam(":tag_art", $tag);
	if($tri != "")
		$stmt -> bindParam(":tri_art", $tri);
	$stmt -> execute();

	while($data = $stmt->fetch()){
		$resultat += "<li class='produit' id='" + $count;

		if($count > 5)
			$resultat += "' style='display:none";
		$resultat += "'><article><h1>" + $data["nom_article"] + "</h1><img src='../image/";
		
		$stmt_img -> bindParam(":img", $data["image_article"]);
		$stmt_img -> execute();
		
		$resultat += ($data_img = $stmt_img -> fetch())? $data_img["chemin_img"] : "none";
		$resultat += "'><section><h1>" + $data["descrip_article"] + "</h1><p>";
		$resultat += replace($data["tag_article"], "|", ", ") + "</p><h2>";
		$resultat += $data["prix_article"] + " euros</h2><p>" + $data["poids_article"] + "Kg</p>";
		$resultat += "<a href=''>En savoir plus</a></section></article></li>";

		if($count-1 %5 == 0){
			$res2 += "<li>" + $i + "</li>";
			$i++;
		}
		$count++;
	}

	echo $resultat + $res2 + "</ul>";
?>