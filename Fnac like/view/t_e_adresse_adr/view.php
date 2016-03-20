<?php
	echo "<form method=\"post\" action=\"?r=t_e_adresse_adr/modifAdresse\">";
	echo "<h1>Adresse facturation : </h1>";
	if(isset($_SESSION["facturation"])){
		$list = $_SESSION["facturation"];
		unset($_SESSION["facturation"]);

		echo "<h2>".$list[0]->adr_nom."</h2>";
		echo "<p>Rue : ".$list[0]->adr_rue."<br/>";
		echo "Complément : ".$list[0]->adr_complementrue."<br/>";
		echo "Code postal : ".$list[0]->adr_cp."<br/>";
		echo "Ville : ".$list[0]->adr_ville."<br/>";
		echo "<input type=\"submit\" value=\"Modifier\" name='modifierFacturation' id=\"modifierFacturation\"></p>";
	}else{
		echo "<input type=\"submit\" value=\"Créer une adresse de facturation\" name ='creerFacturation' id='creerFacturation'>";
	}
	if(isset($_SESSION["valFac"])){
		echo $_SESSION["valFac"];
		unset($_SESSION["valFac"]);
	}
	echo "<br/><br/>";
	echo "<h1>Adresse(s) de livraison</h1>";
	if(isset($_SESSION["livraison"])){
		$list = $_SESSION["livraison"];
		unset($_SESSION["livraison"]);
		
		for($i=0;$i<count($list);$i++){
			echo "<h2>".$list[$i]->adr_nom."</h2>";
			echo "<p>Rue : ".$list[$i]->adr_rue."<br/>";
			echo "Complément : ".$list[$i]->adr_complementrue."<br/>";
			echo "Code postal : ".$list[$i]->adr_cp."<br/>";
			echo "Ville : ".$list[$i]->adr_ville."<br/>";
			if(isset($_SESSION["valLiv"]) && $_SESSION["idAdr"] == $list[$i]->adr_id){
				echo $_SESSION["valLiv"]."<br/>";
				unset($_SESSION["valLiv"]);
			}
			echo "<input type=\"submit\" value=\"Modifier\" name=\"modifier".$list[$i]->adr_id."\"> <input type=\"submit\" value=\"Supprimer\" name=\"supprimer".$list[$i]->adr_id."\"></p><br/>";		}

	}
		echo "<input type=\"submit\" value=\"Créer une adresse de livraison\" id=\"creerLivraison\" name=\"creerLivraison\">";

	echo "</form>";
?>


