<?php

	ini_set('display_errors',1);

	include_once ROOT_PATH.'/vendor/autoload.php';

	// set page header
	$page_title="Edit data for: ".$path;

	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	$page = new Page($db);
	$page->slug = $path;
	$page->lang = $locale;
	//$meta = $page->getDefaultHead();
	//unset($meta[0]);
	//$vars = $page->getDefaultBody($path);
	$footer = $page->getDefaultFooter($path);
	// var_dump($vars);

	$data = $page->getData();
	$data = json_decode($page->data, true);
	// var_dump($page);


?>

<?php
	// if the form was submitted - PHP OOP CRUD Tutorial
	if($_POST){


		$prepare_data = $_POST;
		unset($prepare_data['lang']);
		$data = json_encode(array_filter($prepare_data), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

	    var_dump($data);

	    $page->data = $data;

	  	// var_dump($page->data);
	    // create the product

	    if($page->update()){
	        echo "<div class='alert alert-success'>Page Data updated.</div>";
	    }
	    else{
	    	echo "<div class='alert alert-danger'>Unable to update page data.</div>";
		}

	}
?>


	<!-- HTML form for creating a product -->
	<form action="<?php echo "/admin/edit-block/".$path."/".$locale;?>" method="post">

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

		<button type="submit" class="btn btn-primary">Update</button>
	</form>

<?php
	// set page footer
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";
?>
