<?php

	ini_set('display_errors',1);

	include_once ROOT_PATH.'/vendor/autoload.php';

	// set page header
	$page_title="Create data for: ".$path;

	$page_path = $path;

	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	$page = new Page($db);
	$te = new TemplateEditor($db);

	$images = new Images($db);
	$img = new Images($db);

	$stmt = $images->getAllImages();

	$meta = $te->getDynamicBlock('meta');

	$sections = $te->getSectionsPartials($path);

	if (($key = array_search('session', $meta)) !== false) {
    unset($meta[$key]);
	}
	if (($key = array_search('path', $meta)) !== false) {
    unset($meta[$key]);
	}

	$vars = $te->getDefaultBody($path);

	$partials = $te->getStaticPartials($path);

?>

<?php
	// if the form was submitted - PHP OOP CRUD Tutorial
	if($_POST){


		$prepare_data = $_POST;
		unset($prepare_data['lang']);
		$data = json_encode(array_filter($prepare_data), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

	    var_dump($data);

	    $page->slug = $path;
	    $page->lang = $locale;
	    $page->data = $data;

	    // create the product
	    if(!$page->pageExists()){
		    if($page->create()){
		        echo "<div class='alert alert-success'>Page Data created.</div>";
		    }
		    else{
	        echo "<div class='alert alert-danger'>Unable to create page data.</div>";
	    	}
	    }
	    // if unable to create the product, tell the user
	    else{
	        echo "<div class='alert alert-danger'>Page data already exists.</div>";
	    }
	}
?>
<div class="wt-admin-img-form-on-page" data-name="">
	<div class="close-buttom" onclick="closeImgFogmOnPage();"></div>
    <div class="img-grid">
        <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                echo "<div class='item' data-name='".$name."' data-path='".$path."' onclick='addImgToPageField(this)'>";
                    echo "<div class='img-item' style='background-image: url(".$path.");'></div>";
                    echo "<p class='item-text'>".$name."</p>";
                echo "</div>";
            }
        ?>
    </div>
</div>

	<!-- HTML form for creating a product -->
	<form action="<?php echo "/admin/create-page/".$page_path."/".$locale;?>" method="post">

		<section>
			<legend>Head</legend>
				<table class='table table-hover table-responsive table-bordered'>
					<?php foreach ($meta as $m) {
						echo "<tr>";
		            	echo "<td>".$m."</td>";
		            	echo "<td><textarea  name='".$m."' class='form-control' >".($data[$m] ?? null)."</textarea></td>";
		            	echo "<tr>";
					}?>
	    		</table>
		</section>

		<?php echo "<section>";
		echo "<legend>".$page_path."</legend>";
		echo "<table class='table table-hover table-responsive table-bordered'>";
		foreach ($vars as $var) {
			
				
					echo "<tr>";
						echo "<td>".$var."</td>";
						if(strpos($var, 'image_') === (int)0) {
							if(isset($data[$var])) {
								$img->name = $data[$var];
								$img->path = $img->getPathByName();
							}
							echo "<td class='wt-admin-img-input' id='image_field_$var'>
									<img class='img' src='".($img->path ?? null)."' data-name='$var'>
									<div class='buttons'>
										<p data-name='$var'>".($data[$var] ?? null)."</p>
										<input type='text' name='$var' value='".($data[$var] ?? null)."'>
										<div class='add-image-from-storage' onclick=\"selectImageForPage('$var');\">Add image from storage</div>
									</div>
								</td>";
						}
						else {
							echo "<td><textarea  name='".$var."' class='form-control' >".($data[$var] ?? null)."</textarea></td>";
						}
					echo "</tr>";
				
			
		}
		echo "</table>";
		echo "</section>";

		foreach ($sections as $section) {
			echo "<section>";
				echo "<legend>".$section."</legend>";
					echo "<table class='table table-hover table-responsive table-bordered'>";
						$vars = $te->getSectionBody($section);
						foreach ($vars as $var) {
							echo "<tr>";
			            	echo "<td>".$var."</td>";
							if(strpos($var, 'image_') === (int)0) {
								if(isset($data[$var])) {
									$img->name = $data[$var];
									$img->path = $img->getPathByName();
								}
								echo "<td class='wt-admin-img-input' id='image_field_$var'>
										<img class='img' src='".($img->path ?? null)."' data-name='$var'>
										<div class='buttons'>
											<p data-name='$var'>".($data[$var] ?? null)."</p>
											<input type='text' name='$var' value='".($data[$var] ?? null)."'>
											<div class='add-image-from-storage' onclick=\"selectImageForPage('$var');\">Add image from storage</div>
										</div>
									</td>";
							}
			            	else {
								echo "<td><textarea  name='".$var."' class='form-control' >".($data[$var] ?? null)."</textarea></td>";
							}
			            	echo "<tr>";
						}
					echo "</table>";
			echo "</section>";
		}?>
		<button type="submit" class="btn btn-primary">Create</button>

	</form>

<?php
	// set page footer
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";
?>
