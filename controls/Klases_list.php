<?php
include 'Libraries/Klases.class.php';
include 'utils/paging.class.php';
$elementcnt=Klase::getCount();
$paging=new paging(config::NUMBER_OF_ROWS_IN_PAGE);
$paging->process($elementcnt,$pageId);

$data=Klase::GetList($paging->size,$paging->first);

include 'templates/Klases/list.tpl.php';

?>
