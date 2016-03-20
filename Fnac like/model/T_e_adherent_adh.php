<?php


class T_e_adherent_adh{

	protected $_idt_e_adherent_adh;
	protected $_adh_numadherent;
	protected $_adh_datefinadhesion;
	protected $_adh_mel;
	protected $_adh_motpasse;
	protected $_adh_pseudo;
	protected $_adh_civilite;
	protected $_adh_nom;
	protected $_adh_prenom;
	protected $_adh_telfixe;
	protected $_adh_telportable;
	protected $_admin;

	//Constructeur de la classe Adhérant
	function __construct($idAdherent) {
		$this->_idt_e_adherent_adh = $idAdherent;
		$this->_adh_numadherent = null;
		$this->_adh_datefinadhesion = null;
		$this->_adh_mel = null;
		$this->_adh_motpasse = null;
		$this->_adh_pseudo = null;
		$this->_adh_civilite = null;
		$this->_adh_nom = null;
		$this->_adh_prenom = null;
		$this->_adh_telfixe = null;
		$this->_adh_telportable = "";
		$this->_admin = 0;

		$st = db()->prepare("select * from t_e_adherent_adh where idt_e_adherent_adh=".$idAdherent);
		$st->execute();
		if ($st->rowCount() == 1) {
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$this->_adh_numadherent = $row["adh_numadherent"];
			$this->_adh_datefinadhesion = $row["adh_datefinadhesion"];
			$this->_adh_mel = $row["adh_mel"];
			$this->_adh_motpasse = $row["adh_motpasse"];
			$this->_adh_pseudo = $row["adh_pseudo"];
			$this->_adh_civilite = $row["adh_civilite"];
			$this->_adh_nom = $row["adh_nom"];
			$this->_adh_prenom = $row["adh_prenom"];
			$this->_adh_telfixe = $row["adh_telfixe"];
			$this->_adh_telportable = $row["adh_telportable"];
			$this->_admin = $row["admin"];
		}else {
			$st = db()->prepare("insert into t_e_adherent_adh values(".$idAdherent.", 0000000, '2020-01-01', 'mail@mail.fr', 'mdp', 'pseudo', 'M.', 'nom', 'prenom', '0102030405', '', 0)");
			//$st = db()->prepare("insert into t_e_adherent_adh (idt_e_adherent_adh) values (".$idAdherent.")");
			$st->execute();
		}
	}

	/*function __construct($id=null)	
	{
		if ($id == null) {
				$st = db()->prepare("insert into t_e_adherent_adh default values returning idt_e_adherent_adh");
				$st->execute();
				$row = $st->fetch();
				$field = "idt_e_adherent_adh";
				print_r($field);
				$this->$field = $row[$field];
			} else {
				$st = db()->prepare("select * from t_e_adherent_adh where idt_e_adherent_adh=:id");
				$st->bindValue(":id", $id);
				$st->execute();
				if ($st->rowCount() != 1) {
					throw new Exception("Not in table: t_e_adherent_adh id: ".$id );
				} else {
					$row = $st->fetch(PDO::FETCH_ASSOC);
					foreach($row as $field=>$value) {
						if (substr($field, 0,2) == "id") {
							$linkedField = substr($field, 2);
							$linkedClass = ucfirst($linkedField);
							if ($linkedClass != get_class($this))
								$this->$linkedField = new $linkedClass($value);
							else
								$this->$field = $value;
						} else
							$this->$field = $value;
					}
				}
			}
	}*/

	//Get de la classe Adhérent
	function __get($name) {
		$attr = "_".$name;
		if (isset($this->$attr)) {
			return $this->$attr;
		} else {
			throw new Exception('Unknown '.$name);
		}
	}

	//Set de la classe Adhérent
	function __set($fieldName, $value) {
		$varName = "_".$fieldName;
		//if ($value != null) {
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
		//}
	}


	public static function idAdherent()
	{
		$st = db()->prepare("select max(idt_e_adherent_adh) from t_e_adherent_adh");
		$st->execute();
		if ($st->rowCount() == 1) {
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$id = $row["max"]+1;
		}
		else
			throw new Exception("Problème récupération ID adhérent");

		return $id;
	}

	public static function numAdherent()
	{
		$st = db()->prepare("select max(adh_numadherent) from t_e_adherent_adh");
		$st->execute();
		if ($st->rowCount() == 1) {
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$num = $row["max"]+1;
		}
		else
			throw new Exception("Problème récupération numero adhérent");

		return $num;
	}

	//To String de la classe ADhérent
	function __toString() {
		return $this->_adh_mel;
	}

	public static function getIdAdherent(){
		$st = db()->prepare("select idt_e_adherent_adh, adh_pseudo from t_e_adherent_adh where adh_mel='".parameters()["adh_mel"]."' and adh_motpasse='".parameters()["adh_motpasse"]."'");
		$st->execute();
		if ($st->rowCount() == 1) {
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$_SESSION["idAdherent"] = $row["idt_e_adherent_adh"];
			$_SESSION["connected"] = $row["adh_pseudo"];
			return $row["idt_e_adherent_adh"];
		}
		else
		{
			unset($_SESSION["idAdherent"]);
			$_SESSION["error"] = "Erreur d'authentification";
			$_SESSION["adh_mel"] = parameters()["adh_mel"];
			return "Error";
		}
	}

	public static function verifMailTel($mail, $telfixe)
	{
		$st = db()->prepare("Select * from t_e_adherent_adh where adh_mel='$mail' or adh_telfixe = '$telfixe'");
		$st->execute();
		if ($st->rowCount() == 1)
		{
			
			return "false";
		}else{
			return "true";
		}
	}
	
	public static function isAdmin($idAdherent){
		$st = db()->prepare("Select admin from t_e_adherent_adh where idt_e_adherent_adh='$idAdherent' and admin = 1");
		$st->execute();
		if ($st->rowCount() == 1)
			{
			return "true";
		}else{
			return "false";
		}
	}

	public static function getId($mail)
	{
		$st = db()->prepare("select * from t_e_adherent_adh");
		$st->execute();
		while($row = $st->fetch(PDO::FETCH_ASSOC))
		{
		
			$test = $row["adh_mel"];
			if(md5($test) == $mail)
			{
				return $row["idt_e_adherent_adh"];
			}
		}
		
	}

	/*public static function getRelais($idAdherent){
		$st = db()->prepare("select * from t_e_relais_rel join t_j_relaisadherent_rea on t_e_relais_rel.rel_id = t_j_relaisadherent_rea.rel_id where adh_id = $idAdherent");
		$st->execute();
		$temp = array();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC))
		{
			$list[] = new t_e_relais_rel($row["rel_nom"], $row["rel_rue"], $row["rel_cp"], $row["rel_ville"]);
		}
		return $list;

	}*/
}



