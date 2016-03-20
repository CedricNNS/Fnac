<form method="post" action="?r=t_e_adresse_adr/addFacturation">
	<label for="nom">Nom de l'adresse :</label>
	<input id="nom" name="nom" <?php if(isset($_SESSION["nom"]))echo "value=\"".$_SESSION["nom"]."\""; ?>><br>
	<label for="rue">Rue :</label>
	<input id="rue" name="rue" <?php if(isset($_SESSION["rue"]))echo "value=\"".$_SESSION["rue"]."\""; ?>><br>
	<label for="cptAdresse">Complément d'adresse :</label>
	<input id="cptAdresse" name="cptAdresse" <?php if(isset($_SESSION["cptAdresse"]))echo "value=\"".$_SESSION["cptAdresse"]."\""; ?>><br>
	<label for="cp">Code postal :</label>
	<input id="cp" name="cp" <?php if(isset($_SESSION["cp"]))echo "value=\"".$_SESSION["cp"]."\""; ?>><br>
	<label for="ville">Ville :</label>
	<input id="ville" name="ville" <?php if(isset($_SESSION["ville"]))echo "value=\"".$_SESSION["ville"]."\""; ?>><br>
	<label for="pays">Pays :</label>
	<select id="pays" name="pays">
	<?php
		foreach ($data as $id => $table) {
			foreach ($table as $key => $nom) {
				echo "<option value='$key'>$nom</option>";
			}
		}
	?>
	</select><br/><br/>
	<input type="submit" value ="Valider" name="val" id="val"/>
</form>

<?php
if(isset($_SESSION["error"])){
	echo "<div id='error'>";
	echo $_SESSION["error"];
	echo "</div>";
	unset($_SESSION["error"]);
}

if(isset($_SESSION["val"])){
	echo $_SESSION["val"];
	unset($_SESSION["val"]);
}

if(isset($_SESSION["nom"])){
	unset($_SESSION["nom"]);
}
if(isset($_SESSION["rue"])){
	unset($_SESSION["rue"]);
}
if(isset($_SESSION["cptAdresse"])){
	unset($_SESSION["cptAdresse"]);
}
if(isset($_SESSION["cp"])){
	unset($_SESSION["cp"]);
}
if(isset($_SESSION["ville"])){
	unset($_SESSION["ville"]);
}