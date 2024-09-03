<?php

    include_once ROOT_PATH.'/vendor/autoload.php';

    // set page header
    $page_title="Product Categories";

    // page given in URL parameter, default page is one
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // set number of records per page
    $records_per_page = 500;

    // calculate for the query LIMIT clause
    $from_record_num = ($records_per_page * $page) - $records_per_page;

    // retrieve records here
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

    $database = new Database();
	$db = $database->getConnection();
    $pc = new ProductCategory($db);

	$language = new Language($db);
	$locales = $language->getAll();


    // query products
	$stmt = $pc->readAllFrom($from_record_num, $records_per_page);
    $num = $stmt->rowCount();

	echo "<div class='col-md-12'><div class='right-button-margin'>
            <a href='/admin/create-product-category' class='btn btn-default pull-right'>Створити</a>
        </div></div>";


    if($num>0){
	    echo "<table class='table table-hover table-responsive table-bordered' id='table'>";
					echo "<thead>";
		        echo "<tr>";
		            echo "<th>Назва</th>";
		            echo "<th>Дії</th>";
		        echo "</tr>";
					echo "</thead>";

					echo "<tbody>";
	                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        
	                        extract($row);
                        
	                        echo "<tr>";
	                            echo "<td>{$name}</td>";
								
	                            echo "<td>";
									foreach ($locales as $locale) {
										echo "<a href='/admin/edit-product-category/{$c_key}/{$locale['slug']}' class='btn btn-info left-margin'> <span class='glyphicon glyphicon-edit'> ".$locale['name']." </span> </a>";
									}
	                            echo "</td>";
                        
	                        echo "</tr>";
                        
	                    }
			        echo "</tbody>";
	    echo "</table>";
    // paging buttons will be here
	}
	// tell the user there are no products
	else{
		echo "<div class='col-md-12'><div class='alert alert-info'>Не знайдено.</div></div>";
	}

    // set page footer
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";

?>