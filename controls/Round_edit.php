<?php

header("HTTP/1.0 404 Not Found");
die();

include 'Libraries/Round.class.php';
include 'Libraries/Team.class.php';
include 'Libraries/Pupil.class.php';
include 'Libraries/Questions/Open.class.php';
include 'Libraries/Questions/Visual.class.php';
include 'Libraries/Questions/Test.class.php';
$formErrors=array();
$required=array('FK_mokytojas');
$maxLengths=array('raide'=>'1');
$data=array();
//$required = array('Id','Klausimas','Tsk_sk');
if (!empty($_POST['submit'])) {
    include 'utils/validator.class.php';

    $validations = array(
    'raide' => 'anything',
    'pradz' => 'date',
    'FK_mokytojas' => 'int',
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
    $data=Round::getItem($id);
    $data['moderatoriai']=Moderator::getList($id);
    $data['komandos']=ParticipatingTeams::getList($id);
    $data['klausimaiTest']=TestInRound::getList($id);
    $data['klausimaiOpen']=OpenInRound::getList($id);
    $data['klausimaiVisual']=VisualInRound::getList($id);
}
$data['editing'] = 1;
include 'templates/Round/form.tpl.php';
