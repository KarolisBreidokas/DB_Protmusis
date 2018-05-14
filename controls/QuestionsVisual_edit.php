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
  );
    $validator=new validator($validations, $required, $maxLengths);
    if ($validator->validate($_POST)) {
        $dataPrep=$validator->preparePostFieldsForSQL();
        if ($_FILES['medziaga']['error']==0) {

            $filename = $_FILES['medziaga']['tmp_name'];
            $handle = fopen($filename, "rb");

            switch (mime_content_type($filename)) {
          case 'image/gif':
            $dataPrep['type']=1;
            break;
          case 'image/png':
            $dataPrep['type']=2;
            break;
          case 'image/jpeg':
            $dataPrep['type']=3;
            break;
          case 'image/bmp':
            $dataPrep['type']=4;
            break;
          case 'image/webp':
            $dataPrep['type']=5;
            break;
          default:
            die();
            break;
        }

            $contents = "0x".bin2hex(fread($handle, filesize($filename)));
            $dataPrep['medziaga']=$contents;
            fclose($handle);
        }
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
