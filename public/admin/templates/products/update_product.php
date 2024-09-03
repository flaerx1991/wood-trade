<?php

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$pc = new ProductCategory($db);

// echo "blya";

if($_POST){
	$product->images = $_POST['images'];
	$p_key = $path;
	$product->name = $_POST['name'];
	$product->price = preg_replace('/[^0-9]/','',$_POST['price']);
	$product->properties = $_POST['properties'];
	$product->category = $_POST['category'];

	if($product->creatable() == 'php - ебучая говнина'){

		$slugify = new \Cocur\Slugify\Slugify();

		$product->meta = $_POST['meta'];
		$product->slug = $slugify->slugify($product->name);
		$product->more_info = $_POST['more_info'];
		$product->description = $_POST['description'];
		$product->lang = $locale;
		
		if( $product->translationExists($p_key, $locale) ) {
			$id = $product->getIDbyKeyAndLang();
			// var_dump($product->getIDbyKeyAndLang());
			if($locale == BASELOCALE){
				$product->updateKey();
				$product->p_key = $product->slug;
			}
			if( $product->update($id) ) {
				var_dump($product->p_key);
				var_dump($product->images);
				$product->updateImages();
				echo "Обновлено";
			}
			else {
				echo "Не удалось обновить";
			}
		}
		else {
			$product->create();
			$product->updateImages();
			echo "Создано";
		}
	}
	else{
		echo "\nНевозможно обновить категорию.";
	}
}

?>