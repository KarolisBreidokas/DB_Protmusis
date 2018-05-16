<?php

include 'Libraries/Questions/Test.class.php';

if(!empty($id)) {
	$count = QuestionsTest::checkDependant($id);

	$removeErrorParameter = '';
	if($count == 0) {
		QuestionsTest::delete($id);
	} else {
		$removeErrorParameter = '&remove_error=1';
	}
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>
