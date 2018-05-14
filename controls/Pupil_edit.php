<?php
include 'Libraries/Pupil.class.php';
include 'Libraries/Klases.class.php';
include 'Libraries/Team.class.php';
$formErrors=array();
$required=array('id','FK_klase');
$maxLengths=array();
$data=array();
if (!empty($_POST['submit'])) {
    include 'utils/validator.class.php';
    $validations = array(
    'id' => 'int',
    'vardas' => 'anything',
    'pavarde' => 'anything',
    'FK_klase' => 'int',
    'FK_komanda' => 'anything',
  );

    $validator=new validator($validations, $required, $maxLengths);

    if ($validator->validate($_POST)) {
        $dataPrep=$validator->preparePostFieldsForSQL();
        if (Pupil::update($dataPrep)!=false) {
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
    $data=Pupil::getItem($id);
}
$data['editing'] = 1;
include 'templates/Pupil/form.tpl.php';
