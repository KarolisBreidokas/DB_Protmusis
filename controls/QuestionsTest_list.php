<?php
include 'Libraries/Questions/Test.class.php';
include 'utils/paging.class.php';
$elementcnt=QuestionsTest::getCount();

$paging=new paging(config::NUMBER_OF_ROWS_IN_PAGE);
$paging->process($elementcnt,$pageId);

$data=QuestionsTest::GetList($paging->size,$paging->first);

include 'templates/Questions/Test/list.tpl.php';

?>
