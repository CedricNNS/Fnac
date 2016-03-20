<?php

class T_e_adresse_adrController
 extends Controller {


	public function index() {
		$this->render("index");
	}
	
	/**
	**	Fonction qui affiche les adresses de l'utilisateur, en vue d'en ajouter, de les modifier ou de les supprimer.
	**/
	public function view() {
		
		$list = T_e_adresse_adr::findAll();
		if(!empty($list))
			$_SESSION["facturation"] = $list;
		
		$list = T_e_adresse_adr::findAllLivraisons();
		if(!empty($list))
			$_SESSION["livraison"] = $list;
		

		$this->render("view");
	}

	/**
	**	Fonction qui détermine quel bouton a été préssé et quelle fonction doit être utilisée sur quel objet.
	**/
	public function modifAdresse(){
		if(isset($_POST["creerFacturation"])){
			$list = T_r_pays_pay::findAll();
			$this->render("newFacturation", $list);
		}

		if(isset($_POST["modifierFacturation"])){
			$_SESSION["factu"] = T_e_adresse_adr::findAll();
			$list = T_r_pays_pay::findAll();
			$this->render("updateFacturation", $list);
		}

		if(isset($_POST["creerLivraison"])){
			$list = T_r_pays_pay::findAll();
			$this->render("newLivraison", $list);
		}

		$val = T_e_adresse_adr::getLastAdresse();
		for($i=0;$i<=$val;$i++){
			if(isset($_POST["modifier$i"])){
				$_SESSION["idAdr"] = $i;
				$_SESSION["livr"] = T_e_adresse_adr::getAdresseById($i);
				$list = T_r_pays_pay::findAll();
				$this->render("updateLivraison", $list);
			}

			if(isset($_POST["supprimer$i"])){
				T_e_adresse_adr::deleteFromDB($i);
				$this->view();
			}
		}
	}

	/**
	**	Fonction qui permet d'ajouter une adresse de facturation à la BDD. Permet aussi l'affichage des erreurs suite à la vérification du contenu des champs.
	**/
	public function addFacturation(){
		if(isset($_POST["val"])){
			if(!empty($_POST["nom"]) && !empty($_POST["rue"]) && !empty($_POST["cp"]) && preg_match("#^[0-9]{5}$#",$_POST["cp"])==1 && !empty($_POST["ville"])){
				$_POST["pays"]--;
				$id = T_e_adresse_adr::getLastAdresse();
				$list = T_r_pays_pay::findAll();
				$adresse = $_POST["nom"]." ".$_POST["rue"]." ".$_POST["cptAdresse"]." ".$_POST["cptAdresse"]." ".$_POST["ville"]." ".$list[$_POST["pays"]][$_POST["pays"]+1];
				$lat = T_e_adresse_adr::findLatitude($adresse);
				$long = T_e_adresse_adr::findLongitude($adresse);
				T_e_adresse_adr::addInDB($id, $_SESSION["idAdherent"],$_POST["nom"],"Facturation", $_POST["rue"], $_POST["cptAdresse"], $_POST["cp"], $_POST["ville"], $_POST["pays"]+1, $lat, $long);
				$_SESSION["val"] = "<div id='valide'>Vous avez créé votre adresse de facturation.</div>";
			}
			else
			{
				$_SESSION["nom"] = $_POST["nom"];
				$_SESSION["rue"] = $_POST["rue"];
				$_SESSION["cp"] = $_POST["cp"];
				$_SESSION["ville"] = $_POST["ville"];
				$_SESSION["cptAdresse"] = $_POST["cptAdresse"];

				$count=0;
				$error = "La validation n'a pas été effectuée pour la/les raison(s) suivante(s) :<br/>";
				if(empty($_POST["nom"])){
					$count++;
					unset($_SESSION["nom"]);
					$error = $error."- Votre adresse n'a pas de nom.<br/>";
				}
				if(empty($_POST["rue"])){
					$count++;
					unset($_SESSION["rue"]);
					$error = $error."- Vous n'avez pas indiqué le numéro et le nom de la rue de votre adresse.<br/>";
				}
				if(empty($_POST["cp"])){
					$count++;
					unset($_SESSION["cp"]);
					$error = $error."- Vous avez oublié de rentrer un code postal.<br/>";
				}
				if(preg_match("#^[0-9]{5}$#",$_POST["cp"])==0 && !empty($_POST["cp"])){
					$count++;
					unset($_SESSION["cp"]);
					$error=$error."- Vous n'avez pas entré de code postal.<br/>";
				}
				if(empty($_POST["ville"])){
					$count++;
					unset($_SESSION["ville"]);
					$error = $error."- Vous n'avez pas entré le nom de votre ville.<br/>";
				}

				if($count>0){
					$_SESSION["error"] = $error;
				}
			}
			$this->render("newLivraison", $list);
		}
	}

	/**
	**	Fonction qui permet de modifier l'adresse de facturation dans la BDD. Permet aussi l'affichage des erreurs suite à la vérification du contenu des champs.
	**/
	public function updateFacturation(){
		if(isset($_POST["val"])){
			if(!empty($_POST["nom"]) && !empty($_POST["rue"]) && !empty($_POST["cp"]) && preg_match("#^[0-9]{5}$#",$_POST["cp"])==1 && !empty($_POST["ville"])){
				$_POST["pays"]--;
				$id = T_e_adresse_adr::findAll();
				$list = T_r_pays_pay::findAll();
				$adresse = $_POST["rue"]." ".$_POST["cptAdresse"]." ".$_POST["cptAdresse"]." ".$_POST["ville"]." ".$list[$_POST["pays"]][$_POST["pays"]+1];
				$lat = T_e_adresse_adr::findLatitude($adresse);
				$long = T_e_adresse_adr::findLongitude($adresse);
				T_e_adresse_adr::updateDB($id[0]->adr_id, $_SESSION["idAdherent"],$_POST["nom"], $_POST["rue"], $_POST["cptAdresse"], $_POST["cp"], $_POST["ville"], $_POST["pays"]+1, $lat, $long);
				$_SESSION["valFac"] = "<div id='valide'>Votre adresse de facturation à été mise à jour.</div>";
				$this->view();
			}
			else
			{
				$_SESSION["nom"] = $_POST["nom"];
				$_SESSION["rue"] = $_POST["rue"];
				$_SESSION["cp"] = $_POST["cp"];
				$_SESSION["ville"] = $_POST["ville"];
				$_SESSION["cptAdresse"] = $_POST["cptAdresse"];

				$count=0;
				$error = "La validation n'a pas été effectuée pour la/les raison(s) suivante(s) :<br/>";
				if(empty($_POST["nom"])){
					$count++;
					unset($_SESSION["nom"]);
					$error = $error."- Votre adresse n'a plus de nom.<br/>";
				}
				if(empty($_POST["rue"])){
					$count++;
					unset($_SESSION["rue"]);
					$error = $error."- Vous n'avez pas indiqué le numéro et le nom de la rue de votre nouvelle adresse.<br/>";
				}
				if(empty($_POST["cp"])){
					$count++;
					unset($_SESSION["cp"]);
					$error = $error."- Vous avez oublié de rentrer un code postal.<br/>";
				}
				if(preg_match("#^[0-9]{5}$#",$_POST["cp"])==0 && !empty($_POST["cp"])){
					$count++;
					unset($_SESSION["cp"]);
					$error=$error."- Vous n'avez pas entré de code postal.<br/>";
				}
				if(empty($_POST["ville"])){
					$count++;
					unset($_SESSION["ville"]);
					$error = $error."- Vous n'avez pas entré le nom de votre nouvelle ville.<br/>";
				}

				if($count>0){
					$_SESSION["error"] = $error;
				$list = T_r_pays_pay::findAll();
				$this->render("updateFacturation", $list);
				}
			}
		}
	}

	/**
	**	Fonction qui permet d'ajouter une adresse de livraison à la BDD. Permet aussi l'affichage des erreurs suite à la vérification du contenu des champs.
	**/
	public function addLivraison(){
		if(isset($_POST["val"])){
			if(!empty($_POST["nom"]) && !empty($_POST["rue"]) && !empty($_POST["cp"]) && preg_match("#^[0-9]{5}$#",$_POST["cp"])==1 && !empty($_POST["ville"])){
				$_POST["pays"]--;
				$id = T_e_adresse_adr::getLastAdresse();
				$list = T_r_pays_pay::findAll();
				$adresse = $_POST["nom"]." ".$_POST["rue"]." ".$_POST["cptAdresse"]." ".$_POST["cptAdresse"]." ".$_POST["ville"]." ".$list[$_POST["pays"]][$_POST["pays"]+1];
				$lat = T_e_adresse_adr::findLatitude($adresse);
				$long = T_e_adresse_adr::findLongitude($adresse);
				T_e_adresse_adr::addInDB($id, $_SESSION["idAdherent"],$_POST["nom"],"Livraison", $_POST["rue"], $_POST["cptAdresse"], $_POST["cp"], $_POST["ville"], $_POST["pays"]+1, $lat, $long);
				$_SESSION["val"] = "<div id='valide'>Vous avez créé une nouvelle adresse de livraison.</div>";
			}
			else
			{
				$_SESSION["nom"] = $_POST["nom"];
				$_SESSION["rue"] = $_POST["rue"];
				$_SESSION["cp"] = $_POST["cp"];
				$_SESSION["ville"] = $_POST["ville"];
				$_SESSION["cptAdresse"] = $_POST["cptAdresse"];

				$count=0;
				$error = "La validation n'a pas été effectuée pour la/les raison(s) suivante(s) :<br/>";
				if(empty($_POST["nom"])){
					$count++;
					unset($_SESSION["nom"]);
					$error = $error."- Votre adresse n'a pas de nom.<br/>";
				}
				if(empty($_POST["rue"])){
					$count++;
					unset($_SESSION["rue"]);
					$error = $error."- Vous n'avez pas indiqué le numéro et le nom de la rue de votre adresse.<br/>";
				}
				if(empty($_POST["cp"])){
					$count++;
					unset($_SESSION["cp"]);
					$error = $error."- Vous avez oublié de rentrer un code postal.<br/>";
				}
				if(preg_match("#^[0-9]{5}$#",$_POST["cp"])==0 && !empty($_POST["cp"])){
					$count++;
					unset($_SESSION["cp"]);
					$error=$error."- Vous n'avez pas entré de code postal.<br/>";
				}
				if(empty($_POST["ville"])){
					$count++;
					unset($_SESSION["ville"]);
					$error = $error."- Vous n'avez pas entré le nom de votre ville.<br/>";
				}

				if($count>0){
					$_SESSION["error"] = $error;
				}
			}
			$list = T_r_pays_pay::findAll();
			$this->render("newLivraison", $list);
		}
	}

	/**
	**	Fonction qui permet de modifier l'adresse de facturation dans la BDD. Permet aussi l'affichage des erreurs suite à la vérification du contenu des champs.
	**/
	public function updateLivraison(){
		if(isset($_POST["val"])){
			if(!empty($_POST["nom"]) && !empty($_POST["rue"]) && !empty($_POST["cp"]) && preg_match("#^[0-9]{5}$#",$_POST["cp"])==1 && !empty($_POST["ville"])){
				$_POST["pays"]--;
				$id = $_SESSION["idAdr"];
				$list = T_r_pays_pay::findAll();
				$adresse = $_POST["rue"]." ".$_POST["cptAdresse"]." ".$_POST["cptAdresse"]." ".$_POST["ville"]." ".$list[$_POST["pays"]][$_POST["pays"]+1];
				$lat = T_e_adresse_adr::findLatitude($adresse);
				$long = T_e_adresse_adr::findLongitude($adresse);
				T_e_adresse_adr::updateDB($id, $_SESSION["idAdherent"],$_POST["nom"], $_POST["rue"], $_POST["cptAdresse"], $_POST["cp"], $_POST["ville"], $_POST["pays"]+1, $lat, $long);
				$_SESSION["valLiv"] = "<span id='valide'>Votre adresse de facturation à été mise à jour.</span>";
				$this->view();
			}
			else
			{
				$_SESSION["nom"] = $_POST["nom"];
				$_SESSION["rue"] = $_POST["rue"];
				$_SESSION["cp"] = $_POST["cp"];
				$_SESSION["ville"] = $_POST["ville"];
				$_SESSION["cptAdresse"] = $_POST["cptAdresse"];

				$count=0;
				$error = "La validation n'a pas été effectuée pour la/les raison(s) suivante(s) :<br/>";
				if(empty($_POST["nom"])){
					$count++;
					unset($_SESSION["nom"]);
					$error = $error."- Votre adresse n'a plus de nom.<br/>";
				}
				if(empty($_POST["rue"])){
					$count++;
					unset($_SESSION["rue"]);
					$error = $error."- Vous n'avez pas indiqué le numéro et le nom de la rue de votre nouvelle adresse.<br/>";
				}
				if(empty($_POST["cp"])){
					$count++;
					unset($_SESSION["cp"]);
					$error = $error."- Vous avez oublié de rentrer un code postal.<br/>";
				}
				if(preg_match("#^[0-9]{5}$#",$_POST["cp"])==0 && !empty($_POST["cp"])){
					$count++;
					unset($_SESSION["cp"]);
					$error=$error."- Vous n'avez pas entré de code postal.<br/>";
				}
				if(empty($_POST["ville"])){
					$count++;
					unset($_SESSION["ville"]);
					$error = $error."- Vous n'avez pas entré le nom de votre nouvelle ville.<br/>";
				}

				if($count>0){
					$_SESSION["error"] = $error;
				$list = T_r_pays_pay::findAll();
				$this->render("updateFacturation", $list);
				}
			}
		}
	}
	
	
}
