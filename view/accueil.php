<?php
	$title = "accueil";
	include("../include/constant.php");
	include("../partie/debut.php");
?>

<header>
	<div id="baniere">
		<?php if(isset($_SESSION["membre_id"])){ ?>
			<img src="img_profile.png">
			<p> <?php echo $_SESSION["membre_pseudo"] ?></p>
			<button id="boutonDeconnexion">Se déconnecter</button>
		<?php }else{ ?>
			<button id="boutonInscription">Inscription</button>
			<button id="boutonConnexion">Connexion</button>
		<?php } ?>
	</div>
</header>

<div id="popup">
	<p id="x">x</p>
	<form method="post" id="formulaireConnexion">
		<label id="connection">Connection</label>
		<div class="contenupopup">
			<label>Identifiant:<br></label>
			<input type="text" id="identifiant" name="identifiant" placeholder="Nom ou Email">
			<span class="msgErreur" id="idErreur">Identifiant non valide !</span>
		</div>
		<div class="contenupopup">
			<label>Mot de passe:<br></label>
			<input type="password" id="motDePasse" name="motDePasse" placeholder="Mot de passe">
			<span class="msgErreur" id="mdpErreur">Mot de passe non valide !</span>
		</div>
		<div class="contenupopup">
			<input type="submit" id="bouton" value="Connexion">
		</div>
	</form>
</div>

<div id="popup2">
	<p id="x2">x</p>
	<form method="post" id="formulaireInscription">
		<label id="inscription">Inscription</label>
		<div class="contenupopup">
			<label>Pseudo:<br></label>
			<input type="text" id="pseudo" name="pseudo" placeholder="Nom">
			<span class="msgErreur2" id="pseudoErreur2">Identifiant non valide !</span>
		</div>
		<div class="contenupopup">
			<label>Email:<br></label>
			<input type="text" id="mail" name="mail" placeholder="azerty@yuiop.fr">
			<span class="msgErreur2" id="mailErreur2">Identifiant non valide !</span>
		</div>
		<div class="contenupopup">
			<label>Mot de passe:<br></label>
			<input type="password" id="motDePasse2" name="mdp" placeholder="Mot de passe">
			<span class="msgErreur2" id="mdpErreur2">Mot de passe non valide !</span>
		</div>
		<div class="contenupopup">
			<input type="submit" id="bouton2" value="inscription">
		</div>
	</form>
</div>

<nav>
	<div id="filtre">
		<input type="checkbox" name="Tag1" class="input_filtre">Tag1
	</div>

	<div id="tri">
		<div class="check">
			<input type="checkbox" name="tri1" id="input_prix" class="in_tri" value="prix">
			<label>Prix</label>
		</div>
		<div class="check">
			<input type="checkbox" name="tri2" id="input_poids" class="in_tri" value="poids">
			<label>Poids</label>
		</div>
	</div>

	<input type="submit" id="bouton_filtre" value="GO">

	<div id="recherche">
		<input type="text" id="search" placeholder="rechercher">
		<input type="submit" id="bouton_filtre" value="OK">
	</div>
	<ul id="suggestion">
		<li></li>
	</ul>

</nav>

<div id="contenu">
	<ul class="tab_produit">
		<li class="produit" id="1">
			<article>
				<h1>Nom produit</h1>
				<img src="">
				<section>
					<h1>Description</h1>
					<p>Tag</p>
					<h2>Prix</h2>
					<p>Poids</p>
					<a href="">En savoir plus</a>
				</section>
			</article>			
		</li>
	</ul>
</div>

<div id="Page">
	
</div>

<?php
	include("../partie/fin.php");
?>