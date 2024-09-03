<?php

include_once ROOT_PATH.'/vendor/autoload.php';

// set page header
$page_title="Images";

include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

$language = new Language($db);
$locales = $language->getAll();

$images = new Images($db);

$stmt = $images->getAllImages();

?>
<style>
    .col-md-12{
        float: unset;
    }
</style>
<a href="/admin/add-images" class="add-new-button">add new</a>

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
                foreach ($locales as $locale) {
                    echo "<div class='lang-button lang-button-".$locale['slug']."' onclick=\"changeFormLang('".$locale['slug']."')\">".$locale['slug']."</div>";
                }
            ?>
        </div>

        <button class="save-meta-button" onclick="setImageMeta();">Save meta</button>

        <div class="textarea-wrap">
            <p>ALT</p>
            <textarea class="textarea-alt" name="alt" id="" cols="30" rows="10"></textarea>
        </div>
        <div class="textarea-wrap">
            <p>Title</p>
            <textarea class="textarea-title" name="title" id="" cols="30" rows="10"></textarea>
        </div>
        <div class="textarea-wrap">
            <p>Description</p>
            <textarea class="textarea-description" name="description" id="" cols="30" rows="10"></textarea>
        </div>

    </div>
</div>



<div class="wt-admin-img-form">
    <div class="img-grid">
        <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                echo "<div class='item' data-name='".$name."' data-path='".$path."'>";
                    echo "<div class='edit-button' onclick=\"openImageEditForm('".$name."', '".BASELOCALE."')\"></div>";
                    echo "<div class='img-item' style='background-image: url(".$path.");'></div>";
                    echo "<p class='item-text'>".$name."</p>";
                echo "</div>";
            }
        ?>
    </div>
</div>

<?php

include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";

?>