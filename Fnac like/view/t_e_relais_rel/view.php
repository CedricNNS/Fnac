<form method="post" action="?r=t_e_relais_rel/choix">
<?php
	for($i=0;$i<count($data);$i++){
		echo "<div id='relais'>";
		echo "<h2>".$data[$i][2]."</h2>";
		echo "<br/>";
		echo $data[$i][3]; 
		echo "<br/>";		
		echo $data[$i][4];
		echo "<br/>";	
		echo $data[$i][5];
		echo "<br/>";
			
		echo "<input type='radio' class='button' name='radiobutton' value='".$data[$i][0]."' />";
		echo "</div>";
	
	}
?>
		<br/>
		<p><input type="submit" name="submit" id="submit" value="Sélectionner"/></p>
		</form><br/>

<?php
	if(isset($_SESSION["msg"])){
		echo $_SESSION["msg"];
		unset($_SESSION["msg"]);
	}
?>