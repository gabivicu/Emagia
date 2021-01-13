<?php 

    class AbstractCharacter
	{
		public function getProperty( $property )
        {
            if (!isset($this->$property)) {
                throw new Exception("This character has no such abilities. Check your request");
            }
           return $this->$property;
        }

		public function setHealth( $health )
		{
            $this->health = $health;
        }

        public function chanceRatio( $chance )
        {
        	$nrOfRounds  = $chance * Gameplay::MAX_ROUNDS / 100;
        	return $nrOfRounds;
        }

        public function attack($round)
        {
           	return $this->strength;
        }

        public function getDamage($attack)
        {
            $defence =$this->defence ;
             echo "Calculating damage... <br />" . ($attack - $defence) . "<br />";
        	return $attack - $this->defence;
        }
       
        public function defend( $attack, $round )   
        {	
          	//check if is the skill's round
        	echo "Health of the defender before the attack is: " .  $this->health . "<br />";
        	$damage = $this->getDamage($attack);
        	echo "The damage is $damage <br/>";
        	$health = $this->health - $damage;
	       	$this->setHealth($health);
        	return $health;
        }

	}
