<?php
$database = new Database();
$db = $database->getConnection();

$img = new Images($db);

if($_FILES){

    

    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

    $images = $_FILES;

    $path = '/libs/img/content/';


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
            }
            else{
                $img->name = $name;
            }
            
            $img->upload();

            
        }
        else{
            die('Error upload file');
        }

        sleep(1);

    }

    print_r(true);

}
?>