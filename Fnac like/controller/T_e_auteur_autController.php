<?php

class T_e_auteur_autController
 extends Controller {


	public function index() {
		$this->render("index", T_e_auteur_aut::findAll());
	}

	public function view() {
		if(isset(parameters()["id"]))
		{
			$this->render("view", T_e_livre_liv::TouteInfoLivre(parameters()["id"]));
		} 
		else
		{
			(new SiteController())->render("index");
			// $this->render("error");
		}
	}

	//Fonction qui recherche les livres d'un auteur, appele la méthode FindRecherche de la classe Auteur.
	public function recherche()
	{

		if(isset($_POST["submit"])){
			if(!empty(parameters()["nomAut"]))
			{
				$nomAuteur = $_POST["nomAut"];
				$this->render("actions", T_e_auteur_aut::FindRecherche($nomAuteur));
			}
			else
			{
				$l=array();
				$this->render("actions", $l);
			}
		}
		
		
	}



}


