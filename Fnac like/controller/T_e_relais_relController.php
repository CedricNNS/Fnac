<?php 


class T_e_relais_relController extends Controller {

	
	public function index() {
		$this->render("index");
	}

	public function view() {
		$list = T_e_relais_rel::findAll();
		$table = array_sort($list);
		$this->render("view",$table);	
	}
	
	public function choix()
	{
		if(isset(parameters()["submit"]))
        {
            $choix = parameters()["radiobutton"];
            $bool = T_j_relaisadherent_rea::addDb($_SESSION["idAdherent"], $choix);
            if($bool=="true")
                $_SESSION["msg"] = "<div id='valide'>Un nouveau point de relais a été ajouté à votre compte.</div>";
            else
                $_SESSION["msg"] = "<div id='valide'>Votre point de relai a été actualisé.</div>";

            $list = T_e_relais_rel::findAll();
            $table = array_sort($list);
            $this->render("view",$table);
        }
	}
}
	



    function array_sort($array){
        if(isset($_SESSION["idAdherent"])){
            $id = T_e_adresse_adr::findByAdherent();
            $long = T_e_adresse_adr::getLongitude($id);
            $lat = T_e_adresse_adr::getLatitude($id);
        }else{
            $long = 0;
            $lat = 0;
        }
        $dist = array();
        if(count($array)>0){
            for($i = 0; $i<count($array); $i++){
                $val = sqrt((pow($lat - $array[$i][1], 2))+(pow($long - $array[$i][2], 2)));
                $dist[] = array($array[$i][0] => $val);
            }

            $table = array();
            foreach ($dist as $key => $val){
                for($i=0;$i<count($array);$i++){
                    if($key+1==$array[$i][0]){
                        $var = sqrt((pow($lat - $array[$i][1], 2))+(pow($long - $array[$i][2], 2)));
                        $table[$i][0] = $key+1;
                        $table[$i][1] = $var;
                        $table[$i][2] = $array[$i][3];
                        $table[$i][3] = $array[$i][4];
                        $table[$i][4] = $array[$i][5];
                        $table[$i][5] = $array[$i][6];
                    }
                }
            }
            $tableau = array();
            for($i=0;$i<count($table);$i++){
                $temp = 999;
                for($j=0;$j<count($table)-$i;$j++){
                    if($table[$j][1]<$temp){
                        $idtemp = $j;
                        $temp = $table[$j][1];
                    }
                }
                $tableau[] = $table[$idtemp];
                for($j=$idtemp;$j<count($table)-1;$j++){
                    if($j==count($table)){
                        unset($table[$j]);
                    }else{
                        $table[$j] = $table[$j+1];
                    }
                }
            }

        }
        return $tableau;
    }