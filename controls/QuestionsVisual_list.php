<?php
include 'Libraries/Questions/Visual.class.php';
include 'utils/paging.class.php';
$elementcnt=QuestionsVisual::getCount();
echo mysql::error();
$paging=new paging(config::NUMBER_OF_ROWS_IN_PAGE);
$paging->process($elementcnt,$pageId);

$data=QuestionsVisual::GetList($paging->size,$paging->first);

include 'templates/Questions/Visual/list.tpl.php';

?>
