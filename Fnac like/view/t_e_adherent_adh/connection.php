<?php if(!isset($_SESSION["connected"])){ ?>

<h2>Connexion</h2>

	<form action="?r=t_e_adherent_adh/connection" method='post'>
		<p>
			 <label for="adh_mel" >Mail :</label> 
			 <input type="text" name='adh_mel' <?php if(isset($_SESSION["adh_mel"])) echo "value=\"".$_SESSION["adh_mel"]."\""; ?>/>
		</p>
		<p>
			<label for="adh_motpasse" > Mot de passe :</label> 
			<input type="password" name='adh_motpasse'/>
		</p>

		<p><input type="submit" name="submit" value="Se connecter"/></p>
	</form>
<div id="error">
		<?php
			if(isset($_SESSION["error"])){
				echo "<p>".$_SESSION["error"]."</p>";
				unset($_SESSION["error"]);
				unset($_SESSION["adh_mel"]);
			}
			
			if(isset($_SESSION["inscriptionValidee"])){
				echo "<p>".$_SESSION["inscriptionValidee"]."</p>";
				unset($_SESSION["inscriptionValidee"]);
			}
		?></div>
<?php 
}
?>