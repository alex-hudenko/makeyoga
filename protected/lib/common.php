<?php

function deadline($date) {
	$deadDate = strtotime($date);
	$remainTime = $deadDate - time();
	if ($remainTime > 0) {
	    $remainDays = round($remainTime / (60*60*24));
		if ($remainDays > 1) {
		    return $remainDays . ' days to deadline';
		} else {
			return '1 day to deadline';
		}
	} else {
		return 'Deadline';
	}
}

?>
