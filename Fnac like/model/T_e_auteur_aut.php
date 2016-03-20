<?php
class T_e_auteur_aut{

	protected $_aut_id;
	protected $_aut_nom;

function __construct($idauteur) {

		$this->_aut_id = $idauteur;
		$this->_aut_nom = null;
		
		$st = db()->prepare("select * from t_e_auteur_aut where aut_id=".$idauteur);
		$st->execute();
		if ($st->rowCount() == 1) {
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$this->_aut_nom = $row["aut_nom"];
		}else {
			$st = db()->prepare("select max(aut_id) from t_e_auteur_aut");
			$st->execute();
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$id = $row["max"]+1;
			$st = db()->prepare("insert into t_e_auteur_aut(aut_id) values($id)");
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
		return $this->_aut_nom;
	}

	public static  function findAll()
	{
		$st = db()->prepare("select aut_id from t_e_auteur_aut");
		$st->execute();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[] = new T_e_auteur_aut($row["aut_id"]);
		}
		return $list;
	}

	public static function FindRecherche($nomAuteur)
	{
		$nomAut = ucfirst($nomAuteur);

		$st = db()->prepare("select aut_id from t_e_auteur_aut
							 where aut_nom like'%$nomAut%'");
		$st->execute();
		if ($st->rowCount() != 0) 
		{
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$idAut = $row["aut_id"];

			$st = db()->prepare("select * from t_e_livre_liv
								join t_j_auteurlivre_aul on t_j_auteurlivre_aul.liv_id = t_e_livre_liv.liv_id
								where t_j_auteurlivre_aul.aut_id = $idAut ");
			$st->execute();
			$list = array();
			if ($st->rowCount() !=0) 
			{
				while($row = $st->fetch(PDO::FETCH_ASSOC)) 
				{
					$list[] = new T_e_livre_liv($row["liv_id"]);
				}	
			}
			return $list;
		}
		else
		{
			$list=array();
			return $list;
		}	
	}

	public static function getAllAuteur($idauteur)
	{
		$st = db()->prepare("Select * from t_e_auteur_aut where aut_id=$idauteur");
		$st->execute();

		$liste = array();

		if($st->rowCount() >=1)
		{
			$row = $st->fetch(PDO::FETCH_ASSOC);
				$aut = new T_e_auteur_aut($row["aut_id"]);
				$liste[] = $aut;
			
			return $liste;
		}
	}
	
}



