<?php

	ini_set('display_errors',1);

	include_once ROOT_PATH.'/vendor/autoload.php';

	// set page header
	$page_title="Создать категорию товара";

	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	$pc = new ProductCategory($db);

	$vars = array(
		"name" => "Назва",
	);


?>

<?php
	// if the form was submitted - PHP OOP CRUD Tutorial
	if($_POST){

		$pc->name = $_POST['name'];
		$slugify = new \Cocur\Slugify\Slugify();
		$pc->slug = $slugify->slugify($pc->name);
		$pc->c_key = $pc->slug;
		$pc->lang = BASELOCALE;

        //var_dump($pc);

		if(strlen(preg_replace('/\s+/u','',$_POST['name'])) == 0) { echo "<div class='col-md-12'><div class='alert alert-danger'>Имя не заполнено</div></div>"; }
		else {
			if(!$pc->productCategoryExists()){
				if($pc->create()){
					echo "<div class='col-md-12'><div class='alert alert-success'>Категория создана.</div></div>";
				}
				else{
					echo "<div class='col-md-12'><div class='alert alert-danger'>Невозможно создать категорию.</div></div>";
				}
			}
			// if unable to create the product, tell the user
			else{
					echo "<div class='col-md-12'><div class='alert alert-danger'>Такая категория уже существует</div></div>";
			}
		}
			

	}
?>


	<!-- HTML form for creating a product -->
	<form action="<?php echo "/admin/create-product-category";?>" method="post">
		<section>
			<legend>Характеристики</legend>
				<table class='table table-hover table-responsive table-bordered'>
					<?php foreach ($vars as $k => $v) {
						echo "<tr>";
		            		echo "<td>".$v."</td>";
		            		echo "<td><textarea  name='".$k."' class='form-control' >".($data[$k] ?? null)."</textarea></td>";
		            	echo "</tr>";
					}?>
				</table>
		</section>
		<button type="submit" class="btn btn-primary">Создать</button>
	</form>

<?php
	// set page footer
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";
?>
