<?php

include 'Libraries/Klases.class.php';

var_dump($id);
if(!empty($id)) {
	$count = Klase::checkDependant($id);

	var_dump(mysql::error());
	var_dump($count);
	$removeErrorParameter = '';
	if($count == 0) {
		Klase::delete($id);
	} else {
		$removeErrorParameter = '&remove_error=1';
	}

		var_dump($removeErrorParameter);
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>
