<?php

class T_r_genre_genController
 extends Controller {


	public function index() {
		$list = array();
		$list = T_r_genre_gen::findAll();
		asort($list);
		$this->render("index", $list);
	}

	public function view() {
		try {
			$l = new T_r_genre_gen(parameters()["id"]);
			$this->render("view", $l);
		} catch (Exception $e) {
			(new SiteController())->render("index");
			// $this->render("error");
		}
	}

	public function avAjouter()
	{
		$this->render("ajouter");
	}

	//Fonction qui recherhce les livres d'un genre, appele la méthode FindRecherche de la classe Genre.
	public function recherche()
	{

		if(isset(parameters()["submit"])){
				$idgenre = parameters()["genre"];
				$genre = new T_r_genre_gen($idgenre);
				$_SESSION["genre"] = $genre->gen_libelle;
				$this->render("actions", T_r_genre_gen::FindRecherche($idgenre));		
		}
		
	}

	public function ajouter()
	{
		if(isset(parameters()["add"]))
		{
			if(!empty(parameters()["ajou"])){
					//$gen = new T_r_genre_gen(::);
					$genre = parameters()["ajou"];
					
					if(T_r_genre_gen::VerifGenre(parameters()["ajou"]) == "true")
					{
						$new = new T_r_genre_gen(T_r_genre_gen::IDGenre());

						$new->gen_libelle = strtoupper(parameters()["ajou"]);
						$_SESSION["valide"] = "Votre genre a bien été ajouté !";
						$this->render("ajouter");
					}
					else
					{
						$_SESSION["error"]= "Le nom du genre existe déjà !";
						$this->render("ajouter");
					}
				
			
			}else{
				$_SESSION["error"]= "Le nom du genre ne peut pas être vide";
				$this->render("ajouter");
			}
			/*if(isset($_SESSION["errorGenre"]))
			{
				$error = $_SESSION["errorGenre"];
				$this->render("index", $error );
			}
			else
			{
				$this->render("index", $g);
			}*/
				
		}

	}



}


