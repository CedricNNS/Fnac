

<h2>Ajouter une bière</h2>

<form action='?r=beer/add' method='post'>
	<p>
		<input name='name'/>
	</p>
	<p>
		<input name='degree'/>
	</p>
	<p>
		<select name='brewery'>
		<?php
		foreach(Brewery::findAll() as $brewery) {
			echo "<option value=".$brewery->idbrewery.">";
			echo $brewery->name;
			echo "</option>";
		}
		?>
		</select>
	<p>
	<p>
		<input type='submit' value='Ajouter'/>
	</p>
</form>

