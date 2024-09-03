<?php
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$img = new Images($db);

if($_FILES){

    

    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

    $images = $_FILES;

    $path = '/libs/img/content/';

    $response = [];

    $p_key = $_POST['p_key'];


    foreach ($images as $image) {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $extension = pathinfo($image["name"], PATHINFO_EXTENSION);

        
        $fileName = time() . ".$extension";

        preg_match('/^([^.]+)/', $image["name"], $name, PREG_OFFSET_CAPTURE);
        $name = $name[0][0];
        $slugify = new \Cocur\Slugify\Slugify();
        $name = $slugify->slugify($name);
        $img->name = $name;
        $img->path = $path . $fileName;

        if (move_uploaded_file($image["tmp_name"], '.' . $path . $fileName)) {
            $num = $img->sameNameCount();

            if($num > 0) {
                $img->name = $name . "(" . $num . ")";
                $response[$img->name] = $img->path;
            }
            else{
                $img->name = $name;
                $response[$img->name] = $img->path;
            }
            $product->addImagesToProducts($p_key, $img->name);

            $img->upload();

            $img->addProductIDToImage($p_key, $img->name);
        }
        else{
            die('Error upload file');
        }

        sleep(1);

    }

    $response = json_encode($response);

    print_r($response);

}

?>