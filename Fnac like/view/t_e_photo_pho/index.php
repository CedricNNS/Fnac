<h2>Photos</h2>

<?php

	if(isset($_SESSION["erreur"]))
	{
		echo "<div id='error'>".$_SESSION["erreur"]."</div>";
		unset($_SESSION["erreur"]);
	}
	else
	{
		foreach($data as $pho)
		{
			 echo "<img id='Photodescr' src='Photos/".$pho->pho_url."' alt='image du livre'</img>";
		}
		?>
		<form method="post" action="?r=t_e_livre_liv/view&idliv=<?php echo $pho->liv_id;?>">
		<input type="submit" name="return" value="Retour Infos Livre"/> 
		</form>
		<?php
	}


