<?php

class T_e_adherent_adhController extends Controller {


	public function index() {
		
		$this->render("index", T_e_adherent_adh::findAll());
	}

	public function view() {
		$adherent = new T_e_adherent_adh(T_e_adherent_adh::getId(parameters()["ida"]));
		$this->render("view", $adherent);
	}
	
	//Fonction qui sert a modifier le compte d'un utilisateur.
	public function modifier(){
		
		$a = new T_e_adherent_adh($_SESSION["idAdherent"]);
		/*$list = T_e_adherent_adh::getRelais($_SESSION["idAdherent"]);
		$_SESSION["relais"] = "";
		foreach ($list as $value) {
			$_SESSION["relais"] = $_SESSION["relais"] + "<div>".$."<br>".$list[$i][1]."<br>".$list[$i][2]." ".$list[$i][3]."</div>";
		}*/

		if(isset(parameters()["modif"]))
		{
			if(preg_match("#^[0-9]{10}$#", parameters()["telfix"])==1 &&
				preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$#", parameters()["mail"])==1 &&
				(preg_match("#^0[6-7][0-9]{8}$#", parameters()["telportable"])==1 || empty(parameters()["telportable"])) &&
				preg_match("#^[a-zA-Z\s-]*$#", parameters()["nom"])==1 &&
				preg_match("#^[a-zA-Z\s-]*$#", parameters()["prenom"])==1 &&
				!empty(parameters()["mail"]) && !empty(parameters()["pseudo"]) && !empty(parameters()["nom"]) &&
				!empty(parameters()["prenom"]) && !empty(parameters()["mdp"]) && !empty(parameters()["telfix"])
				&& parameters()["telfix"]!= parameters()["telportable"]){
					$a->adh_mel = parameters()["mail"];
					$a->adh_motpasse = parameters()["mdp"];
					$a->adh_pseudo = parameters()["pseudo"];
					$a->adh_nom = parameters()["nom"];
					$a->adh_prenom = parameters()["prenom"];
					$a->adh_telfixe = parameters()["telfix"];
					$a->adh_telportable = parameters()["telportable"];
					$_SESSION["connected"] = parameters()["pseudo"];
					$_SESSION["modifOK"] = "Votre compte a été mis a jour !";
			}else{
				$count = 0;
				$error = "Modification impossible : <br/>";
				
				if(preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$#", parameters()["mail"])==0 || empty(parameters()["mail"])){
					$count++;
					$error = $error."- l'adressse mail n'est pas valide.<br/>";
				}

				if(empty(parameters()["mdp"])){
					$count++;
					$error = $error."- le mot de passe est obligatoire.<br/>";
				}

				if(empty(parameters()["pseudo"])){
					$count++;
					$error = $error."- vous devez entrer un pseudo.<br/>";
				}

				if(preg_match("#^[a-zA-Z\s-]*$#", parameters()["nom"])==0 || empty(parameters()["nom"])){
					$count++;
					$error = $error."- le nom n'est pas valide.<br/>";
				}
				if(preg_match("#^[a-zA-Z\s-]*$#", parameters()["prenom"])==0 || empty(parameters()["prenom"])){
					$count++;
					$error = $error."- le prénom n'est pas valide.<br/>";
				}
				if(preg_match("#^[0-9]{10}$#", parameters()["telfix"])==0 || empty(parameters()["telfix"])){
					$count++;
					$error = $error."- le numéro de téléphone fixe n'est pas valide.<br/>";
				}
				
				if(preg_match("#^0[6-7][0-9]{8}$#", parameters()["telportable"])==0 && !empty(parameters()["telportable"])){
					$count++;
					$error = $error."- le numéro de téléphone portable n'est pas valide. Il doit commencer par 06 ou 07.</br>";
				}
				if(parameters()["telfix"]==parameters()["telportable"]){
						$count++;
						$error = $error."- les deux numéros de téléphone doivent être différents.<br/>";
				}
				if($count>0){
					$_SESSION["error"] = $error;
				}
			}
		}

		$this->render("modifier", $a);
	}
	
	//Fonction qui sert a inscrire un adhérent dans la base de donnée.
	public function inscription(){
		if (isset(parameters()["inscr"])) 
		{
			if (T_e_adherent_adh::verifMailTel(parameters()["adh_mel"], parameters()["adh_telfixe"]) == "false")
			{
				$_SESSION["inscriptionEchec"] = "<div id=\"error\">Ces coordonnées sont déjà liées à un compte.</div>";
				$this->render("inscription");
			}
			else
			{
				if(preg_match("#^[0-9]{10}$#", parameters()["adh_telfixe"])==1 &&
					preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$#", parameters()["adh_mel"])==1 &&
					(preg_match("#^0[6-7][0-9]{8}$#", parameters()["adh_telportable"])==1 || empty(parameters()["adh_telportable"])) &&
					preg_match("#^[a-zA-Z\s-]*$#", parameters()["adh_nom"])==1 &&
					preg_match("#^[a-zA-Z\s-]*$#", parameters()["adh_prenom"])==1 &&
					!empty(parameters()["adh_mel"]) && !empty(parameters()["adh_pseudo"]) && !empty(parameters()["adh_nom"]) &&
					!empty(parameters()["adh_prenom"]) && !empty(parameters()["adh_motpasse"]) && !empty(parameters()["adh_telfixe"])
					&& (parameters()["adh_telfixe"])!= (parameters()["adh_telportable"]))
				{
					
						$nouveau = new T_e_adherent_adh(T_e_adherent_adh::idAdherent());
						$nouveau->adh_numadherent = T_e_adherent_adh::numAdherent();
						$nouveau->adh_datefinadhesion= "2020-01-01";
						$nouveau->adh_mel= parameters()["adh_mel"];
						$nouveau->adh_motpasse = parameters()["adh_motpasse"];
						$nouveau->adh_pseudo = parameters()["adh_pseudo"];
						$nouveau->adh_civilite = parameters()["adh_civilite"];
						$nouveau->adh_nom = parameters()["adh_nom"];
						$nouveau->adh_prenom = parameters()["adh_prenom"];
						$nouveau->adh_telfixe = parameters()["adh_telfixe"];
						$nouveau->adh_telportable = parameters()["adh_telportable"];
						//print_r($nouveau);
						$_SESSION["inscriptionValidee"] = "<div id=\"valide\">Votre inscription a bien été prise en compte.<br/> Veuillez vous connecter s'il vous plait.</div>";
						$this->render("connection");
				}
				else
				{
					$_SESSION["adh_mel"] = parameters()["adh_mel"];
					$_SESSION["adh_motpasse"] = parameters()["adh_motpasse"];
					$_SESSION["adh_pseudo"] = parameters()["adh_pseudo"];
					$_SESSION["adh_nom"] = parameters()["adh_nom"];
					$_SESSION["adh_prenom"] = parameters()["adh_prenom"];
					$_SESSION["adh_telfixe"] = parameters()["adh_telfixe"];
					$_SESSION["adh_telportable"] = parameters()["adh_telportable"];
					$_SESSION["adh_civilite"]= parameters()["adh_civilite"];
					$error = "<div id=\"error\">Votre formulaire contient des erreurs : <br/> ";
					$count=0;


					if(preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$#", parameters()["adh_mel"])==0){
						unset($_SESSION["adh_mel"]);
						$error = $error."Il faut rentrer votre adresse mail dans le premier champ.<br/> ";
						$count++;
					}else{
						if(empty(parameters()["adh_mel"])){
							unset($_SESSION["adh_mel"]);
							$error = $error."Il faut rentrer votre adresse mail dans le premier champ.<br/> ";
							$count++;
						}
					}
					
					if(empty(parameters()["adh_motpasse"])){
						unset($_SESSION["adh_motpasse"]);
						$error = $error."Il faut rentrer votre mot de passe dans le deuxième champ.<br/> ";
						$count++;
					}
					if(empty(parameters()["adh_pseudo"])){
						unset($_SESSION["adh_pseudo"]);
						$error = $error."Il faut rentrer votre pseudo dans le troisième champ.<br/> ";
						$count++;
					}
					if(preg_match("#^[a-zA-Z\s-]*$#", parameters()["adh_nom"])==0){
						unset($_SESSION["adh_nom"]);
						$error = $error."Il faut rentrer votre nom dans le cinquième champ.<br/> ";
						$count++;
					}else{
						if(empty(parameters()["adh_nom"])){
							unset($_SESSION["adh_nom"]);
							$error = $error."Il faut rentrer votre nom dans le cinquième champ.<br/> ";
							$count++;
						}
					}
					if(preg_match("#^[a-zA-Z\s-]*$#", parameters()["adh_prenom"])==0){
						unset($_SESSION["adh_prenom"]);
						$error = $error."Il faut rentrer votre prénom dans le sixième champ.<br/> ";
						$count++;
					}else{
						if(empty(parameters()["adh_prenom"])){
							unset($_SESSION["adh_prenom"]);
							$error = $error."Il faut rentrer votre prénom dans le sixième champ.<br/> ";
							$count++;
						}
					}
					if(preg_match("#^[0-9]{10}$#", parameters()["adh_telfixe"])==0  && isset(parameters()["adh_telfixe"])){
						unset($_SESSION["adh_telfixe"]);
						$error = $error."Il faut rentrer votre numéro de téléphone dans l'avant dernier champ.<br/> ";
						$count++;

					}
					if(preg_match("#^0[6-7][0-9]{8}$#", parameters()["adh_telportable"])==0 && !empty(parameters()["adh_telportable"])){
						unset($_SESSION["adh_telportable"]);
						$error = $error."Il faut rentrer votre numéro de téléphone dans le dernier champ. Il doit commencer par 06 ou 07.<br/> ";
						$count++;
					}
					if((parameters()["adh_telfixe"])==(parameters()["adh_telportable"])){
						unset($_SESSION["adh_telportable"]);
						unset($_SESSION["adh_telfixe"]);
						$error = $error."Les deux numéros de téléphone doivent être différents.<br/> ";
						$count++;
					}
					$error = $error."</div>";

					if($count > 0){
						$_SESSION["error"] = $error;
					}

					$this->render("inscription");

				}
			}
			
			
		} 
		else
		{
			$this->render("inscription");
		}
	}

	public function connection(){
		if(isset($_POST["submit"])){
			if(is_numeric(T_e_adherent_adh::getIdAdherent())){
				$adh = new T_e_adherent_adh(T_e_adherent_adh::getIdAdherent());
				if(T_e_adherent_adh::isAdmin($_SESSION["idAdherent"])=="true")
					$_SESSION["admin"]="admin connected";
			}
			if(isset($_SESSION["error"]))
				$this->render("connection");
			if(isset($_SESSION["idAdherent"]))
				$this->render("modifier", new T_e_adherent_adh($_SESSION["idAdherent"]));
		}else{
			$this->render("connection");
		}
	}

	public function deconnection(){
		if(isset($_SESSION["connected"]))
			unset($_SESSION["connected"]);
		if(isset($_SESSION["admin"]))
			unset($_SESSION["admin"]);
		$this->render("deconnexion");
	}
}