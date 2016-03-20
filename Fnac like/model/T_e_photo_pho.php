<?php

class T_e_photo_pho{

	protected $_pho_id;
	protected $_liv_id;
	protected $_pho_url;
	

function __construct($idphoto) {

	$this->_pho_id = $idphoto;
	$this->_liv_id = null;
	$this->_pho_url = null;
	
	$st = db()->prepare("select * from t_e_photo_pho where pho_id=".$idphoto);
	$st->execute();
	if ($st->rowCount() == 1) {
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->_liv_id = $row["liv_id"];
		$this->_pho_url = $row["pho_url"];
	}else {
		$st = db()->prepare("select count(*) from t_e_photo_pho");
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$id = $row["count"]+1;
		$st = db()->prepare("insert into t_e_photo_pho values($id, 1, '')");
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
				$id = $fieldName;
				//print_r($id);
				if (isset($value->$id)) {
					$st = db()->prepare("update $table set $fieldName=:val where pho_id=:id");
					//$id = substr($id, 1);
					$st->bindValue(":val", $value);
				} else {
					$st = db()->prepare("update $table set $fieldName=:val where pho_id=:id");
					$st->bindValue(":val", $value);
				}
				//$id = "id".$table;
				$st->bindValue(":id", $this->_pho_id);
				$st->execute();
			} else
				throw new Exception("Unknown variable: ".$fieldName);
		}
	}

	function __toString() {
		return $this->_pho_url;
	}

	public static function findAll(){
		$st = db()->prepare("select pho_id from t_e_photo_pho");
		$st->execute();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[] = new T_e_photo_pho($row["pho_url"]);
		}
		return $list;
	}
	
	public static function recupereId()
	{
		$st = db()->prepare("Select max(pho_id) from t_e_photo_pho");
		$st->execute();

		if ($st->rowCount() !=0) 
		{
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$id = $row["max"]+1;
		}

		return $id;
	}

	public static function getAllPhoto($idlivre)
	{
		$st = db()->prepare("Select * from t_e_photo_pho where liv_id=$idlivre");
		$st->execute();

		$liste = array();
		if($st->rowCount() >= 1)
		{
			while($row = $st->fetch(PDO::FETCH_ASSOC))
			{
				$pho = new T_e_photo_pho($row["pho_id"]);
				$liste[] = $pho;
			}

			return $liste;
		}
	}

	public static function VerifNom($nom)
	{
		$st = db()->prepare("Select pho_url from t_e_photo_pho where pho_url='$nom'");
		$st->execute();

		if($st->rowCount() >= 1)
			return "1";
		else
			return "0";
	}
}
	