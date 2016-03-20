<?php

class T_j_avisabusif_avaController
 extends Controller {


	public function index() {
		$this->render("index", T_j_avisabusif_ava::findAll());
	}

	public function view() {
		try {
			/*$l = new T_j_avisabusif_ava(parameters()["id"]);
			$this->render("view", $l);*/
		} catch (Exception $e) {
			(new SiteController())->render("index");
			// $this->render("error");
		}
	}

	public function ajoutAvisSignale() {
		if(isset(parameters()["signaler"]))
		{
			//$id = T_e_adherent_adh::getId(parameters()["adherent"]) ;
            $bool = new T_j_avisabusif_ava(T_e_adherent_adh::getId(parameters()["adherent"]), parameters()["avis"]);           
            /*$list = T_e_relais_rel::findAll();
            $table = array_sort($list);*/
            $this->render("view",$bool);
		}
	}


}

