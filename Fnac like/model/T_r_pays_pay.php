<?php



class T_r_pays_pay{

	protected $_pay_id;
	protected $_pay_nom;

//Constructeur de la classe Pays
function __construct($idPays) {

	$this->_pay_id = $idPays;
	$this->_pay_nom = null;
	
	$st = db()->prepare("select * from t_r_Pays_gen where pay_id=".$idPays);
	$st->execute();
	if ($st->rowCount() == 1) {
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->_pay_nom = $row["pay_nom"];
	}else {
		$st = db()->prepare("select count(*) from t_r_Pays_gen");
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$id = $row["count"]+1;
		$st = db()->prepare("insert into t_r_Pays_gen(pay_id, pay_nom) values($id, 'Pays')");
		$st->execute();
	}
}

	//Get de la classe Pays
	function __get($name) {
		$attr = "_".$name;
		if (isset($this->$attr)) {
			return $this->$attr;
		} else {
			throw new Exception('Unknown '.$name);
		}
	}

	//Set de la classe Pays
	function __set($fieldName, $value) {
		$varName = "_".$fieldName;
		if ($value != null) {
			if (property_exists(get_class($this), $varName)) {
				$this->$varName = $value;
				$class = get_class($this);
				$table = strtolower($class);
				$id = $fieldName;
				//print_r($id);
				if (isset($value->$id)) {
					$st = db()->prepare("update $table set $fieldName=:val where pay_id=:id");
					//$id = substr($id, 1);
					$st->bindValue(":val", $value);
				} else {
					$st = db()->prepare("update $table set $fieldName=:val where pay_id=:id");
					$st->bindValue(":val", $value);
				}
				//$id = "id".$table;
				$st->bindValue(":id", $this->_pay_id);
				$st->execute();
			} else
				throw new Exception("Unknown variable: ".$fieldName);
		}
	}

	//To String de la classe Pays
	function __toString() {
		return $this->_pay_nom;
	}

	//FindAll: methode qui récupère tout les Pays et qui les retourne dans un tableau de Pays
	public static function findAll()
	{
		$st = db()->prepare("select * from T_r_pays_pay");
		$st->execute();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[]  = array($row["pay_id"] => $row["pay_nom"]);
		}
		return $list;
	}
}


