<?php
$database = new Database();
$db = $database->getConnection();

$img = new Images($db);

if($_POST) {

    $img->name = $_POST['name'];
    $img->lang = $_POST['lang'];
    unset($_POST['name']);
    unset($_POST['lang']);

    $img->meta = json_encode($_POST);
    $id = $img->getIDByName();

    if($img->metaExist($id)) {
        echo "est";
        $img->img_id = $id;
        $img->updateMeta();
    }
    else {
        echo "nema";
        $img->img_id = $id;
        $img->createMeta();
    }


}
?>