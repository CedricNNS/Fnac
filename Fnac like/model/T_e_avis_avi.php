<?php



class T_e_avis_avi{

	protected $_avi_id;
	protected $_adh_id;
	protected $_liv_id;
	protected $_avi_date;
	protected $_avi_titre;
	protected $_avi_detail;
	protected $_avi_note;

function __construct($idavis) {

	$this->_avi_id = $idavis;
	$this->_adh_id = null;
	$this->_liv_id = null;
	$this->_avi_date = null;
	$this->_avi_titre = null;
	$this->_avi_detail = null;
	$this->_avi_note = null;
	
	$st = db()->prepare("select avi_id, adh_id, liv_id, to_char(avi_date, 'DD-MM-YYYY') AS avi_date, avi_titre, avi_detail, avi_note from t_e_avis_avi where avi_id=".$idavis);
	$st->execute();
	if ($st->rowCount() == 1) {
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->_adh_id = new T_e_adherent_adh($row["adh_id"]);
		$this->_liv_id = $row["liv_id"];
		$this->_avi_date = $row["avi_date"];
		$this->_avi_titre = $row["avi_titre"];
		$this->_avi_detail = $row["avi_detail"];
		$this->_avi_note = $row["avi_note"];
	}else {
		$st = db()->prepare("select count(*) from t_e_avis_avi");
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$id = $row["count"]+1;
		$st = db()->prepare("insert into t_e_avis_avi(avi_id) values($id)");
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
		return $this->_avi_detail;
	}

/*	public static function findAll()
	{
		$st = db()->prepare("select avi_id from t_e_avis_avi");
		$st->execute();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[] = new T_e_avis_avi($row["avi_detail"]);
		}
		return $list;
	}*/

	public static function AllAvis($idlivre)
	{
		$st = db()->prepare("select avi_id, adh_id, liv_id, to_char(avi_date, 'DD-MM-YYYY') AS avi_date, avi_titre, avi_detail, avi_note from t_e_avis_avi where liv_id = $idlivre");
		$st->execute();
		if($st->rowCount() != 0)
		{
			$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[] = new T_e_avis_avi($row["avi_id"]);
		}
		return $list;
		}
	}

}


