<?php
include 'Libraries/Questions/Visual.class.php';
$formErrors=array();
$required=array('id');
$maxLengths=array();
$data=array();
//$required = array('Id','Klausimas','Tsk_sk');
if (!empty($_POST['submit'])) {
    include 'utils/validator.class.php';

    $validations = array(
    'id' => 'int',
    'klausimas' => 'anything',
    'atsakymas' => 'anything',
    'tsk_sk' => 'int',
    'saltinis' => 'anything',
    'type'=>'int'

  );
    $validator=new validator($validations, $required, $maxLengths);
    if ($validator->validate($_POST)) {
        $dataPrep=$validator->preparePostFieldsForSQL();


        if (QuestionsVisual::update($dataPrep)!=false) {
            header("Location: index.php?module={$module}&action=list");
            die();
        } else {
            echo mysql::error();
            die();
        }
    } else {
        $formError=$validator->getErrorHTML();
        $data=$_POST;
    }
} else {
    $data=QuestionsVisual::getItem($id);
}
$data['editing'] = 1;
include 'templates/Questions/Visual/form.tpl.php';
