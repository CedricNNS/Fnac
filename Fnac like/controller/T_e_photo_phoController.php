<?php 


class T_e_photo_phoController extends Controller {

	
	public function index() {
		$this->render("index", T_e_photo_pho::getAllPhoto(parameters()["idli"]));
	}

	public function about() {
		$this->render("about");	
	}

	public function ajout(){
		if(isset(parameters()["submit"]))
		{
			// récupération de la pièce jointe
    		
		    $file_name = $_FILES['photo']['name']; //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.pdf).
		    $type_fichier = $_FILES['photo']['type']; //Le type du fichier. Par exemple, cela peut être « image/png ».
		    $size = $_FILES['photo']['size'] ; //La taille du fichier en octets.
		    $tmp_name = $_FILES['photo']['tmp_name']; //L'adresse vers le fichier uploadé dans le répertoire temporaire.
		    $code_error = $_FILES['photo']['error']; // //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé
		    $max_size = 1000000;
		          
		    //$extension = strtolower(  substr(  strrchr($_FILES['photo']['name'], '.')  ,1)  );

		    $extensions = array('.png', '.gif', '.jpg', '.jpeg','.JPG');
			$extension = strrchr($_FILES['photo']['name'], '.'); 

			//Début des vérifications de sécurité...
			if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
			{
			     $_SESSION["erreur"] = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
			}
			if($size>$max_size)
			{
			     $_SESSION["erreur"] = 'Le fichier est trop gros...';
			     
			}
			if(T_e_photo_pho::VerifNom($file_name) == "1")
			{
				$_SESSION["erreur"] = "Photo deja ajouté !";
			}
			if(!isset($_SESSION["erreur"])) //S'il n'y a pas d'erreur, on upload
			{  
			    //déplacement du fichier vers le dossier de destination : je réecris un nom de fichier avec le code de l'utilisateur enregistré par le formulaire
			    $chemin_fichier = $_SERVER["DOCUMENT_ROOT"]."INFO/213/SprintSave/Photos/{$file_name}";
			   //chmod($chemin_fichier, 777);
			    $resultat = move_uploaded_file($_FILES['photo']['tmp_name'],$chemin_fichier);

			    $pho = new T_e_photo_pho(T_e_photo_pho::recupereId());
			    $pho->pho_url = $file_name;
			    $pho->liv_id = parameters()["idl"];

			    $_SESSION["ajoutPho"] = "<span class='Valide'> Photo Ajouté !</span>";

			    $arr = array();
			    $arr = T_e_photo_pho::getAllPhoto(parameters()["idl"]);
			    
			    $this->render("index", $arr);
			}
			else
			{
				$this->render("index", $_SESSION["erreur"]); 
			}

		}
	}
	


}