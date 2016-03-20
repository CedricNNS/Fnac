<?php
class T_e_adresse_adr{

	protected $_adr_id;
	protected $_adh_id;
	protected $_adr_nom;
	protected $_adr_type;
	protected $_adr_rue;
	protected $_adr_complementrue;
	protected $_adr_cp;
	protected $_adr_ville;
	protected $_pay_id;
	protected $_adr_latitude;
	protected $_adr_longitude;   

function __construct($idadresse) {

	$this->_adr_id = $idadresse;
	$this->_adh_id = null;
	$this->_adr_nom = null;
	$this->_adr_type = null;
	$this->_adr_rue = null;
	$this->_adr_complementrue = null;
	$this->_adr_cp = null;
	$this->_adr_ville = null;
	$this->_pay_id = null;
	$this->_adr_latitude = null;
	$this->_adr_longitude = null;
	
	
	
	$st = db()->prepare("select * from t_e_adresse_adr where adr_id=".$idadresse);
	$st->execute();
	if ($st->rowCount() == 1) {
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->_adr_nom = $row["adr_nom"];
		$this->_adr_type = $row["adr_type"];
		$this->_adr_rue = $row["adr_rue"];
		$this->_adr_complementrue = $row["adr_complementrue"];		
		$this->_adr_cp = $row["adr_cp"];
		$this->_adr_ville = $row["adr_ville"];
		$this->_pay_id = $row["pay_id"];
		$adresse=$row["adr_rue"]." ".$row["adr_complementrue"]." ".$row["adr_cp"]." ".$row["adr_ville"];
		$this->_adr_latitude = T_e_adresse_adr::findLatitude($adresse);
		$this->_adr_longitude = T_e_adresse_adr::findLongitude($adresse);
	}else {
		$st = db()->prepare("select count(*) from t_e_adresse_adr");
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$id = $row["count"]+1;
		$st = db()->prepare("insert into t_e_adresse_adr(adr_id) values($id)");
		$st->execute();
	}
}
	
	
	
	
	
	
	/*$st = db()->prepare("select * from t_e_adresse_adr where adr_id=".$idadresse);

		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$id = $row["count"]+1;
		$st = db()->prepare("insert into t_e_adresse_adr(adr_id) values($id)");
		$st->execute();
	}*/

	
	
	
	
	

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
		return $this->_adr_rue;
		return $this->_adr_complementrue;
		return $this->_adr_ville;
		return $this->_adr_cp;
	}


	/**
	**	Fonction qui retourne la latitude d'une adresse donnée RÉELLE
	**/
	public static function findLatitude($adresse){
		// URL of Bing Maps REST Locations API; 
    	$baseURL = "http://dev.virtualearth.net/REST/v1/Locations";
  
  		// Set key based on user input
  		$key = "AnieqmEgGxfOJuWN4VG5A0EGd8-Ewtl72jGlKM56NRNDIgGHPZB1-xEbl_GR-B_J";  
  		// Create URL to find a location by query
  		$adresse = str_ireplace(" ","%20",$adresse);
  		$findURL = $baseURL."/".$adresse."?output=xml&key=".$key;

		  // Get output from URL and convert to XML element using php_xml

		$output = file_get_contents($findURL);
  		$response = new SimpleXMLElement($output);
  
  		// Extract latitude from results
  		$latitude = $response->ResourceSets->ResourceSet->Resources->Location->Point->Latitude;
  
		return $latitude;
	}


	/**
	**	Fonction qui retourne la longitude d'une adresse donnée RÉELLE
	**/
	public static function findLongitude($adresse){
		// URL of Bing Maps REST Locations API; 
    	$baseURL = "http://dev.virtualearth.net/REST/v1/Locations";
  
  		// Set key based on user input
  		$key = "AnieqmEgGxfOJuWN4VG5A0EGd8-Ewtl72jGlKM56NRNDIgGHPZB1-xEbl_GR-B_J";  
  		// Create URL to find a location by query
  		$adresse = str_ireplace(" ","%20",$adresse);
  		$findURL = $baseURL."/".$adresse."?output=xml&key=".$key;

		// Get output from URL and convert to XML element using php_xml

		$output = file_get_contents($findURL);
  		$response = new SimpleXMLElement($output);
  
  		// Extract longitude from results
  		$longitude = $response->ResourceSets->ResourceSet->Resources->Location->Point->Longitude;
  
		return $longitude;
	}
	
	/**
	**	Fonction qui retourne toutes les données stockées dans la BDD sur l'adresse de facturation de l'adhérent.
	**/
	public static function findAll(){
		$st = db()->prepare("select * from t_e_adresse_adr where adr_type='Facturation' and adh_id=".$_SESSION["idAdherent"]);
		$st->execute();
		$list=array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$adr = new T_e_adresse_adr($row["adr_id"]);
			$list[] = $adr;
		}
		return $list;
	}

	/**
	**	Fonction qui retourne toutes les données stockées dans la BDD sur les adresses de livraison de l'adhérent.
	**/
	public static function findAllLivraisons(){
		$st = db()->prepare("select * from t_e_adresse_adr where adr_type='Livraison' and adh_id=".$_SESSION["idAdherent"]);
		$st->execute();
		$list=array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$adr = new T_e_adresse_adr($row["adr_id"]);
			$list[] = $adr;
		}
		return $list;
	}
	
	/**
	**	Fonction qui retourne toutes les données stockées dans la BDD sur l'adresse de facturation de l'adhérent.
	**/
	public static function findByAdherent(){
		$st = db()->prepare("select * from t_e_adresse_adr where adr_type='Facturation' and adh_id=".$_SESSION["idAdherent"]);
		$st->execute();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$adr = $row["adr_id"];
			return $adr;
		}
		return null;
	}

	/**
	**	Fonction qui retourne la latitude d'une adresse donnée.
	**/
	public static function getLatitude($idAdr){
		$st = db()->prepare("select adr_latitude from t_e_adresse_adr where adr_id =$idAdr");
		$st->execute();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$lat = $row["adr_latitude"];
			return $lat;
		}
		return 0;
	}

	/**
	**	Fonction qui retourne la longitude d'une adresse donnée.
	**/
	public static function getLongitude($idAdr){
		$st = db()->prepare("select adr_longitude from t_e_adresse_adr where adr_id =$idAdr");
		$st->execute();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$long = $row["adr_longitude"];
			return $long;
		}
		return 0;
	}
	
	/**
	**	Fonction qui retourne une adresse lisible par l'API responsable de la conversion d'adresse en coordonnées XY.
	**/
	public static function getAdresse($id){
		$st = db()->prepare("select adr_rue, adr_complementrue, adr_cp, adr_ville, pay_nom from t_e_adresse_adr join t_r_pays_pay on t_r_pays_pay.pay_id = t_e_adresse_adr.pay_id where adr_id =$id");
		$st->execute();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$adresse = $row["adr_rue"]." ".$row["adr_complementrue"]." ".$row["adr_cp"]." ".$row["adr_ville"]." ".$row["pay_nom"];
			return $adresse;
		}
	}

	/**
	**	Fonction qui retourne l'id d'une nouvelle adresse.
	**/
	public static function getLastAdresse(){
		$st = db()->prepare("select max(adr_id) from t_e_adresse_adr");
		$st->execute();
		if ($st->rowCount() == 1) {
			$row = $st->fetch(PDO::FETCH_ASSOC);
			$id = $row["max"]+1;
			return $id;
		}
	}

	/**
	**	Fonction qui retourne toutes les données d'une adresse.
	**/
	public static function getAdresseById($id){
		$st = db()->prepare("select * from t_e_adresse_adr where adr_id =$id");
		$st->execute();
		$list = array();
		while($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$list[] = $row;
		}
		return $list;
	}

	/**
	**	Fonction qui insert dans la BDD une nouvelle adresse.
	**/
	public static function addInDB($idAdr, $idAdh, $nom, $type, $rue, $complement, $cp,$ville, $pays, $lat, $long){
		$st = db()->prepare("insert into t_e_adresse_adr values($idAdr, $idAdh, '$nom', '$type', '$rue', '$complement', '$cp', '$ville', $pays, $lat, $long)");
		$st->execute();
	}

	/**
	**	Fonction qui met à jour une ligne donnée de la BDD.
	**/
	public static function updateDB($idAdr, $idAdh, $nom, $rue, $complement, $cp,$ville, $pays, $lat, $long){
		$st = db()->prepare("update t_e_adresse_adr set adr_nom='$nom', adr_rue='$rue', adr_complementrue='$complement', adr_cp='$cp', adr_ville='$ville', pay_id=$pays, adr_latitude=$lat, adr_longitude=$long where adr_id=$idAdr");
		$st->execute();
	}

	/**
	**	Fonction qui supprime une ligne donnée de la BDD.
	**/
	public static function deleteFromDB($id){
		$st = db()->prepare("delete from t_e_adresse_adr where adr_id = $id");
		$st->execute();
	}
	
}