<?php

require '../_core/webinit.php';

switch($action->getCode()){
	
	case 'status':
		echo '<!--' . date() . '-->';
		break;
	
}

?>