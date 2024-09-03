<?php
    $database = new Database();
    $db = $database->getConnection();
    
    $img = new Images($db);

    if($_POST) {
        $img->name = $_POST['name'];
        $img->lang = $_POST['lang'];

        $id = $img->getIDByName();


        if($img->metaExist($id)) {
            $img->img_id = $id;
            $meta = $img->getMetaByIDAndLang();
            print_r($meta);
        }
        else{
            return false;
        }
    }
?>