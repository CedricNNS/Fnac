<?php

class T_e_livre_liv{

	protected $_liv_id;
	protected $_for_id;
	protected $_edi_id;
	protected $_gen_id;
	protected $_liv_titre;
	protected $_liv_histoire;
	protected $_liv_dateparution;
	protected $_liv_prixttc;
	protected $_liv_isbn;
	protected $_liv_stock;
	protected $_pho_url;
	protected $_avi_id;
	protected $_aut_id;
	
	

	



//Constructeur de la classe Livre
function __construct($idlivre) {
		$this->_liv_id = $idlivre;
		$this->_for_id = null;
		$this->_edi_id = null;
		$this->_gen_id = null;
		$this->_liv_titre = null;
		$this->_liv_histoire = null;
		$this->_liv_dateparution = null;
		$this->_liv_prixttc = null;
		$this->_liv_isbn = null;
		$this->_liv_stock = null;
		$this->_pho_url = null;
		

		$st = db()->prepare("select t_e_livre_liv.liv_id, for_id, edi_id, gen_id, liv_titre, liv_histoire, to_char(liv_dateparution, 'DD-MM-YYYY') AS liv_dateparution, liv_prixttc, liv_isbn, liv_stock, t_e_photo_pho.pho_url
							from t_e_livre_liv
								JOIN t_e_photo_pho ON t_e_livre_liv.liv_id=t_e_photo_pho.liv_id
							where t_e_livre_liv.liv_id=".$idlivre);
		$st->execute();
		if ($st->rowCount() >= 1) {
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$this->_for_id = $row["for_id"];
			$this->_edi_id = $row["edi_id"];
			$this->_gen_id = $row["gen_id"];
			$this->_liv_titre = $row["liv_titre"];
			$this->_liv_histoire = $row["liv_histoire"];
			$this->_liv_dateparution = $row["liv_dateparution"];
			$this->_liv_prixttc = $row["liv_prixttc"];
			$this->_liv_isbn = $row["liv_isbn"];
			$this->_liv_stock = $row["liv_stock"];
			$this->_pho_url = $row["pho_url"];
			
		}
		/*else if ($st->rowCount() > 1)
		{
			
			$i = 1;
			while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
				if($i = 1)
				{
					$this->_for_id = $row["for_id"];
					$this->_edi_id = $row["edi_id"];
					$this->_gen_id = $row["gen_id"];
					$this->_liv_titre = $row["liv_titre"];
					$this->_liv_histoire = $row["liv_histoire"];
					$this->_liv_dateparution = $row["liv_dateparution"];
					$this->_liv_prixttc = $row["liv_prixttc"];
					$this->_liv_isbn = $row["liv_isbn"];
					$this->_liv_stock = $row["liv_stock"];
					$this->_pho_url = $row["pho_url"];
					$i =0;
				}
			
				
				
			}
		}*/
		else {
			$st = db()->prepare("select count(*) from t_e_livre_liv");
			$st->execute();
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$id = $row["count"]+1;
			$st = db()->prepare("insert into t_e_adherent_adh(liv_id) values($id)");
			$st->execute();
		}

	}

	// Get de la classe Livre
	function __get($name) {
		$attr = "_".$name;
		if (isset($this->$attr)) {
			return $this->$attr;
		} else {
			throw new Exception('Unknown '.$name);
		}
	}

	//Set de la classe Livre
	function __set($fieldName, $value) {
		$varName = "_".$fieldName;
		if ($value != null) {
			if (property_exists(get_class($this), $varName)) {
				$this->$varName = $value;
				$class = get_class($this);
				$table = strtolower($class);
				$id = $fieldName;
				if (isset($value->$id)) {
					$st = db()->prepare("update $ta
						ble set id$fieldName=:val where id$table=:id");
					$id = substr($id, 1);
					$st->bindValue(":val", $value->$id);
				} else {
					$st = db()->prepare("update $table set $fieldName=:val where id$table=:id");
					//$st->bindValue(":val", $value);
				}
				$id = $fieldName;
				//$st->bindValue(":id", $this->$id);
				$st->execute();
			} else
				throw new Exception("Unknown variable: ".$fieldName);
		}
	}

	public static function FindLivre($id)
	{
		$st = db()->prepare("select * from t_e_livre_liv where liv_id = $id");
		$st->execute();
		$liste = array();
		if($st->rowCount() ==1)
		{
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$liste[] = new T_e_livre_liv($row["liv_id"]);
		}

		return $liste;
	}


	public static function TouteInfoLivre($idlivre)
	{
		$st = db()->prepare("select * from t_e_livre_liv
									JOIN  t_e_avis_avi on t_e_livre_liv.liv_id=t_e_avis_avi.liv_id
									JOIN  t_j_auteurlivre_aul on t_e_livre_liv.liv_id=t_j_auteurlivre_aul.liv_id
									JOIN t_e_auteur_aut on t_j_auteurlivre_aul.aut_id=t_e_auteur_aut.aut_id
									where t_e_livre_liv.liv_id = $idlivre");
			$st->execute();
			$list = array();
			if ($st->rowCount() > 1) {

				$row = $st->fetch(PDO::FETCH_ASSOC);
				$add = new T_e_livre_liv($row["liv_id"]);
				$add->for_id = new T_r_format_for($row["for_id"]);
				$add->edi_id = new T_e_editeur_edi($row["edi_id"]);
				$add->aut_id = new T_e_auteur_aut($row["aut_id"]);

				while($row1 = $st->fetch(PDO::FETCH_ASSOC)) {
					$add->avi_id = T_e_avis_avi::AllAvis($row1["liv_id"]);
				}	

				$list[] = $add;
				return $list;
			}
			else if ($st->rowCount() == 1)
			{
					$row = $st->fetch(PDO::FETCH_ASSOC);
					$add = new T_e_livre_liv($row["liv_id"]);
					$add->for_id = new T_r_format_for($row["for_id"]);
					$add->edi_id = new T_e_editeur_edi($row["edi_id"]);
					$add->aut_id = new T_e_auteur_aut($row["aut_id"]);
					$add->avi_id = T_e_avis_avi::AllAvis($row["liv_id"]);

					$list[] = $add;
				
				return $list;
			}
			else {
				$list=array();
				return $list;
			}
	}

	//To String de la classe Livre
	function __toString() {
		return $this->_liv_titre;
	}


}




