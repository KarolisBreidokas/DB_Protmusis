<?php
include 'Libraries/Klases.class.php';
include 'Libraries/Team.class.php';
$formErrors=array();
$required=array('id,FK_mokytojas');
$maxLengths=array('raide'=>'1');
$data=array();
//$required = array('Id','Klausimas','Tsk_sk');
if (!empty($_POST['submit'])) {
    include 'utils/validator.class.php';

    $validations = array(
    'id' => 'int',
    'raide' => 'anything',
    'pradz' => 'date',
    'FK_mokytojas' => 'anything',
    'laida'=>'int'
  );

    $validator=new validator($validations, $required, $maxLengths);

    if ($validator->validate($_POST)) {
        $dataPrep=$validator->preparePostFieldsForSQL();
        if (Klase::update($dataPrep)!=false) {
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
    $data=Klase::getItem($id);
    $data['mokiniai']=Pupil::getClassList($id);
}
$data['editing'] = 1;
include 'templates/Klases/form.tpl.php';
