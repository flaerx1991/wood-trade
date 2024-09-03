<?php

	ini_set('display_errors',1);

	include_once ROOT_PATH.'/vendor/autoload.php';

	// set page header
	$page_title="Создание продукта";

	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	$product = new Product($db);
    $pc = new ProductCategory($db);
	$pc->lang = BASELOCALE; 

    $all_pc = $pc->readAllByLang();

	$te = new TemplateEditor($db);
	$meta = $te->getDynamicBlock('meta');

	if (($key = array_search('session', $meta)) !== false) {
    unset($meta[$key]);
	}
	if (($key = array_search('path', $meta)) !== false) {
    unset($meta[$key]);
	}

	$vars = array(
		"name" => "Название",
		"price" => "Цена",
		"images" => "Картинка",
		"properties" => "Характристики",
		"more_info" => "Подробнее",
		"description" => "Описанине",
		"category" => "Категория"
	);

?>

<form id="productForm" method="post" enctype="multipart/form-data" onsubmit="event.preventDefault();">
	<section id="product_meta">
		<legend>Мета</legend>
			<table class='table table-hover table-responsive table-bordered'>
				<?php
					foreach ($meta as $m) {
					echo "<tr>";
					echo "<td>".$m."</td>";
					echo "<td><textarea  name='".$m."' class='form-control'></textarea></td>";
					echo "<tr>";
					}
				?>
			</table>
	</section>
	<section>
		<legend>Данные</legend>
		<table class='table table-hover table-responsive table-bordered'>

			<?php foreach ($vars as $k => $v) {

				if ($k == "category") {
					echo "<tr>";
						echo "<td>".$v."</td>";
						?>
						<td>
							<select id="micro-type-select" name="category" required>
								<option value="">виберіть категорию</option>
								<?php
									while ($row = $all_pc->fetch(PDO::FETCH_ASSOC)){
										extract($row);
	                            		echo "<option value='{$c_key}'>{$name}</option>";
									}
								?>
							</select>
						</td>
						<?php
					echo "</tr>";
				}
				elseif ($k == "price") {
					echo "<tr>";
					echo "<td>".$v."</td>";
					echo "<td><input type='text'  name='".$k."' class='form-control' value='' required></td>";
					echo "</tr>";
				}
				elseif ($k == "images") {
					echo "<tr>";
					echo "<td>".$v."</td>";
					?>
						<td id='product_dz'>
							<div class='drag-and-drop'>
								
							</div>
						</td>
					<?php
					echo "</tr>";
				}
				else {
					echo "<tr>";
					echo "<td>".$v."</td>";
					echo "<td><textarea  name='".$k."' class='form-control' required ></textarea></td>";
					echo "</tr>";
				}

			}?>
		</table>
	</section>
	<button type="submit" onclick="uploadImagesPost();" class="btn btn-primary">Створити</button>
</form>

<?php
    // set page footer
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";
?>
