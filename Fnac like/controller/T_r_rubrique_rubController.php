<?php

class T_r_rubrique_rubController
 extends Controller {


	public function index() {
		$list = array();
		$list = T_r_rubrique_rub::findAll();
		asort($list);
		$this->render("index", $list);
	}

	public function view() {
		try {
			$l = new T_r_rubrique_rub(parameters()["id"]);
			$this->render("view", $l);
		} catch (Exception $e) {
			(new SiteController())->render("index");
			// $this->render("error");
		}
	}


	//Fonction qui recherhce les livres d'une rubrique, appele la méthode FindRecherche de la classe Genre.
	public function recherche()
	{

		if(isset(parameters()["submit"])){
				$idrubrique = parameters()["rubrique"];
				$rubrique = new T_r_rubrique_rub($idrubrique);
				$_SESSION["rubrique"] = $rubrique->rub_libelle;
				$this->render("actions", T_r_rubrique_rub::FindRecherche($idrubrique));	
		}
		
	}

	




}


