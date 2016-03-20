
<h2>Modifier votre compte:</h2>
<br/>

<?php
	?>
		<form method="POST" action="?r=t_e_adherent_adh/modifier">
			<p>
				<label for="numeAdh">Numero Adhérent :</label>
				<input type="text" name="numAdh" id="numAdh" placeholder='<?php echo $data->adh_numadherent ?>' disabled="disabled"/><br/><br/>
				<label for="dateFinAdhesion">Date fin d'adhésion :</label>
				<input type="text" name="dateFinAdh" id="dateFinAdh" placeholder='<?php echo $data->adh_datefinadhesion ?>' disabled="disabled"/><br/><br/>
				<label for="mail">Mail :</label>
				<input type="text" name="mail" id="mail" value='<?php echo $data->adh_mel ?>'/><br/><br/>
				<label for="mdp">Mot de passe :</label>
				<input type="password" name="mdp" id="mdp" value='<?php echo $data->adh_motpasse ?>'/><br/><br/>
				<label for="pseudo">Pseudo :</label>
				<input type="text" name="pseudo" id="pseudo" value='<?php echo $data->adh_pseudo?>'/><br/><br/>
				<label for="civ">Civilite :</label>
				<input type="text" name="civ" id="civ" value='<?php echo $data->adh_civilite ?>'disabled="disabled"/><br/><br/>
				<label for="nom">Nom :</label>
				<input type="text" name="nom" id="nom" value='<?php echo $data->adh_nom ?>'/><br/><br/>
				<label for="prenom">Prenom :</label>
				<input type="text" name="prenom" id="prenom" value='<?php echo $data->adh_prenom ?>'/><br/><br/>
				<label for="telfix">Téléphone Fixe :</label>
				<input type="text" name="telfix" id="telfix" value='<?php echo $data->adh_telfixe ?>'/><br/><br/>
				<label for="telportable">Téléphone Portable :</label>
				<input type="text" name="telportable" id="telportable" value='<?php echo $data->adh_telportable ?>'/><br/><br/>
				<input type="submit" name="modif" value="Enregister"><br/>
			</p>
		</form>

		<?php
			if(isset($_SESSION["relais"])){
			echo $_SESSION["relais"];
			unset($_SESSION["relais"]);
		}
		?>
		<div id="valide">
	<?php


		if(isset($_SESSION["modifOK"]))
		{
			echo $_SESSION["modifOK"];
			unset($_SESSION["modifOK"]);
		}
?></div>
<div id="error">
	<?php
	if(isset($_SESSION["error"])){
		echo $_SESSION["error"];
		unset($_SESSION["error"]);
	}
	?>
</div>

