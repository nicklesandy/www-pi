<?php

mysql_query("
	
	delete from t_camera_log
	where
		date = '" . $date . "'
		and hour_lbl = ifnull(" . ($time == 'all' ? 'null' : "'".$time."'") . ", hour_lbl)
	
		
	");
	
?>