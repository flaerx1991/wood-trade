<?php

	ini_set('display_errors',1);

	include_once ROOT_PATH.'/vendor/autoload.php';

	// set page header
	$page_title="Редактирование продукта";

	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	$product = new Product($db);

	$img = new Images($db);

	$translationExist = $product->translationExists($path, $locale);

	if(!$translationExist){
		$product->getByKeyAndLang($path, BASELOCALE);
	}
	else{
		$product->getByKeyAndLang($path, $locale);
	}

	$product_meta = json_decode($product->meta, true);

    $pc = new ProductCategory($db);
	$pc->lang = $locale;

    $all_pc = $pc->readAllByLang();

	$vars = array(
		"name" => "Название",
		"price" => "Цена",
		"images" => "Картинка",
		"properties" => "Характристики",
		"more_info" => "Подробнее",
		"description" => "Описанине",
		"category" => "Категория"
	);

	$te = new TemplateEditor($db);
	$meta = $te->getDynamicBlock('meta');

	if (($key = array_search('session', $meta)) !== false) {
    unset($meta[$key]);
	}
	if (($key = array_search('path', $meta)) !== false) {
    unset($meta[$key]);
	}

	$p_key = $path;
?>
<!-- form for image meta -->
<div class="wt-admin-form-wrap">
    <div class="form-wrap">
        <div class="close-button" onclick="closeImageEditForm()"></div>
        <input class="form-input-image-name" type="text" placeholder="" oninput="this.value=inputSpaceLess(this.value);">

        <div class="change-delete-buttons">
            <button class="change-button" onclick="changeImageName();">change name</button>
            <button class="delete-button" onclick="deleteImage();">delete image</button>
        </div>
        
        <div class="lang-buttons" data-lang="">
            <?php
                // foreach ($locales as $locale) {
                    echo "<div class='lang-button lang-button-".$locale."' onclick=\"changeFormLang('".$locale."')\">".$locale."</div>";
                // }
            ?>
        </div>

        <button class="save-meta-button" onclick="setImageMeta();">Save meta</button>

        <div class="textarea-wrap">
            <p>ALT</p>
            <textarea class="textarea-alt" id="" cols="30" rows="10"></textarea>
        </div>
        <div class="textarea-wrap">
            <p>Title</p>
            <textarea class="textarea-title" id="" cols="30" rows="10"></textarea>
        </div>
        <div class="textarea-wrap">
            <p>Description</p>
            <textarea class="textarea-description" id="" cols="30" rows="10"></textarea>
        </div>

    </div>
</div>

<div class="wt-admin-product-dragndrop-wrap">
	<div class="dragndrop-wrap">
		<div class="close-dragndrop-wrap" onclick="closeImageAddingDropzone()"></div>

		<div class="images-message-block">
			<div class="message">Загружени все изображения</div>
		</div>

		<div id='product_dz'>
			<div class='drag-and-drop'>
				
			</div>
		</div>

		<button onclick="uploadImagesOnProduct('<?php echo $path ?>', '<?php echo $locale ?>');">Add</button>
	</div>
    
</div>

<form method="post" enctype="multipart/form-data" onsubmit="event.preventDefault();">
		<section id="product_meta">
					<legend>Мета</legend>
						<table class='table table-hover table-responsive table-bordered'>
							<?php
								foreach ($meta as $m) {
								echo "<tr>";
								echo "<td>".$m."</td>";
								echo "<td><textarea  name='".$m."' class='form-control' >".($product_meta[$m] ?? null)."</textarea></td>";
								echo "<tr>";
								}
							?>
						</table>
				</section>
			<section>
		<section>
		<legend>Данные</legend>

			<table class='table table-hover table-responsive table-bordered'>
				<?php foreach ($vars as $k => $v) {
					if ($k == "category") {
                        echo "<tr>";
                        echo "<td>".$v."</td>";
                        ?>
                        <td>
                            <select id="micro-type-select" name="categorySelect" required>
							<option value="">виберіть категорию</option>
                                <?php
	                            	while ($row = $all_pc->fetch(PDO::FETCH_ASSOC)){
	                            		extract($row);
										if($product->category == $c_key) echo "<option selected value='{$c_key}'>{$name}</option>";
	                            		else echo "<option value='{$c_key}'>{$name}</option>";
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
                        echo "<td><input type='text'  name='".$k."' class='form-control' value='". $product->price ."' required></td>";
                        echo "</tr>";
					}
					elseif ($k == "images") {
						echo "<tr>";
                        echo "<td>".$v."</td>";
						?>
							<td id='product_dz' class="wt-admin-product-image-form">
								<div class="image-actions-grid">
									<button class="add-new-image" onclick="openImageAddingDropzone()">Add new image</button>
									<button class="add-image-from-storage">Add image from storage</button>
								</div>

								<div class="wt-admin-img-form" data-lang="<?php echo $locale ?>">
									<div class="img-grid">
										<?php
											$image_item = explode(" ", $product->images);

											for($key = 0; $key < count($image_item)-1; $key++){
												$image = $img->getImageByName($image_item[$key]);
												
												$row = $image->fetch(PDO::FETCH_ASSOC);
												extract($row);
												echo "<div class='item' data-name='".$name."' data-path='".$path."'>";
													echo "<div class='edit-button' onclick=\"openImageEditForm('".$name."', '".$locale."')\"></div>";
													echo "<div class='delete-item' onclick=\"deleteImageItem('".$name."')\"></div>";
													echo "<div class='move-buttons'>
														 	<div class='move-buttons-left' onclick=\"moveItemLeftRight('left', '".$name."')\"></div>
															<div class='move-buttons-right' onclick=\"moveItemLeftRight('right', '".$name."')\"></div>
														</div>";
													echo "<div class='img-item' style='background-image: url(".$path.");'></div>";
													echo "<p class='item-text'>".$name."</p>";
												echo "</div>";
											}
										?>
									</div>
								</div>
							</td>
                        <?php
						echo "</tr>";
					}
                    else {
                        echo "<tr>";
                        echo "<td>".$v."</td>";
						if($translationExist){ echo "<td><textarea  name='".$k."' class='form-control' required>". $product->$k ."</textarea></td>"; }
                        else{ echo "<td><textarea  name='".$k."' class='form-control' required></textarea></td>"; }
                        echo "</tr>";
                    }

				}?>
			</table>
	</section>
	<button onclick="updateImagesPost('<?php echo $p_key ?>', '<?php echo $locale ?>')"; class="btn btn-primary">Обновить</button>
</form>

<?php
    // set page footer
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";
?>
