<?php

	ini_set('display_errors',1);

	// core configuration
	//require ROOT_PATH.'/config/core.php';
  include_once ROOT_PATH.'/vendor/autoload.php';

	// set page header
	$page_title="Редактирование категории";

	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	$pc = new ProductCategory($db);

	$pc->c_key = $path;
	$pc->lang = $locale;

	if($pc->translationExists($path, $locale)){ $pc->getByKeyAndLang(); }

	$vars = array(
		"name" => "Назва"
	);
?>

<?php
	// if the form was submitted - PHP OOP CRUD Tutorial
	if($_POST){

		$pc->name = $_POST['name'];
		$slugify = new \Cocur\Slugify\Slugify();
		$pc->slug = $slugify->slugify($pc->name);

		if(!$pc->translationExists($path, $locale)){
			$pc->create();
			echo "<div class='col-md-12'><div class='alert alert-success'>Категория создана.</div></div>";
		}
		else{
			$id = $pc->getIDbyKeyAndLang();
			if( $locale == BASELOCALE ){
				$pc->updateKey();
				$pc->p_key = $pc->slug;
			}
			
			if( $pc->update($id) ){

				echo "<div class='col-md-12'><div class='alert alert-success'>Обновлено.</div></div>";
			}
			else{
				echo "<div class='col-md-12'><div class='alert alert-danger'>Не обновлено.</div></div>";
			}
			
			
		}

	}
?>

<!-- HTML form for creating a product -->
<form action="<?php echo "/admin/edit-product-category/".$path."/".$locale;?>" method="post">
	<section>
		<legend>Характеристики</legend>
			<table class='table table-hover table-responsive table-bordered'>
				<?php foreach ($vars as $k => $v) {
					echo "<tr>";
					echo "<td>".$v."</td>";
					echo "<td><textarea  name='".$k."' class='form-control' placeholder='".($pc->$k ?? null)."'></textarea></td>";
					echo "</tr>";
				}?>
			</table>
	</section>
	<button type="submit" class="btn btn-primary">Оновити</button>
</form>

<?php
	// set page footer
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";
?>