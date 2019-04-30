<?php

	//On démarre la session
	session_start();

	//Affiche les erreurs
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	//Charge le modèle de gestion de formulaire
	require_once "Modeles/Formulaire.php";
	
	//Obtient le modèle de l'url
	if(isset($_GET["modele"]) )
	{		
		$modFile = "Modeles/" .$_GET["modele"] .".php";
		require_once $modFile;
	}
	//Page d'accueil
	else
	{
		//Session
		if(isset($_SESSION['adherent']) )
			header('Location: index.php?modele=Adherent');
		//Pas de session
		else
		{
			$homeFile = "Vues/accueil.html";
			require_once $homeFile;
		}
	}
	
	//
	

?>