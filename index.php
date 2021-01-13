<?php
spl_autoload_register('autoLoad');

function autoLoad($classname) {
	require_once $classname . '.php';
}
?>


<?php 
		$oderus = new Oderus;
		$beast	= new Beast;
		$game   = new Gameplay( $beast, $oderus );	
?>