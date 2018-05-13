<?php
include 'Libraries/Questions/Test.class.php';
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
    'tsk_sk' => 'int',
    'saltinis' => 'anything',

  );
  //var_dump($_POST);

    $validator=new validator($validations, $required, $maxLengths);
    if ($validator->validate($_POST)) {
        $dataPrep=$validator->preparePostFieldsForSQL();
        if (QuestionsTest::update($dataPrep)!=false) {
            header("Location: index.php?module={$module}&action=list");
            die();
        } else {
            echo mysql::error();
            die();
        }
    } else {
        $formError=$validator->getErrorHTML();
        $data=$_POST;
    }//*/
} else {
    $data=QuestionsTest::getItem($id);
    $data['atsakymai']=TestAnswers::GetList($id);
}
$data['editing'] = 1;
include 'templates/Questions/Test/form.tpl.php';
