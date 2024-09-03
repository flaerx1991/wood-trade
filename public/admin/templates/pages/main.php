<?php

	include_once ROOT_PATH.'/vendor/autoload.php';

	// set page header
	$page_title="Pages";

	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	$page = new Page($db);
	$language = new Language($db);

	$directory = $path ? 'templates/'.$path : 'templates';
	if( !is_dir($directory) ) {
		header('HTTP/1.0 404 Not Found');
	  	echo 'Error 404 :-(<br>';
	  	echo 'The requested path "'.$path.'" was not found!';
	}
	else $files =  $page->getAll($directory);
	//var_dump($files);
	if (!empty($files)) {
		echo "<legend>Templates</legend>";
		echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Type</th>";
            echo "<th>Actions</th>";
        echo "</tr>";

        foreach($files as $file){


            echo "<tr>";
                echo "<td>$file</td>";
                if( is_file($directory."/".$file) ) echo "<td>File</td>";
                if( is_dir($directory."/".$file) ) echo "<td>Dir</td>";

                echo "<td>";
               //      if( is_file($directory."/".$file) ) echo "<a href='update_product.php?id={$id}' class='btn btn-info left-margin'>
															//     <span class='glyphicon glyphicon-edit'></span> Edit
															// </a>";
                	$url = $path ? $path."/".$file : $file;
                	$filename = preg_split("/\./", $file);
                	$filepath = $path ? $path."/".$filename[0] : $filename[0];
                	$locales = $language->getAll();

					if( is_dir($directory."/".$file) ) echo "<a href='/admin/pages/".$url."' class='btn btn-info left-margin'>
															    <span class='glyphicon glyphicon-folder-open'></span>
															</a>";
					if( is_file($directory."/".$file) ) {

						$page->slug = $filepath;
						foreach ($locales as $locale) {
	                		if( !$page->translationExists($locale['slug']) )	echo "<a href='/admin/create-page/".$filepath."/".$locale['slug']."' class='btn btn-info left-margin'>
							    								<span class='glyphicon glyphicon-edit'> ".$locale['name']." </span>
															</a>";
							else echo "<a href='/admin/edit-page/".$filepath."/".$locale['slug']."' class='btn btn-info left-margin'>
			    							<span class='glyphicon glyphicon-edit'> ".$locale['name']." </span>
										</a>";
                		}


					}
                echo "</td>";

            echo "</tr>";

        }
		echo "</table>";
		
	}

	// set page footer
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";
?>