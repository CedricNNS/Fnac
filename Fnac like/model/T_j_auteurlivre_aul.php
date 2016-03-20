<?php

class T_e_auteur_aut{

	protected $_liv_id;
	protected $_aut_id;

function __construct($idlivre) {

	$this->_liv_id = $idlivre;
	$this->_aut_id = null;
	
	$st = db()->prepare("select * from t_j_auteurlivre_aul where liv_id=".$idlivre);
	$st->execute();
	if ($st->rowCount() == 1) {
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->_aut_id = $row["aut_id"];
	}else {
		$st = db()->prepare("select count(*) from t_j_auteurlivre_aul");
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$id = $row["count"]+1;
		$st = db()->prepare("insert into t_j_auteurlivre_aul(liv_id) values($id)");
		$st->execute();
	}
}

	function __get($name) {
		$attr = "_".$name;
		if (isset($this->$attr)) {
			return $this->$attr;
		} else {
			throw new Exception('Unknown '.$name);
		}
	}

	function __set($fieldName, $value) {
		$varName = "_".$fieldName;
		if ($value != null) {
			if (property_exists(get_class($this), $varName)) {
				$this->$varName = $value;
				$class = get_class($this);
				$table = strtolower($class);
				$id = "_id".$fieldName;
				if (isset($value->$id)) {
					$st = db()->prepare("update $table set id$fieldName=:val where id$table=:id");
					$id = substr($id, 1);
					$st->bindValue(":val", $value->$id);
				} else {
					$st = db()->prepare("update $table set $fieldName=:val where id$table=:id");
					$st->bindValue(":val", $value);
				}
				$id = "id".$table;
				$st->bindValue(":id", $this->$id);
				$st->execute();
			} else
				throw new Exception("Unknown variable: ".$fieldName);
		}
	}

	function __toString() {
		return $this->_liv_id;
	}

	public static function findAll()
	{
		$st = db()->prepare("select liv_id from t_j_auteurlivre_aul");
		$st->execute();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[] = new t_j_auteurlivre_aul($row["aut_id"]);
		}
		return $list;
	}

}