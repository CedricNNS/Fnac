<?php

class T_e_relais_rel{

	protected $_rel_id;
	protected $_rel_nom;
	protected $_rel_rue;
	protected $_rel_cp;
	protected $_rel_ville;
	protected $_pay_id;
	protected $_rel_latitude;
	protected $_rel_longitude;
	
	

function __construct($idrelais) {

	$this->_rel_id = $idrelais;
	$this->_rel_nom = null;
	$this->_rel_rue = null;
	$this->_rel_cp = null;
	$this->_rel_ville = null;
	$this->_pay_id = null;
	$this->_rel_latitude = null;
	$this->_rel_longitude = null;
	
	
	
	$st = db()->prepare("select * from t_e_relais_rel where rel_id=".$idrelais);
	$st->execute();
	if ($st->rowCount() == 1) {
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->_rel_nom = $row["rel_nom"];
		$this->_rel_rue = $row["rel_rue"];
		$this->_rel_cp = $row["rel_cp"];
		$this->_rel_ville = $row["rel_ville"];
		$this->_pay_id = $row["pay_id"];
		$this->_rel_latitude = $row["rel_latitude"];
		$this->_rel_longitude = $row["rel_longitude"];
	}else {
		$st = db()->prepare("select count(*) from t_e_relais_rel");
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$id = $row["count"]+1;
		$st = db()->prepare("insert into t_e_relais_rel(rel_id) values($id)");
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
		return $this->_rel_nom;
		return $this->_rel_rue;
		return $this->_rel_ville;
	}

	public static function findAll(){
		$st = db()->prepare("select * from t_e_relais_rel");
		
		$st->execute();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[] = array($row["rel_id"], $row["rel_latitude"], $row["rel_longitude"], $row["rel_nom"], $row["rel_rue"], $row["rel_cp"], $row["rel_ville"]);
		}
		return $list;
	}
	
	public static function TriAdresse()
	{
		$st = db()->prepare("SELECT distinct adr_cp FROM t_e_adresse_adr JOIN t_e_adherent_adh on t_e_adresse_adr.adh_id=t_e_adherent_adh.idt_e_adherent_adh WHERE t_e_adherent_adh.idt_e_adherent_adh='1'");
		$st->execute();
		
		if($st->rowCount() >= 1)
		{
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$cp = substr($row["adr_cp"],0,1);
			return $cp;
		}else{
			return 0;
		}
	}


}
	