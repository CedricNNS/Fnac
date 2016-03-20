<?php

class T_e_avis_aviController
 extends Controller {


	public function index() {
		$this->render("index", T_e_avis_avi::findAll());
	}
	
	public function view() {
		try {
			$l = new T_e_livre_liv(parameters()["id"]);
			$this->render("view", $l);
		} catch (Exception $e) {
			(new SiteController())->render("index");
			// $this->render("error");
		}
	}
	

}
