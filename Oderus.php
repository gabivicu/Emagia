<?php 

	Class Oderus extends AbstractCharacter
	{
		protected $health;
		protected $strength;
		protected $defence;
		protected $speed;
		protected $luck;
		protected $name;
		public $specialAttack ;
		public $specialDefend ;
		const SPECIAL_ATTACK_CHANCE = 10;
		const SPECIAL_DEFEND_CHANCE = 20;

		
		public function __construct( )
		{
			$this->health 		= rand(70, 100);
			$this->strength 	= rand(70 , 80);
			$this->defence 		= rand(45 , 55);
			$this->speed  		= rand(40 , 50);
			$this->luck			= rand(10 , 30);
			$this->name    		 = "Orderus The Hero";
			$this->specialAttack = true;
			$this->specialDefend = true;
		}


		final protected function rapidStrike()
		{
			// Rapid strike: Strike twice while it’s his turn to attack; there’s a 10% chance he’ll use this skill every time he attacks
			return $this->strength * 2;
		}

		final protected function magicShield($damage)
		{			
			// Magic shield: Takes only half of the usual damage when an enemy attacks; there’s a 20% change he’ll use this skill every time he defends.
			return $damage / 2;
		}


        private function isSpecialAttackRound( $round )
		{	
			$isSpecialAttackRound = false;
			$chance = $this->chanceRatio( Oderus::SPECIAL_ATTACK_CHANCE );
			if ($round >= $chance) {
				$isSpecialAttackRound = ( $round % $chance == 0 )? true : false;
			}
			return $isSpecialAttackRound;
		}

		private function isSpecialDefendRound( $round )
		{
			$isSpecialDefendRound = false;
			$chance = $this->chanceRatio( Oderus::SPECIAL_DEFEND_CHANCE );
			if ($round >= $chance) {
				$isSpecialDefendRound = ( $round % $chance == 0 ) ? true : false;
			}		
			return $isSpecialDefendRound;
		}

	
		public function defend($attack, $round)
        {	
        	echo "Health of the defender before the attack is: " .  $this->health . "<br />";
        		$defence = $this->defence;
        	echo "Calculating damage..." . ($attack - $defence) . "<br />";

        	$damage = $attack - $this->defence;

        	//check is special
        	$specialRound = $this->isSpecialDefendRound($round);
        	
        	if ( $specialRound ) {
        		echo "<br /><b>SPECIAL DEFENSE WAS USED</b><br />";
        		$damage  = $this->magicShield($damage);
        	}
  			
        	echo "The damage is $damage <br/>";
        	$health = $this->health - $damage;
	       	$this->setHealth($health);
        	return $health;
        }

       public function attack($round = null)
       {
        	//check is special
        	$specialRound = $this->isSpecialAttackRound($round);
       		$strength =  $this->strength;
        	if ( $specialRound ) {
        		echo "<br/><b>SPECIAL ATTACK WAS USED</b><br />";
        		$strength = $this->rapidStrike();
        	}
  		
   			return $strength;

        }



	}
