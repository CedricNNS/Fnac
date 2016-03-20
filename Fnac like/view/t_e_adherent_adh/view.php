<?php

	echo "<div id='adh_auteur'>";
		echo "<h3>Auteur de l'avis : </h3>";
		echo "<br/>";
		echo $data->adh_pseudo;
	echo "</div>";
	?><br/><form method="post" action="?r=site/index">
		<input type="submit" name="return" value="Retour accueil"/> 
	</form>
	<?php
	



