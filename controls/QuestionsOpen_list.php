<?php
include 'Libraries/Questions/Open.class.php';
include 'utils/paging.class.php';
$elementcnt=QuestionsOpen::getCount();

$paging=new paging(config::NUMBER_OF_ROWS_IN_PAGE);
$paging->process($elementcnt,$pageId);

$data=QuestionsOpen::GetList($paging->size,$paging->first);

include 'templates/Questions/Open/list.tpl.php';

?>
