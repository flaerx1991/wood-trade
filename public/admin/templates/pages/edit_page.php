<?php

	ini_set('display_errors',1);

	// core configuration
	//require ROOT_PATH.'/config/core.php';
  	include_once ROOT_PATH.'/vendor/autoload.php';

	// set page header
	$page_title="Edit data for: ".$path;

	$page_path = $path;

	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	$page = new Page($db);
	$te = new TemplateEditor($db);
	$page->slug = $path;
	$page->lang = $locale;

	$meta = $te->getDynamicBlock('meta');

	$sections = $te->getSectionsPartials($path);

	$images = new Images($db);
	$img = new Images($db);

	$stmt = $images->getAllImages();

	if (($key = array_search('session', $meta)) !== false) {
    unset($meta[$key]);
	}
	if (($key = array_search('path', $meta)) !== false) {
    unset($meta[$key]);
	}

	$vars = $te->getDefaultBody($path);
	//$footer = $page->getDefaultFooter($path);
	// var_dump($vars);

	$data = $page->getData();
	$data = json_decode($page->data, true);
	// var_dump($page);


?>

<?php
	// if the form was submitted - PHP OOP CRUD Tutorial
	if($_FILES) {

		var_dump($_FILES);

	}

	if($_POST){


		$prepare_data = $_POST;
		unset($prepare_data['lang']);
		$data = json_encode(array_filter($prepare_data), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

	    var_dump($data);

	    $page->data = $data;

	    if($page->update()){
	        echo "<div class='alert alert-success'>Page Data updated.</div>";
	    }
	    else{
	    	echo "<div class='alert alert-danger'>Unable to update page data.</div>";
		}

	}
?>

<div class="wt-admin-img-form-on-page" data-name="">
	<div class="close-buttom" onclick="closeImgFogmOnPage();"></div>
    <div class="img-grid">
        <?php
		$i = 1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                echo "<div class='item' data-name='".$name."' data-path='".$path."' onclick='addImgToPageField(this)'>";
                    echo "<div class='img-item' style='background-image: url(".$path.");'></div>";
                    echo "<p class='item-text'>".$name."</p>";
                echo "</div>";
				$i += 1;
            }
        ?>
    </div>
</div>

	<!-- HTML form for creating a product -->
	<form action="<?php echo "/admin/edit-page/".$page_path."/".$locale;?>" method="post">
		<section>
			<legend>Meta</legend>
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
			            	echo "</tr>";
							
						}
						
					echo "</table>";
			echo "</section>";
		}?>

		<button type="submit" class="btn btn-primary">Update</button>
	</form>

<?php
	// set page footer
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";
?>
