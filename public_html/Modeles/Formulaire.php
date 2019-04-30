<?php

	require_once "Modele.php";
	
	//Nécessaire pour les forumaires lié aux adhérents
	require_once "Adherent.php";

	//Modèle
	class Formulaire extends Modele
	{
		
		//Constructeur
		public function __construct()
		{
			//Appelle le constructeur de la classe mère pour avoir la base de données
			parent::__construct();
			
			//Si on a validé un formulaire
			if(isset($_GET["valid"]) )
			{
				//Inscription
				if($_GET["valid"] == 1)
					$this->inscription();
				//Mdp Oublié
				if($_GET["valid"] == 2)
					$this->mdpOublie();
				//Connexion
				if($_GET["valid"] == 3)
					$this->connexion();
				//Modification du mot de passe
				if($_GET["valid"] == 4)
					$this->mdpModif();
				//Déconnexion
				if($_GET["valid"] == 5)
				{
					unset($_SESSION['adherent']);
					header('Location: index.php');
				}

			}
			
		}
		
		//Inscription
		private function inscription()
		{
			//On vérifie que le formulaire est bien rempli
			if(isset($_POST["pseudo"]) && isset($_POST["email"]) )
			{
				//Mot de passe crypté
				$mdp = $this->randomPassword();
				$cry = password_hash($mdp, PASSWORD_DEFAULT);
				
				//Créer et ajoute l'adhérent
				$adh = new Adherent();
				$adh->set($_POST["pseudo"],$_POST["email"],$cry,0);
				$adh->bddInsert();
				
				//Envoi du Mail
				$objet = "Inscription au site des Blaireux et des Kékés.";
				$message = "Bonjour " .$_POST["pseudo"] .",\nVoici votre mot de passe :\n" .$mdp;
				mail($_POST["email"],$objet,wordwrap($message, 70, "\r\n") );
			}
		}
		
		//Mot de passe oublié
		private function mdpOublie()
		{
			//On vérifie que le formulaire est bien rempli et que l'adherent existe
			if(isset($_POST["pseudo"]) && isset($_POST["email"]) && isset($_SESSION['adherent']) )
			{				
				//Mot de passe crypté
				$mdp = $this->randomPassword();
				$cry = password_hash($mdp, PASSWORD_DEFAULT);
				
				//Créer et ajoute l'adhérent
				$adh = new Adherent();
				$adh->set($_POST["pseudo"],$_POST["email"],$cry,0);
				$adh->bddUpdate($_POST["pseudo"]);
				
				//Envoi du Mail
				$objet = "Nouveau mot de passe au site des Blaireux et des Kékés.";
				$message = "Bonjour " .$_POST["pseudo"] .",\nVoici votre mot de passe :\n" .$mdp;
				mail($_POST["email"],$objet,wordwrap($message, 70, "\r\n") );
			}
		}
		
		//Connexion
		private function connexion()
		{
			//On vérifie que le formulaire est bien rempli
			if(isset($_POST["pseudo"]) && isset($_POST["mdp"]) )
			{
				//Crée un adhérent avec le pseudo et le mot de passe
				$adh = new Adherent();
				$adh->set($_POST["pseudo"],"",$_POST["mdp"],0);

				//Le pseudo et le mot de passe correspond ?
				if($adh->bddSelect() )
				{
					//On nettoie la session
					unset($_SESSION['adherent']);
					
					//On définie la session actuel
					$_SESSION['adherent'] = serialize($adh);
					
					//On redirige vers la page de l'adherent
					header('Location: index.php?modele=Adherent');
				}
				else
					echo "<b>Pseudo ou Mot de passe incorrect</b>";

				//
			}
		}
		
		//Modifie le mot de passe
		private function mdpModif()
		{
			//On vérifie que le formulaire est bien rempli
			if(isset($_POST["newMdp"]) && isset($_POST["oldMdp"]) )
			{
				//Crée un adhérent pour verifier le vieux mot de passe
				$oldAdh = unserialize($_SESSION['adherent']);
				if(password_verify($_POST["oldMdp"],$oldAdh->getMdpHash() ) == true)
				{
					//Mot de passe crypté
					$cry = password_hash($_POST["newMdp"], PASSWORD_DEFAULT);
					
					//Créer et ajoute l'adhérent
					$adh = new Adherent();
					$adh->set($oldAdh->getPseudo(),$oldAdh->getMail(),$cry,0);
					$adh->bddUpdate($adh->getPseudo() );
										
					//Modifie l'adhérent de la session
					$_SESSION['adherent'] = serialize($adh);
				}
				else
					echo "<b>Mot de passe incorrect</b>";
			}
		}
		
		//Génère un mot de passe de 8 caractères aléatoire, source : https://stackoverflow.com/questions/6101956/generating-a-random-password-in-php
		private function randomPassword() 
		{
			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$pass = array(); //remember to declare $pass as an array
			$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
			for ($i = 0; $i < 8; $i++) {
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
			return implode($pass); //turn the array into a string
		}
		
		//
	}
	
	////////////////////////////Code a exécuter lors de l'importation
	$formu = new Formulaire();

?>