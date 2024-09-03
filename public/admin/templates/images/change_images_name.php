<?php
$database = new Database();
$db = $database->getConnection();

$img = new Images($db);

if($_POST) {

    // var_dump($_POST);
    $oldName = $_POST['oldName'];
    $name = preg_replace('/\s+/u','',$_POST['name']);

    $img->name = $name;
    if(strlen($name) == 0) return false;
    else if ($img->nameExist()){
        return false;
    }
    else {
        $img->name = $name;

        $img->changeImageName($oldName);

        print_r($name);
    }

}

?>