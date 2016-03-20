<?php

class T_j_relaisadherent_rea{

	protected $_adh_id;
	protected $_rel_id;

function __construct($idrelais, $idadh) {

	$this->_rel_id = $idrelais;
	$this->_adh_id = $idadh;
	
	$st = db()->prepare("select * from t_j_relaisadherent_rea where adh_id=".$idadh." and rel_id=".$idrelais);
	$st->execute();
	if ($st->rowCount() == 1) {
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->_rel_id = $row["rel_id"];
	} else {
		$st = db()->prepare("select count(*) from t_j_relaisadherent_rea");
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$id = $row["count"]+1;
		$st = db()->prepare("insert into t_j_relaisadherent_rea(rel_id) values($id)");
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
		return $this->_rel_id;
	}

	public static function findAll()
	{
		$st = db()->prepare("select rel_id from t_j_relaisadherent_rea");
		$st->execute();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[] = new t_j_relaisadherent_rea($row["adh_id"]);
		}
		return $list;
	}

	public static function addDb($idAdherent, $val){
		$st = db()->prepare("select * from  t_j_relaisadherent_rea where adh_id = $idAdherent");
		$st->execute();	
		
			if($st->rowCount()==0){
				$st = db()->prepare("insert into t_j_relaisadherent_rea values (".$idAdherent.",".$val.")");
				$st->execute();
				return "true";
			}else{
				$st = db()->prepare("update t_j_relaisadherent_rea set rel_id = $val where adh_id = $idAdherent");
				$st->execute();
				return "false";
			}
				
	}

}