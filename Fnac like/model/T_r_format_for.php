<?php

class T_r_format_for{

	protected $_for_id;
	protected $_for_libelle;

function __construct($idformat) {

	$this->_for_id = $idformat;
	$this->_for_libelle = null;
	
	$st = db()->prepare("select * from t_r_format_for where for_id=".$idformat);
	$st->execute();
	if ($st->rowCount() == 1) {
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->_for_libelle = $row["for_libelle"];
	}else {
		$st = db()->prepare("select count(*) from t_r_format_for");
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$id = $row["count"]+1;
		$st = db()->prepare("insert into t_r_format_for(for_id) values($id)");
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
		return $this->_for_libelle;
	}

	public static function findAll()
	{
		$st = db()->prepare("select edi_id from t_r_format_for");
		$st->execute();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[] = new T_r_format_for($row["for_libelle"]);
		}
		return $list;
	}

}