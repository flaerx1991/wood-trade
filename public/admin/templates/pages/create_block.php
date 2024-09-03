<?php

	ini_set('display_errors',1);

	include_once ROOT_PATH.'/vendor/autoload.php';

	// set page header
	$page_title="Create data for: ".$path;

	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	$page = new Page($db);
	//$meta = $page->getDefaultHead();
	//unset($meta[0]);
	//$vars = $page->getDefaultBody($path);
	$footer = $page->getDefaultFooter($path);
	// var_dump($vars);

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

	  	// var_dump($page->data);
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


	<!-- HTML form for creating a product -->
	<form action="<?php echo "/admin/create-block/".$path."/".$locale;?>" method="post">
		<section>
			<legend>Footer</legend>
				<table class='table table-hover table-responsive table-bordered'>
					<?php foreach ($footer as $f) {
						echo "<tr>";
		            	echo "<td>".$f."</td>";
		            	echo "<td><textarea  name='".$f."' class='form-control' >".($data[$f] ?? null)."</textarea></td>";
		            	echo "<tr>";
					}?>
				</table>
		</section>
		<button type="submit" class="btn btn-primary">Create</button>
	</form>

<?php
	// set page footer
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";
?>
