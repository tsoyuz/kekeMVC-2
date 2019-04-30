<?php

	require_once "../private_html/BDD.php";

	class Modele
	{
		//BDD
		private $_bdd;
		
		//Constructeur
		public function __construct()
		{
			$this->_bdd = new BDD();
		}
		
		//Action a réaliser si le controlleur charge ce modele
		public function ctrlLoad() {}
		
		//Action lié à la BDD
		public function bddTable() {}
		public function bddInsert() {}
		public function bddDelete() {}
		public function bddSelect() {}
		public function bddUpdate($key) {}		

		//Get Database
		public function getBDD()
		{
			return $this->_bdd;
		}
		
		//

	}

?>
