

<h2>Recherche par genre</h2>



<form method="get" action="actions.php">
	<label name="lblRecherche">Quel(s) genre(s) de livre recherchez-vous ?</label>


	 <select>	
	<?php
		//foreach(t_r_genre_gen::findAll() as $t_r_genre_gen) {
				/*echo "<option value=".$T_r_genre_gen->gen_id.">";
				echo $T_r_genre_gen->gen_libelle;
				echo "</option>";*/
				echo '<option value="1">coucou</option>';
	?>
	</select> 

</form>

<?php

?>

