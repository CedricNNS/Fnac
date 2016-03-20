<!-- Formulaire de recherche par Rubrique: -->

<div class="div">
<h2>Recherche par rubrique</h2>
<br/>
<form method="post" action="?r=t_r_rubrique_rub/recherche">
	Choisir une rubrique

	 <select id="rubrique" name="rubrique">	
	<!--<option value="0">Toutes les rubriques </option>-->
	<?php
		foreach($data as $t_r_rubrique_rub) {
				echo "<option value=".$t_r_rubrique_rub->rub_id.">";
				echo $t_r_rubrique_rub->rub_libelle;
				echo "</option>";
			}
	?>
	</select>
	<input type="submit" name="submit" id="submit" value="Rechercher"/>
</form><br/>
</div>


<?php 
	

