<h2> <?php //var_dump($data);  
 foreach($data as $book){
	echo "<h2>".$book->liv_titre."</h2>";
	echo "<br/>";
	echo "<img id='Photodescr' src='Photos/".$book->pho_url."' alt='image du livre'</img>";
	echo "<div id='cote'>";
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
			echo "</tr>";
			echo "<tr>";
				echo "<td>".$book->avi_id->avi_titre."</td>";		
				echo "<td><a href='?r=t_e_adherent_adh/view&ida=".md5($book->avi_id->adh_id)."'>".$book->avi_id->adh_id->adh_pseudo."</a></td>";
				echo "<td>".$book->avi_id->avi_date."</td>";
				echo "<td>".$book->avi_id->avi_detail."</td>";
				echo "<td>";
					echo "<div class='rating'>";
								
									for($i=0; $i<$book->avi_id->avi_note; $i++)
									{
										echo "<span id='etoile'>☆</span>";
									}
									for($j=0; $j<5-$i; $j++)
									{
										echo "<span id='etoileGrise'>☆</span>";
									}	
									
								
					echo "</div>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";
}
 ?> 
</h2>

