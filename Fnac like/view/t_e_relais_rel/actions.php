<?php $nb = count($data);
	
	echo "<p>Nous avons trouvé<i> ".$nb." livres</i> </p>";
	echo "<table>";
	echo "<tr>";
	echo "<td><b> Photo </b></td>";
	echo "<td><b> Titre </b></td>";
	echo "<td><b> Description </b></td>";
	echo "<td><b> Date Parution</b> </td>";
	echo "<td><b> Prix </b></td>";
	echo "</tr>";
	foreach($data as $livre) {
		$livre->liv_dateparution = date("j, n, Y");
		echo "<tr>";
		echo "<td><img src='Photos/".$livre->pho_url."' alt='image du livre'</img></td>";
		echo "<td> <a href='?r=t_e_livre_liv/view&id=".$livre->liv_id."'>".$livre->liv_titre."</a></td>";
		echo "<td>".$livre->liv_histoire."</a></td>";
		echo "<td>".$livre->liv_dateparution."</td>";
		echo "<td>".$livre->liv_prixttc."€</td>";
		echo "</tr>";
	}

	echo "</table>";