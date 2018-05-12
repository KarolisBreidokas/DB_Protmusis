<?php
include 'Libraries/Questions/Open.class.php';
$formErrors=array();
$required=array('id');
$maxLengths=array();
$data=array();
if(!empty($_POST['submit'])){
  include 'utils/validator.class.php';

	$validations = array (
    'id' => 'int',
    'klausimas' => 'anything',
    'atsakymas' => 'anything',
    'tsk_sk' => 'int',
    'saltinis' => 'anything',

  );
  $validator=new validator($validations,$required,$maxLengths);
  if($validator->validate($_POST)){
    $dataPrep=$validator->preparePostFieldsForSQL();

	if(!QuestionsOpen::insert($dataPrep)){
	    header("Location: index.php?module={$module}&action=list");
	    die();
	}else{
		echo mysql::error();
		die();
	}
  }else{
    $formError=$validator->getErrorHTML();
    $data=$_POST;
  }
}else{
}
include 'templates/Questions/Open/form.tpl.php';

?>
