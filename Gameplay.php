<?php

	class Gameplay
	{
			
		const MAX_ROUNDS = 20;
		private static $round ;
		private $nrOfPlayers ;
		private $players;
		private $attacker; // int is just the index of the attacker  is not an object
		private $defender; // int is just the index of the defender is not an object
		private static $gameStatus ;
		
        public function __construct( $players = null )
		{
		    self::$gameStatus = 1;
            self::$round  = 1;
             //count  and set the players
			$this->players = func_get_args();
			$this->nrOfPlayers = func_num_args();

            //check if is a valid character object
			$isCharacter = $this->isCharacter( $this->players );

			if ( $isCharacter ) {
			    $this->play();
			}

		}
        
        //get the round 
        public static function getRound()
        {
            return Gameplay::$round;
        }

        private function setFirstPlayerIndex($property, $value)
        {
            $players = $this->players;
            $nrOfPlayers = $this->nrOfPlayers;
            for ($i=0; $i < $nrOfPlayers; $i++ ) {
              $propertyValue =  $players[$i]->getProperty($property);
              if ($propertyValue === $value) {
                  $firstPlayerIndex = $i;
              }
            }
            return $firstPlayerIndex;
        }

        private function isMoreThanOnce($property, $valueToCheck)
        {
           $count = 0;
           $players = $this->players;
           foreach ($players as $player) {
                if ($player->getProperty($property) == $valueToCheck) {
                   $count++;
                }

                if ($count > 1) {
                    return true;
                }
            }
            return false;
         }

        //get tha highest value of the property 
		private function getMaxProperty( $property ){
            $players = $this->players;
            $max = 0;
		    foreach ($players as $player) {
		        $value = $player->getProperty($property);
		        $max = ($max < $value) ? $value : $max;
            }
            return $max;
        }


		private function isCharacter($players)
		{
			foreach ($players as $player) {
				try {
					$isCharacter = is_subclass_of( $player , 'AbstractCharacter' );
					if ($isCharacter === false) {
						throw new Exception( ' Invalid player exception - please check your players ');
					}				
				} catch (Exception $e) {
					echo  'Exception caught' .  $e->getMessage( ) ;
					return false;
				}
			}			
			return true;
		}


		public function play()
		{	
			do {
                $roundNr = self::$round;
                echo "<br />Round $roundNr  <br />";

			    //count players
                $nrOfPlayers = count($this->players);
                echo '<pre>';
                print_r($this->players);
                echo '</pre>';
           
               if ( $nrOfPlayers > 1 ) {
                    if (self::$round == 20) {
                        echo "We have a draw. Waiting for the next battle.";
                        die();
                    }

                    //setPlayers
                    $this->setPlayers();
                    $attackerIndex  = $this->getAttacker();
                    $attacker       = $this->players[$attackerIndex];
                    echo "Attacker index is $attackerIndex <br />";

                    //getDefenderIndex
                    $defenderIndex  = $this->getDefender();
                    $defender       = $this->players[$defenderIndex];
                    echo "Defender index is $defenderIndex <br />";

                    //attack
                    $attackerStrength = $attacker->attack( self::$round );

                    //defend
                    $healthLeft = $defender->defend( $attackerStrength, self::$round );

                    echo " Health of the defender after attack is:  $healthLeft <br />";

                     //kill player or move to next battle
                    if ($healthLeft <= 0 ) {                       
                       //removePlayer
                       $this->removePlayer($defenderIndex);
                    }

                } else {
                    echo "Strange things happened in the black wood's. A sorcerer used black magic ";
                    die();
                }

                //increment round
                self::$round++;
                //check and change the status of the game
                $this->setGameStatus();

			} while ( self::$gameStatus == 1  );

            //show the winner
            echo "<br />THE WINNER IS: <br />";
            echo '<pre>';
            print_r($this->players);
            echo '</pre>';
		}

        private function setGameStatus()
        {
            if ( (self::$round == self::MAX_ROUNDS ) || ($this->nrOfPlayers == 1)){
                self::$gameStatus = 0;
            }

        }
        
        private function removePlayer( $playerIndex)
        {
           echo "This player is dead";
           $players = $this->players;
           unset($players[$playerIndex]);
           $newPlayers = array_values( $players);
           $this->players = $newPlayers;
           $this->nrOfPlayers = count($this->players);
        }

        private function setPlayers()
        {
            /*very important to mantain the order we set first the attacker and only after
             that the defender because they are dependent - N multiplayer's issue
             */
            $this->setAttacker();
            $this->setDefender();
        }

		private function setAttacker( )
		{

            if (self::$round == 1) {

                $this->attacker = $this->getFirstStrikePlayerIndex();

            } else {
                
                $attacker = $this->defender;

                if ($attacker >= $this->nrOfPlayers)
                {
                    $attacker = 0;
                }
                
                $this->attacker = $attacker;
            }
        }
        
         //get the index for the player that makes the first strike
        private function getFirstStrikePlayerIndex(){
            $maxSpeed = $this->getMaxProperty( "speed" );

            //check if both players have the same maxim speed
            $multiplePlayersWithSameSpeed = $this->isMoreThanOnce( "speed", $maxSpeed );

            //if both players have the same maximum speed set the player with maxim luck
            if ( $multiplePlayersWithSameSpeed == true  ) {
                //get the maxim luck value
                $maxLuck = $this->getMaxProperty( "luck" );
                //set the index for the first player with maxim luck
                $firstPlayerIndex = $this->setFirstPlayerIndex("luck", $maxLuck);
                echo "Player with the maxim luck of $maxLuck hit first";
       
            //set the index for the player with maxim speed
            } else {

                $firstPlayerIndex = $this->setFirstPlayerIndex("speed", $maxSpeed);
                echo "Player with the maxim speed of $maxSpeed hit first";
            }
            echo "<br />First Player Index is:" . $firstPlayerIndex ." <br />" ;

            return $firstPlayerIndex;
        }

        private function setDefender()
        {

            $defender = $this->attacker + 1 ;

            if ($defender >= $this->nrOfPlayers) {
                $defender = 0;
            }
            
            $this->defender = $defender;
        }

		private function getAttacker()
		{
			return $this->attacker;
		}

        private function getDefender()
        {
            return $this->defender ;
        }

	}