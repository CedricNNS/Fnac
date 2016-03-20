
<h2>Inscription</h2>

<form action="?r=t_e_adherent_adh/inscription" method='post'>
	<p>

		 <label for="adh_mel" >Mail :</label> 
		 <input type="text" name='adh_mel' <?php if(isset($_SESSION["adh_mel"])) echo "value=\"".$_SESSION["adh_mel"]."\""; ?>/>
	</p>
	<p>
		<label for="adh_motpasse" > Mot de passe :</label> 
		<input type="password" name='adh_motpasse' <?php if(isset($_SESSION["adh_motpasse"])) echo "value=\"".$_SESSION["adh_motpasse"]."\""; ?>/>
	</p>
	<p>
		<label for="adh_pseudo" >Pseudo :</label> 
		<input type="text" name='adh_pseudo' <?php if(isset($_SESSION["adh_pseudo"])) echo "value=\"".$_SESSION["adh_pseudo"]."\""; ?>/>
	</p>
	<p>
		<label for="adh_civilite">Civilité :</label>
		<select name="adh_civilite">
			<?php 
			if($_SESSION["adh_civilite"] == "M")
				$civ = "Monsieur";
			if($_SESSION["adh_civilite"] == "Mme")
				$civ = "Madame";
			if($_SESSION["adh_civilite"] == "Mlle")
				$civ = "Mademoiselle";
			if(isset($_SESSION["adh_civilite"]))
				echo"<option value='".$_SESSION["adh_civilite"]."'>$civ</option>";

			?>
			<option value="M">Monsieur</option>
			<option value="Mme">Madame</option>
			<option value="Mlle">Mademoiselle</option>
		</select>
	</p>
	<p>
		<label for="adh_nom" >Nom :</label>
		<input type="text" name='adh_nom' <?php if(isset($_SESSION["adh_nom"])) echo "value=\"".$_SESSION["adh_nom"]."\""; ?>/>
	</p>
	<p>
		<label for="adh_prenom" >Prénom :</label>
		<input type="text" name='adh_prenom' <?php if(isset($_SESSION["adh_prenom"])) echo "value=\"".$_SESSION["adh_prenom"]."\""; ?>/>
	</p>
	<p>
		<label for="adh_telfixe" >Téléphone fixe :</label>
		<input type="text" name='adh_telfixe' <?php if(isset($_SESSION["adh_telfixe"])) echo "value=\"".$_SESSION["adh_telfixe"]."\""; ?>/>
	</p>
	<p>
		<label for="adh_telportable">Téléphone mobile :</label>
		<input type="text" name='adh_telportable' <?php if(isset($_SESSION["adh_telportable"])) echo "value=\"".$_SESSION["adh_telportable"]."\""; ?>/>
	</p>
	<p>
		<input type='submit' name="inscr" value="S'inscrire"/>
	</p>
</form>

<?php 
if(isset($_SESSION["error"])){
	echo $_SESSION["error"];
}
if(isset($_SESSION["inscriptionEchec"]))
{
	echo $_SESSION["inscriptionEchec"];
	unset($_SESSION["inscriptionEchec"]);
}
unset($_SESSION["error"]);
unset($_SESSION["adh_mel"]);
unset($_SESSION["adh_motpasse"]);
unset($_SESSION["adh_pseudo"]);
unset($_SESSION["adh_nom"]);
unset($_SESSION["adh_prenom"]);
unset($_SESSION["adh_telfixe"]);
unset($_SESSION["adh_civilite"]);
unset($_SESSION["adh_telportable"]);
unset($_SESSION["adh_civilite"]);
?>




