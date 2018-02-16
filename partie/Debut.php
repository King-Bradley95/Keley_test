<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Projet Test Keley">
		<meta name="author" content="Convalot_Rodrigue">
		
		<title>
			<?php
				echo isset($title) ? $title.' - '.WEBSITE_NAME.' ' : WEBSITE_NAME;
			?>
		</title>

		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<![endif]-->
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<!--<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/paper/bootstrap.min.css" rel="stylesheet">-->
		<?php
			if(isset($title)){
				echo "<script type='text/javascript' src=../js/$title.js></script>";
				echo "<link type='text/css' rel='stylesheet' href=../css/$title.css>";
			}
		?>
	</head>
<!------------>
	<body>