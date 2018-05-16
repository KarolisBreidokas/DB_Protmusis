<?php
include 'Libraries/Round.class.php';
include 'utils/paging.class.php';
$elementcnt=Round::getCount();
$paging=new paging(config::NUMBER_OF_ROWS_IN_PAGE);
$paging->process($elementcnt,$pageId);

$data=Round::GetList($paging->size,$paging->first);

include 'templates/Round/list.tpl.php';

?>
