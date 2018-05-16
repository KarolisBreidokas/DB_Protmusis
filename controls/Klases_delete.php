<?php

include 'Libraries/Klases.class.php';
var_dump($id);
var_dump(empty($id));
if(!empty($id)) {
	$count = Klase::checkDependant($id);
	$removeErrorParameter = '';
	if($count == 0) {
		Klase::delete($id);
	} else {
		$removeErrorParameter = '&remove_error=1';
	}//*/
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>
