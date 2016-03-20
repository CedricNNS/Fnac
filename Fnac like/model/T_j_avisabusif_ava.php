<?php



class T_j_avisabusif_ava{

	protected $_adh_id;
	protected $_avi_id;

//Constructeur de la classe Genre
function __construct($adhid, $avisid) {

	$this->_adh_id = $adhid;
	$this->_avi_id = $avisid;
	
	$st = db()->prepare("select * from t_j_avisabusif_ava where adh_id=".$adhid."and avi_id=".$avisid);
	$st->execute();
	if ($st->rowCount() == 1) {
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->_avi_id = $row["avi_id"];
	}else {
		$st = db()->prepare("select count(*) from t_j_avisabusif_ava");
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$id = $row["count"]+1;
		$st = db()->prepare("insert into t_j_avisabusif_ava(avi_id, adh_id) values($avisid, $adhid)");
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
		return $this->_avi_id;
	}

	//FindAll: methode qui récupère tout les genre et qui les retourne dans un tableau de Genre
	public static function findAll()
	{
		$st = db()->prepare("select * from t_j_avisabusif_ava");
		$st->execute();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[] = new T_j_avisabusif_ava($row["adh_id"], $row["avi_id"]);
		}
		return $list;
	}

	/*public static function AjouterAvisAbusif($adid, $avid)
	{
		$st = db()->prepare("insert into t_j_avisabusif_ava values(".$avid.",". $adid.")");
		$st->execute();
	}*/



				
	
}


