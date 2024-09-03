<?php

include_once ROOT_PATH.'/vendor/autoload.php';

// set page header
$page_title="Add images";

include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

?>
<style>
    .col-md-12{
        float: unset;
    }
</style>

    <div class="images-message-block">
        <div class="message">Загружени все изображения</div>
    </div>

    <div id='product_dz'>
        <div class='drag-and-drop'>
            
        </div>
    </div>

    <button onclick="uploadImages();">Add</button>

<?php

include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";

?>