<?php //print_r($data);


 foreach($data as $book){
	echo "<h2>".$book->liv_titre."</h2>";
	echo "<br/>";
	echo "<img id='Photodescr' src='Photos/".$book->pho_url."' alt='image du livre'</img>";
	/*?>
	<script type="text/javascript" src="JS/jquery.js"></script>
	<script type="text/javascript" src="JS/affichagePhoto.js"></script>
	<div id="BandeauNews"></div> 
	<?php*/
	echo "<div id='cote'>";
		echo "<br/>";
		echo "<span class='miseEnForme'>Résumé : </span>";
		echo "<p id='resume'>".$book->liv_histoire."</p>";
		echo "<span class='miseEnForme'>Format : </span>";
		echo $book->for_id->for_libelle; 
		echo "<br/>";
		echo "<span class='miseEnForme'>Edition : </span>";
		echo $book->edi_id->edi_nom;
		echo "<br/>";
		echo "<span class='miseEnForme'>Date Parution : </span>";
		echo $book->liv_dateparution;
		echo "<br/>";
		echo "<span class='miseEnForme'>ISBN : </span>";
		echo $book->liv_isbn;
		echo "<br/>";
		echo "<span class='miseEnForme'>Disponibilité : </span>";
		echo $book->liv_stock." disponibles";
		echo "<br/>";
		echo "<span class='miseEnForme'>Prix : </span>";
		echo $book->liv_prixttc."€";
		echo "<br/>";
		echo "<span class='miseEnForme'>Auteur : </span>";
		echo $book->aut_id->aut_nom;
		echo "<br/>";
		echo "<a href='?r=t_e_photo_pho/index&idli=".$book->liv_id."'> Plus d'images...</a>";
	
	echo "</div>";
	echo "<br/>";
	echo "<br/>";

	echo "<div>";
		echo "<h2>Avis: </h2>";
		echo "<table>";
			echo "<tr>";
				echo "<td>Titre</td>";
				echo "<td>Auteur</td>";
				echo "<td>Date</td>";
				echo "<td>Detail</td>";
				echo "<td>Note</td>";
				echo "<td></td>";
			echo "</tr>";
			foreach ($book->avi_id as $avi) {
			
				echo "<tr>";
				echo "<td>".$avi->avi_titre."</td>";
				echo "<td><a href='?r=t_e_adherent_adh/view&ida=".md5($avi->adh_id)."'>".$avi->adh_id->adh_pseudo."</a></td>";
				echo "<td>".$avi->avi_date."</td>";
				echo "<td>".$avi->avi_detail."</td>";
				echo "<td>";
					echo "<div class='rating'>";
								
									for($i=0; $i<$avi->avi_note; $i++)
									{
										echo "<span id='etoile'>☆</span>";
									}
									for($j=0; $j<5-$i; $j++)
									{
										echo "<span id='etoileGrise'>☆</span>";
									}	
									
								
					echo "</div>";
				echo "</td>";
				?>
				<td>
				<form method="post" action="?r=t_j_avisabusif_ava/ajoutAvisSignale&avis=<?php echo $avi->avi_id;?>&adherent=<?php echo md5($avi->adh_id);?>">
					<input type="submit" id="signaler" name="signaler" value="Signaler"/>
				</form>
				</td>
				<?php
				echo "</tr>";
			}
			
		echo "</table>";
	echo "</div>";

	echo "<div>";
		?>
			<form method="post" action="?r=t_e_livre_liv/ajoutP&livre=<?php echo $book->liv_id;?>">
				<input type="submit" id="panier" name="panier" value="Ajouter au Panier"/>
			</form>
		<?php
	echo "</div>";

	echo "<div>";
	echo "<br/>";
	echo "<hr/>";
	echo "<br/>";
	?>
		<h3>Ajouter une photo</h3>
		<form method="post" action="?r=t_e_photo_pho/ajout&idl=<?php echo $book->liv_id;?>" enctype="multipart/form-data">

     		<label id="photo"for="photoL">Icône du fichier (JPG, JEPG, PNG ou GIF | max. 1 Mo) :</label><br />

     		<input type="file" name="photo" id="photo" />
      		 <input type="submit" name="submit" value="AJouter" />

		</form>
	<?php
	
	if(isset($_SESSION["ajoutPho"]))
	{
		echo $_SESSION["ajoutPho"];
		unset($_SESSION["ajoutPho"]);

	}

	
	echo "</div>";
}
	


