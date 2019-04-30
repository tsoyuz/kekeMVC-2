<?php

	require_once "Modele.php";

	//Modèle
	class Adherent extends Modele
	{
		//Variable
		private $_pseudo;
		private $_mail;
		private $_mdpHash;
		private $_estAdmin;
		
		//Constructeur
		public function __construct()
		{
			//Appelle le constructeur de la classe mère
			parent::__construct();
			
			//Initialise les variables
			$this->_pseudo = "UnPseudo";
			$this->_mail = "Pseudo@mail.com";
			$this->_mdpHash = "mdp";
			$this->_estAdmin = 0;
			
		}
		
		//Modifie les variables de l'adherent
		public function set($pseudo,$mail,$mdpHash,$estAdmin)
		{
			$this->_pseudo = $pseudo;
			$this->_mail = $mail;
			$this->_mdpHash = $mdpHash;
			$this->_estAdmin = $estAdmin;
		}
		
		//Modifie les variables de l'adherent avec un adherent
		public function setAdh($adh)
		{
			$this->_pseudo = $adh->_pseudo;
			$this->_mail = $adh->_mail;
			$this->_mdpHash = $adh->_mdpHash;
			$this->_estAdmin = $adh->_estAdmin;
		}
		
		//Créer la table
		public function bddTable()
		{
			$this->getBDD()->requete("
			CREATE TABLE IF NOT EXISTS `Adherent` (
			`Pseudo` varchar(32) NOT NULL,
			`Mail` varchar(64) NOT NULL,
			`MotDePasse` varchar(64) NOT NULL,
			`EstAdmin` int(1) NOT NULL,
			PRIMARY KEY (`Pseudo`) );");
		}
		
		//Selectionne un adhérent avec son pseudo et le hash du mot de passe
		public function bddSelect()
		{
			$req = $this->getBDD()->requete("SELECT * FROM Adherent WHERE Pseudo='" .$this->_pseudo  ."';");
			if($req->num_rows == 1)
			{
				$adh = mysqli_fetch_assoc($req);

				//Vérifie le mot de passe avec son hash
				if(password_verify($this->_mdpHash,$adh["MotDePasse"]) == true )
				{
					//Selection réussi
					$this->set($adh["Pseudo"],$adh["Mail"],$adh["MotDePasse"],$adh["EstAdmin"]);
					return true;
				}
				else
					return false;
			}
			else
				return false;
		}
		
		//Insert un adhérent
		public function bddInsert()
		{
			$this->getBDD()->requete("INSERT INTO Adherent VALUES ('" .$this->_pseudo ."','" .$this->_mail ."','" .$this->_mdpHash ."'," .$this->_estAdmin .");");
		}

		//Modifie un adhérent
		public function bddUpdate($key)
		{			
			$this->getBDD()->requete("UPDATE Adherent SET Mail='" .$this->_mail ."',MotDePasse='" .$this->_mdpHash ."',EstAdmin=" .$this->_estAdmin ."
								WHERE Pseudo='" .$key ."';");
		}
		
		//Verifie la validité
		public function checkValidite()
		{
			$req = $this->getBDD()->requete("SELECT * FROM Adherent WHERE Pseudo='" .$this->_pseudo  ."' AND MotDePasse='" .$this->_mdpHash ."';");
			if($req->num_rows == 1)
				return true;
			else
				return false;
		}
		
		//Chargement du modèle par le controleur
		public function ctrlLoad()
		{			
			//Vérifie si une session est valide pour afficher la vue de l'adherent connecte
			if(isset($_SESSION['adherent']) )
			{
				//Modifie l'adherent
				$this->setAdh(unserialize($_SESSION['adherent']) );
				
				//Sortie pour la vue
				$outAdh = $this;
				
				//Session Valide ? Sinon redirection
				if($this->checkValidite() )
					require_once "Vues/Adherent.html";
				else
				{
					unset($_SESSION['adherent']);
					header('Location: index.php');
				}
				//
			}
		}
		
		//Get Pseudo
		public function getPseudo()
		{
			return $this->_pseudo;
		}
		
		//Get MdpHash
		public function getMdpHash()
		{
			return $this->_mdpHash;
		}
		
		//Get Mail
		public function getMail()
		{
			return $this->_mail;
		}
		
		//Is Admin ?
		public function isAdmin()
		{
			return $this->_estAdmin;
		}
		
		//
	}
	
	////////////////////////////Code a exécuter lors de l'importation
	
	//Créer un objet adhérent
	$adh = new Adherent();
	$adh->bddTable();
	
	//Chargement par le modèle
	if(isset($_GET["modele"]) && $_GET["modele"] == "Adherent")
		$adh->ctrlLoad();	
	

?>
