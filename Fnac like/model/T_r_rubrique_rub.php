<?php



class T_r_rubrique_rub{

	protected $_rub_id;
	protected $_rub_libelle;

//Constructeur de la classe Genre
function __construct($idrubrique) {

	$this->_rub_id = $idrubrique;
	$this->_rub_libelle = null;
	
	$st = db()->prepare("select * from t_r_rubrique_rub where rub_id=".$idrubrique);
	$st->execute();
	if ($st->rowCount() == 1) {
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->_rub_libelle = $row["rub_libelle"];
	}else {
		$st = db()->prepare("select count(*) from T_r_rubrique_rub");
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$id = $row["count"]+1;
		$st = db()->prepare("insert into t_r_rubrique_rub(rub_id, rub_libelle) values($id, 'rub')");
		$st->execute();
	}
}



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
					$st = db()->prepare("update $table set $fieldName=:val where rub_id=:id");
					//$id = substr($id, 1);
					$st->bindValue(":val", $value);
				} else {
					$st = db()->prepare("update $table set $fieldName=:val where rub_id=:id");
					$st->bindValue(":val", $value);
				}
				//$id = "id".$table;
				$st->bindValue(":id", $this->_rub_id);
				$st->execute();
			} else
				throw new Exception("Unknown variable: ".$fieldName);
		}
	}

	//To String de la classe Rubrique
	function __toString() {
		return $this->_rub_libelle;
	}

	//FindAll: methode qui récupère tout les genre et qui les retourne dans un tableau de Rubrique
	public static function findAll()
	{
		$st = db()->prepare("select rub_id from t_r_rubrique_rub");
		$st->execute();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[] = new T_r_rubrique_rub($row["rub_id"]);
		}
		return $list;
	}

	//Methode FindRecherche: recherche tous les livres de la base de donnée en fonction du genre passé en paramètres, retourne un tableau de Livre
	public static function FindRecherche($idrubrique)
	{
		$st = db()->prepare("select * from t_r_rubrique_rub
 								Join t_j_rubriquelivre_rul on t_r_rubrique_rub.rub_id=t_j_rubriquelivre_rul.rub_id
								Join t_e_livre_liv on t_j_rubriquelivre_rul.liv_id=t_e_livre_liv.liv_id
 								where t_r_rubrique_rub.rub_id = $idrubrique");
		$st->execute();
		$list = array();
		if ($st->rowCount() !=0) {
			while($row = $st->fetch(PDO::FETCH_ASSOC)) {
				$list[] = new T_e_livre_liv($row["liv_id"]);
			}
			
		}

		return $list;
	}
	
}


