<?php
include 'Libraries/Questions/Open.class.php';
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

  );
    $validator=new validator($validations, $required, $maxLengths);
    if ($validator->validate($_POST)) {
        $dataPrep=$validator->preparePostFieldsForSQL();

        

        if (QuestionsOpen::update($dataPrep)!=false) {
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
    $data=QuestionsOpen::getItem($id);
}
$data['editing'] = 1;
include 'templates/Questions/Open/form.tpl.php';
