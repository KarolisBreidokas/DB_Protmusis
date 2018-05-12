<?php

include 'Libraries/Questions/Open.class.php';

if(!empty($id)) {
	$count = QuestionsOpen::checkDependant($id);

	$removeErrorParameter = '';
	if($count == 0) {
		QuestionsOpen::delete($id);
	} else {
		$removeErrorParameter = '&remove_error=1';
	}
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>
