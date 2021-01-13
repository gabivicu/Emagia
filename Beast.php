<?php

	Class Beast extends AbstractCharacter
	{
		protected $health;
		protected $strength;
		protected $defence;
		protected $speed;
		protected $luck;
		protected $name;
		
		public function __construct()
		{
			$this->health 		= rand(60, 90);
			$this->specialAttack 	= false;
			$this->sepcialDefend 	= false;
			$this->strength 	= rand(60, 90);
			$this->defence		= rand(40, 60);
			$this->speed		= rand(40, 60);
			$this->luck			= rand(25, 40);
			$this->name			= "The Beast";
		}

}
