<?php if(isset($_SESSION["admin"])){?>
<div class="div">
<h2> Ajouter un genre </h2>
<br/>
<form method="post" action="?r=t_r_genre_gen/ajouter">
	<label for="ajou">Entrer le nom du genre :</label>
	<input type="text" name="ajou" />
	<input type="submit" name="add" value="Ajouter"/> 
</form>
<br/>
<form method="post" action="?r=t_r_genre_gen">
		<input type="submit" name="return" value="Retour"/> 
</form><br/>
<div id="valide">
	<?php
		if(isset($_SESSION["valide"])){
			echo $_SESSION["valide"];
			unset ($_SESSION["valide"]);
		}

	?>
</div>
<div id="error">
	<?php
		if(isset($_SESSION["error"])){
			echo $_SESSION["error"];
			unset ($_SESSION["error"]);
		}
	?>
</div>

<?php }else{
	echo "Vous n'avez pas le droit d'utiliser cette page...";
}