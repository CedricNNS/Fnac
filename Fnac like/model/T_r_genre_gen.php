<?php



class T_r_genre_gen{

	protected $_gen_id;
	protected $_gen_libelle;

//Constructeur de la classe Genre
function __construct($idgenre) {

	$this->_gen_id = $idgenre;
	$this->_gen_libelle = null;
	
	$st = db()->prepare("select * from t_r_genre_gen where gen_id=".$idgenre);
	$st->execute();
	if ($st->rowCount() == 1) {
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->_gen_libelle = $row["gen_libelle"];
	}else {
		$st = db()->prepare("select count(*) from t_r_genre_gen");
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$id = $row["count"]+1;
		$st = db()->prepare("insert into t_r_genre_gen(gen_id, gen_libelle) values($id, 'genre')");
		$st->execute();
	}
}

	/* public function getGenLibelle()
	 {
	 	return $this->_gen_libelle;
	 }

	 public function setGenLibelle($libelle)
	 {	
	 	$this->gen_libelle = $libelle;

	 } */

	//Get de la classe Genre
	function __get($name) {
		$attr = "_".$name;
		if (isset($this->$attr)) {
			return $this->$attr;
		} else {
			throw new Exception('Unknown '.$name);
		}
	}

	//Set de la classe Genre
	function __set($fieldName, $value) {
		//print_r($fieldName);
		//print_r($value);
		$varName = "_".$fieldName;
		if ($value != null) {
			if (property_exists(get_class($this), $varName)) {
				$this->$varName = $value;
				$class = get_class($this);
				$table = strtolower($class);
				$id = $fieldName;
				//print_r($id);
				if (isset($value->$id)) {
					$st = db()->prepare("update $table set $fieldName=:val where gen_id=:id");
					//$id = substr($id, 1);
					$st->bindValue(":val", $value);
				} else {
					$st = db()->prepare("update $table set $fieldName=:val where gen_id=:id");
					$st->bindValue(":val", $value);
				}
				//$id = "id".$table;
				$st->bindValue(":id", $this->_gen_id);
				$st->execute();
			} else
				throw new Exception("Unknown variable: ".$fieldName);
		}
	}

	//To String de la classe Genre
	function __toString() {
		return $this->_gen_libelle;
	}

	//FindAll: methode qui récupère tout les genre et qui les retourne dans un tableau de Genre
	public static function findAll()
	{
		$st = db()->prepare("select gen_id from t_r_genre_gen");
		$st->execute();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[] = new T_r_genre_gen($row["gen_id"]);
		}
		return $list;
	}

	//Methode FindRecherche: recherche tous les livres de la base de donnée en fonction du genre passé en paramètres, retourne un tableau de Livre
	public static function FindRecherche($idgenre)
	{
		$st = db()->prepare("select * from t_r_genre_gen
							 Join t_e_livre_liv on t_r_genre_gen.gen_id=t_e_livre_liv.gen_id
							 where t_r_genre_gen.gen_id = $idgenre");
		$st->execute();
		$list = array();
		if ($st->rowCount() !=0) {
			while($row = $st->fetch(PDO::FETCH_ASSOC)) {
				$list[] = new T_e_livre_liv($row["liv_id"]);
			}
			
		}

		return $list;
	}

	public static function IDGenre()
	{
		$st = db()->prepare("select max(gen_id) from t_r_genre_gen");
		$st->execute();

		if ($st->rowCount() !=0) 
		{
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$id = $row["max"]+1;
		}

		return $id;

	}
			
	public static function VerifGenre($genre)
	{
			$st = db()->prepare("select gen_libelle from t_r_genre_gen where gen_libelle ='".strtoupper($genre)."'");
			$st->execute();

			if ($st->rowCount() == 0) 
			{	
				return "true";
			}
			else
			{ 
				return "false";
			}	
			
		
	}
}


