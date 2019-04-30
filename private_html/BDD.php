<?php

	class BDD
	{

		//Connexion mysqli
		private $_mysqli;
		
		//Constructeur
		public function __construct()
		{
			$host = "localhost";
			$user = "bdd";
			$pwd = "34GukY4FybL~>(8;";
			$db = "keke";
			
			//Se connecte à la base s'il peut, sinon renvoi l'erreur
			$this->_mysqli = new mysqli($host,$user,$pwd,$db);
			if ($this->_mysqli->connect_errno)
				echo "Echec lors de la connexion à MySQL : " . $this->_mysqli->connect_error;
		}
		
		//Fermer la connexion
		public function fermer()
		{
			$this->_mysqli->close();
		}
		
		//Faire une requete
		public function requete($query)
		{
			$res = $this->_mysqli->query($query);
			if(!$res)
				echo $this->_mysqli->error;
			else
				return $res;
		}
	
	}
	

?>