<?php
	global $prixT;
	$prixT= 0;

	echo "<div>";
	echo "<h2> Votre Panier: </h2>";

	?>

	<table>
		<tr>
			<td>Titre</td>
			<td>Prix</td>
			<td>Quantité</td>
		</tr>
		
			<?php
				foreach ($data as $key=>$article) 
				{
					foreach ($article as $panier) 
					{
						echo "<tr>";
						echo "<td>".$panier->liv_titre."</td>";
						echo "<td>".$panier->liv_prixttc."</td>";
						echo "<td>".$panier->liv_stock."</td>";
						echo "</tr>";

						$prixT += $panier->liv_prixttc;

					}
				}
			?>		
	</table>

	<div>
		<?php
			echo "Prix Total de votre Panier: ";
			echo $prixT."€";
		?>
	</div>