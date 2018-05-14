<?php

include 'Libraries/Pupil.class.php';
if(!empty($id)) {
	$count = Pupil::checkDependant($id);
	$removeErrorParameter = '';
	if($count == 0) {
		Pupil::delete($id);
	} else {
		$removeErrorParameter = '&remove_error=1';
	}
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>
