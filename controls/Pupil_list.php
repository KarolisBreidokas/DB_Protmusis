<?php
include 'Libraries/Pupil.class.php';
include 'utils/paging.class.php';
$elementcnt=Klases::getCount();

$paging=new paging(config::NUMBER_OF_ROWS_IN_PAGE);
$paging->process($elementcnt,$pageId);

$data=Klases::GetList($paging->size,$paging->first);

include 'templates/Pupil/list.tpl.php';

?>
