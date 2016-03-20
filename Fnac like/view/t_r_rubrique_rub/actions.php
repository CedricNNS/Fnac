<!--Affichage basique des livres trouvé en fonction de la rubrique -->

<h2>Livre(s) Trouvé(s) : </h2>

<?php


if(count($data) == 0){
	echo "<p>Nous sommes désolés mais il semblerait qu'il n'y aie pas de livre pour cette rubrique.</p>";
	?><form method="post" action="?r=t_r_rubrique_rub">
		<input type="submit" name="return" value="Retour"/> 
</form>
<?php
}else
{
	$nb = count($data);
	echo "<p>Nous avons trouvé <i>".$nb." livres</i> pour la rubrique <strong>".$_SESSION["rubrique"]."</strong> : </p>";
	echo "<table>";
	echo "<tr>";
	echo "<td><b> Photo </b></td>";
	echo "<td> <b>Titre </b></td>";
	echo "<td><b> Description </b></td>";
	echo "<td><b> Date Parution</b> </td>";
	echo "<td><b> Prix </b></td>";
	
	echo "</tr>";
	foreach($data as $livre) {
		echo "<tr>";
		echo "<td><img src='Photos/".$livre->pho_url."' alt='image du livre'</img></td>";
		echo "<td> <a href='?r=t_e_livre_liv/view&id=".$livre->liv_id."'>".$livre->liv_titre."</a></td>";
		echo "<td>".$livre->liv_histoire."</a></td>";
		echo "<td>".$livre->liv_dateparution."</td>";
		echo "<td>".$livre->liv_prixttc."€</td>";
		echo "</tr>";
	}

	echo "</table>";
	?><form method="post" action="?r=t_r_rubrique_rub">
		<input type="submit" name="return" value="Retour"/> 
	</form><?php
	
}
?>

