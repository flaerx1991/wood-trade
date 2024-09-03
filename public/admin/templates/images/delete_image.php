<?php
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$img = new Images($db);


if($_POST) {
    
    $img->name = $_POST['name'];
    $id = $img->getIDByName();

    $img->name = $_POST['name'];
    $product_key = $img->getPKeysByName();

    if($product_key != NULL) {
        $product_key = explode(' ', $product_key);

        foreach($product_key as $key) {

            if($key != '') {
                $product->p_key = $key;

                $product->getByKey();

                $images = explode(' ', $product->images);

                $key = array_search($_POST['name'], $images);

                unset($images[$key]);

                $product->images = join(" ",$images);

                $product->updateImages();
            }
            
        }
    }

    $img->name = $_POST['name'];
    $img->deleteImage();

    $img->deleteMeta($id);
}
?>