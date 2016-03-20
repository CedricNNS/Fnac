<?php

class T_e_editeur_edi{

	protected $_edi_id;
	protected $_edi_nom;

function __construct($idediteur) {

	$this->_edi_id = $idediteur;
	$this->_edi_nom = null;
	
	$st = db()->prepare("select * from t_e_editeur_edi where edi_id=".$idediteur);
	$st->execute();
	if ($st->rowCount() == 1) {
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->_edi_nom = $row["edi_nom"];
	}else {
		$st = db()->prepare("select count(*) from t_e_editeur_edi");
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$id = $row["count"]+1;
		$st = db()->prepare("insert into t_e_editeur_edi(edi_id) values($id)");
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
		$varName = $fieldName;
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
				$id = $fieldName;
				$st->bindValue(":id", $this->$id);
				$st->execute();
			} else
				throw new Exception("Unknown variable: ".$fieldName);
		}
	}

	function __toString() {
		return $this->_edi_nom;
	}

	public static function findAll()
	{
		$st = db()->prepare("select edi_id from t_e_editeur_edi");
		$st->execute();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[] = new T_e_auteur_aut($row["edi_id"]);
		}
		return $list;
	}
}