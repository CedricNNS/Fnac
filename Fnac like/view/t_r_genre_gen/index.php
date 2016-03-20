<!-- Formulaire de recherche par Genre: -->

<div class="div">
<h2>Recherche par genre</h2>
<br/>
<form method="post" action="?r=t_r_genre_gen/recherche">
	Quel genre de livre recherchez-vous ? 

	 <select id="genre" name="genre">	
	<!--<option value="0"> Sélectionnez un genre </option>-->
	<?php

		foreach($data as $t_r_genre_gen) {
				echo "<option value=".$t_r_genre_gen->gen_id.">";
				echo $t_r_genre_gen->gen_libelle;
				echo "</option>";
			}
	?>
	</select>
	<input type="submit" name="submit" id="submit" value="Rechercher"/>
</form><br/>


	<?php if(isset($_SESSION["admin"])) echo "Vous voulez ajouter un genre ? <a style='color:white;' href='?r=t_r_genre_gen/avAjouter' >Cliquez Ici !</a>"; ?>


<div id="apresAjout">
	<?php
		//echo $data;
	?>
</div>

</div>


<?php 
	

