<?php

	$database = new Database();
	$db = $database->getConnection();

	$product = new Product($db);
  	$pc = new ProductCategory($db);

	$img = new Images($db);


if($_POST && $_FILES){

	// echo "<pre>";
	// 	// var_dump($_POST);
	// 	var_dump($_FILES);
	// echo "</pre>";

	// Slugify class initialization
	$slugify = new \Cocur\Slugify\Slugify();

	// fill all text fields needed for exist check
	$product->name = $_POST['name'];
	$product->slug = $slugify->slugify($_POST['name']);
	$product->p_key = $slugify->slugify($_POST['name']);
	$product->lang = BASELOCALE;

	// exist check
	if(!($product->productExists())){

		// second text fiealds
		$product->meta = $_POST['meta'];
		$product->properties = $_POST['properties'];
		$product->more_info = $_POST['more_info'];
		$product->description = $_POST['description'];
		$product->category = $_POST['category'];
		$product->price = preg_replace('/[^0-9]/','',$_POST['price']);

		if($product->creatable() == 'php - ебучая говнина'){
			$product->create();

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
						$response[$img->name] = $img->path;
					}
					else{
						$img->name = $name;
						$response[$img->name] = $img->path;
					}
					$product->addImagesToProducts($product->p_key, $img->name);
		
					$img->upload();

					$img->addProductIDToImage($product->p_key, $img->name);
				}
				else{
					die('Error upload file');
				}

				sleep(1);

			}

			print_r(true);

		}
		else{
			echo "can`t create!";
		}
	}
	else{
		echo "already exist";
	}
}
else{
	echo "не всі поля заповнені";
}
?>