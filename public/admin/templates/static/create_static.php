<?php

	ini_set('display_errors',1);

	include_once ROOT_PATH.'/vendor/autoload.php';

	// set static header
	$page_title="Create data for: ".$path;

	$page_path = $path;

	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	$images = new Images($db);
	$img = new Images($db);

	$stmt = $images->getAllImages();

	$static = new StaticBlock($db);
	$te = new TemplateEditor($db);
	
	$vars = $te->getStaticBlockBody($path);
	if (($key = array_search('session', $vars)) !== false) {
    unset($vars[$key]);
	}
	if (($key = array_search('baselocale', $vars)) !== false) {
    unset($vars[$key]);
	}
	if (($key = array_search('path', $vars)) !== false) {
    unset($vars[$key]);
	}

?>

<?php
	// if the form was submitted - PHP OOP CRUD Tutorial
	if($_POST){


		$prepare_data = $_POST;
		unset($prepare_data['lang']);
		$data = json_encode(array_filter($prepare_data), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

	    var_dump($data);

	    $static->slug = $path;
	    $static->lang = $locale;
	    $static->data = $data;

	  	// var_dump($static->data);
	    // create the product
	    if(!$static->staticExists()){
		    if($static->create()){
		        echo "<div class='alert alert-success'>static Data created.</div>";
		    }
		    else{
	        echo "<div class='alert alert-danger'>Unable to create static data.</div>";
	    	}
	    }
	    // if unable to create the product, tell the user
	    else{
	        echo "<div class='alert alert-danger'>static data already exists.</div>";
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
	<form action="<?php echo "/admin/create-static/".$page_path ."/".$locale;?>" method="post">
		<section>
			<legend>Data</legend>
				<table class='table table-hover table-responsive table-bordered'>
					<?php foreach ($vars as $var) {
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
					}?>
				</table>
		</section>
		<button type="submit" class="btn btn-primary">Create</button>
	</form>

<?php
	// set static footer
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";
?>
