<?php

include_once ROOT_PATH.'/vendor/autoload.php';

// set page header
$page_title="Products";

include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";


// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 500;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

// get database connection
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$language = new Language($db);
$locales = $language->getAll();

// query products
$stmt = $product->readAllFrom($from_record_num, $records_per_page);
$num = $stmt->rowCount();

echo "<div class='col-md-12'><div class='right-button-margin'>
        <a href='/admin/create-product' class='btn btn-default pull-right'>Створити</a>
    </div></div>";
// display the products if there are any
if(true)//$num>0)
{?>
<table class='table table-hover table-responsive table-bordered' id='table'>
    <thead>
        <tr>
            <th>Название продукта</th>
            <th>Цена</th>
            <th>Картинки</th>
            <th>Характеристики</th>
            <th>Подробнее</th>
            <th>Описанине</th>
            <th>Категория</th>
            <th>Действия</th>
        </tr>
    </thead>

    <tbody>
        <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                ?>
                    <tr>
                        <td><?php echo $name ?></td>
                        <td><?php echo $price ?></td>
                        <td><?php echo $images ?></td>
                        <td><?php echo $properties ?></td>
                        <td><?php echo $more_info ?></td>
                        <td><?php echo $description ?></td>
                        <td><?php echo $category ?></td>
                        <td>
                        <?php
                            foreach ($locales as $locale) {
                                echo "<a href='/admin/edit-product/".$p_key."/".$locale['slug']."' class='btn btn-info left-margin'> <span class='glyphicon glyphicon-edit'> ".$locale['name']." </span> </a>";
                            }
                        ?>
                        </td>

                    </tr>
                <?php
            }
        ?>
    </tbody>
</table>
<?php
}
// tell the user there are no products
else
{
    echo "<div class='col-md-12'><div class='alert alert-info'>Не найдено.</div></div>";
}

include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";

?>