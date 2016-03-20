<?php

class T_e_livre_livController
 extends Controller {


	public function index() {
		$this->render("index", T_e_livre_liv::findAll());
	}

	public function view() {
		try {
			if(isset(parameters()["idliv"]))
				$id = parameters()["idliv"];
			else
				$id = parameters()["id"];
			$this->render("view", T_e_livre_liv::TouteInfoLivre($id));
		} catch (Exception $e) {
			(new T_e_livre_livController())->render("error");
		}
	}

	public function ajoutP()
	{
		if(isset(parameters()["panier"]))
		{
			if(isset(parameters()["livre"]))
				$id_liv = parameters()["livre"];

			//$_SESSION["livre"] = array();
			$_SESSION["livre"][] = T_e_livre_liv::FindLivre($id_liv);

			$_SESSION["ajoutPanier"] = 1;

			$this->render("view", T_e_livre_liv::TouteInfoLivre($id_liv));
		}
	}
	public function panier()
	{
			$this->render("panier", $_SESSION["livre"]);
	}



}


