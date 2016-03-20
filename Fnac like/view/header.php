<!DOCTYPE html> 
<html>
<head>
	<meta charset="UTF-8">
	<link rel="icon" href="https://srv-prj.iut-acy.local/INFO/213/SprintSave/fnac.ico" />
	<title>Fnac.com</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css" />
	
	</div>
</head>
<body>

	<header>
	<h1><a href= "?r=site/index"><img src="https://srv-prj.iut-acy.local/INFO/213/SprintSave/fnac.png" id="logo"></img> Fnac.com</a></h1>
		<div id="compte">
			<?php if(!isset($_SESSION["connected"])){?>
				<a id="lienConnection" href= "?r=t_e_adherent_adh/connection">Se connecter</a>
				<a id="lienInscription" href="?r=t_e_adherent_adh/inscription">S'inscrire</a>
			<?php }else{ ?>
				<a id="modifierCompte" href="?r=t_e_adherent_adh/modifier">Modifier mon compte </a>
				<a id="gererAdresses" href="?r=t_e_adresse_adr/view"> Gérer les adresses</a>
			<?php } ?>
		</div>
		<?php if(isset($_SESSION["connected"])) {?>
				<span id="hello">Bonjour <?php echo $_SESSION["connected"]; ?></span>
				<a id="lienDeconnection" href="?r=t_e_adherent_adh/deconnection">Déconnexion</a>
		<?php } ?>
		
	</header>
	<nav>
		<ul id="menu-deroulant">
			<?php
			if(isset($_SESSION["connected"])){ ?>
			<li><a href="?r=t_e_relais_rel/view">Choisir point relais</a></li>
			<?php } ?>
			<?php
			if(isset($_SESSION["connected"])){ ?>
			<li><a href="?r=t_j_avisabusif_ava/index">Avis abusifs</a></li>
			<?php } ?>
			<li id="rech"><a id="recherche" href="#">Recherche</a>
			<ul>
  				<li><a href="?r=t_r_genre_gen">Par genre</a></li>
  				<li><a href="?r=t_e_auteur_aut">Par auteur</a></li>
  				<li><a href="?r=t_r_rubrique_rub">Par rubrique</a></li>
			 </ul>
  			</li>
 			<?php
 				if(isset($_SESSION["ajoutPanier"]))
 				{?>
 					<li><a href='?r=t_e_livre_liv/panier'>Votre Panier</a></li>
 				<?php	
 				}?>
		</ul>
	</nav><br/><br/>
	<section>	
</body>
</html>



        