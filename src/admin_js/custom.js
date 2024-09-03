////// scrip for Dropzone
let dragAndDrop = document.querySelector('.drag-and-drop');
let uploadsImages = [];
const fileTypes = ['image/png', 'image/jpeg', 'image/svg', 'image/svg+xml', 'image/webp'];

// prevent default actions
dragAndDrop.addEventListener('dragenter', (e) => {
    e.preventDefault();
});
dragAndDrop.addEventListener('dragleave', (e) => {
    e.preventDefault();
});
dragAndDrop.addEventListener('dragover', (e) => {
    e.preventDefault();
});

// add images to drop zone
dragAndDrop.addEventListener('drop', (e) => {
    e.preventDefault();
    let inputFiles = $('#inputImg');
    const files = e.dataTransfer.files;
    dragAndDrop.classList.add('drag-and-drop-active');
    // console.log(files);
    
    for(let i = 0; i < files.length; i++) {
        if(fileTypes.includes(files[i].type)){
            alreadyIn = false;
            for(let test = 0; test < uploadsImages.length; test++){
                if(uploadsImages[test].name == files[i].name){
                    alreadyIn = true;
                }
            }
            if(alreadyIn){
                alert(`Файл с таким же именем уже добален ( `+ files[i].name +` )`);
            }
            else{
                uploadsImages.push(files[i]);
                let imgTempUrl = URL.createObjectURL(files[i]);
                $('.drag-and-drop').append(`<div class="drag-and-drop-img" style="background-image: url(`+ imgTempUrl +`);" href="`+ files[i].name +`"></div>`);
            }
        }
        else{
            alert('Файл '+ files[i].name +' не подходящего формата');
        }
    }
});

// delete image block from drop zone
$('.drag-and-drop').on( 'click', 'div.drag-and-drop-img', function(e){
    e.preventDefault();
    var name = $(this).attr('href');
    // imagesToUnlink += name + ' ';
    for(let i = 0; i < uploadsImages.length; i++){
        if(name == uploadsImages[i].name){
            uploadsImages.splice(i, 1);
        }
    }
    $(this).remove();
} );
////// script for image editing
// open form
function openImageEditForm(name, lang) {
    let formWrap = $('.wt-admin-form-wrap');
    $('.form-wrap textarea').val('');
    $('.form-wrap .lang-buttons').attr('data-lang', lang);
    let nameInput = $('.wt-admin-form-wrap .form-wrap .form-input-image-name');
    nameInput.attr('placeholder', name);
    nameInput.val('');
    $('.wt-admin-form-wrap .lang-button').removeClass("lang-button-selected");
    let selectedLang = $('.wt-admin-form-wrap .lang-button-'+lang);

    selectedLang.addClass('lang-button-selected');

    // get textarea content
    $.ajax({
        url: "/admin/get-images-meta",
        type: "post",
        cache: false,
        data: {lang: lang, name: name},
        success: function (response) {
            // console.log(response);
            if(response != false) {
                response = JSON.parse(response);
                $('.textarea-wrap .textarea-alt').val(response['alt']),
                $('.textarea-wrap .textarea-title').val(response['title']),
                $('.textarea-wrap .textarea-description').val(response['description'])
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });

    if(formWrap.css('display') != 'block') {
        formWrap.fadeToggle();
    }
}
// close form
function closeImageEditForm() {
    let formWrap = $('.wt-admin-form-wrap');
    $('.wt-admin-form-wrap .form-wrap .form-input-image-name').val('');

    // $('.form-wrap textarea').text('');

    if(formWrap.css('display') == 'block') {
        formWrap.fadeToggle();
    }
}
// change form lang
function changeFormLang(lang) {
    $('.wt-admin-form-wrap .lang-button').removeClass("lang-button-selected");
    let name = $('.wt-admin-form-wrap .form-wrap .form-input-image-name').attr('placeholder');
    console.lo
    openImageEditForm(name, lang);
}
// function for prevent spaces in input
function inputSpaceLess(string) {
    return string.split(' ').join('');
}
// change image name
function changeImageName() {
    let name = $('.wt-admin-form-wrap .form-wrap .form-input-image-name').val();
    let oldName = $('.wt-admin-form-wrap .form-wrap .form-input-image-name').attr('placeholder');
    let lang = $('.form-wrap .lang-buttons').attr('data-lang');

    let formData = new FormData();

    formData.append('oldName', oldName);
    formData.append('name', name);

    if(name.trim().length > 0) {
        $.ajax({
            url: "/admin/change-images-name",
            type: "post",
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            success: function (response) {
                console.log(response);
                if(response != false){
                    openImageEditForm(response, lang);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
    else {
        console.log('empty name');
    }
    
}
// change image meta
function setImageMeta() {
    let name = $('.wt-admin-form-wrap .form-wrap .form-input-image-name').attr('placeholder');
    let lang = $('.form-wrap .lang-buttons').attr('data-lang');
    
    let data = {
        "name": name,
        "lang": lang,
        "alt" : $('.textarea-wrap .textarea-alt').val(),
        "title" : $('.textarea-wrap .textarea-title').val(),
        "description" : $('.textarea-wrap .textarea-description').val()
    }

    $.ajax({
        url: "/admin/set-images-meta",
        type: "post",
        cache: false,
        data: data,
        success: function (response) {
            console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}
// delete image
function deleteImage() {
    let name = $('.wt-admin-form-wrap .form-wrap .form-input-image-name').attr('placeholder');
    let item = document.querySelector('[data-name="'+name+'"]');

    $.ajax({
        url: "/admin/delete-image",
        type: "post",
        cache: false,
        data: {name: name},
        success: function (response) {
            console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
    item.remove();
    closeImageEditForm();
}
// upload images
function uploadImages() {

    let messageBlockClasses = document.querySelector(".images-message-block .message");
    let messageBlock = $(".images-message-block .message");

    if(messageBlock.css("display") == "block"){
        messageBlock.slideToggle(100);
    }
    messageBlockClasses.className = "message";

    function timeoutToggle() {messageBlock.slideToggle("slow");}

    // create virtual form
    let formData = new FormData();

    // check filling images
    if(uploadsImages.length > 0) {

        // add all imades to form
        for(let i in uploadsImages){
            formData.append(i, uploadsImages[i]);
        }

        $.ajax({
            url: "/admin/upload-images",
            type: "post",
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            success: function (response) {
                // console.log(response);
                if(response == true) {
                    window.location.href = "/admin/images";
                    // console.log('true');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
            
        // messageBlockClasses.className = "message good";
        // setTimeout(timeoutToggle, 400);
    }
    else{
        messageBlockClasses.innerHTML = "Не добавлено ни единого изображения"
        messageBlockClasses.className = "message bad";
        setTimeout(timeoutToggle, 400);
    }
}

////// script for image editing on product page
// open form for adding new images
function openImageAddingDropzone() {
    let formWrap = $('.wt-admin-product-dragndrop-wrap');
    let dropzone = $('.wt-admin-product-dragndrop-wrap .drag-and-drop');
    dropzone.empty();

    if(formWrap.css('display') != 'block') {
        formWrap.fadeToggle();
    }
}
// close form for adding new images
function closeImageAddingDropzone() {
    let formWrap = $('.wt-admin-product-dragndrop-wrap');
    let dropzone = $('.wt-admin-product-dragndrop-wrap .drag-and-drop');
    // dropzone.empty();

    if(formWrap.css('display') == 'block') {
        formWrap.fadeToggle();
    }
}
// add image to form and to storage
function uploadImagesOnProduct(key, lang) {

    let messageBlockClasses = document.querySelector(".images-message-block .message");
    let messageBlock = $(".images-message-block .message");

    if(messageBlock.css("display") == "block"){
        messageBlock.slideToggle(100);
    }
    messageBlockClasses.className = "message";

    function timeoutToggle() {messageBlock.slideToggle("slow");}

    // create virtual form
    let formData = new FormData();

    formData.append('p_key', key);

    // check filling images
    if(uploadsImages.length > 0) {

        // add all imades to form
        for(let i in uploadsImages){
            formData.append(i, uploadsImages[i]);
        }

        $.ajax({
            url: "/admin/upload-images-to-product",
            type: "post",
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            success: function (response) {
                response = JSON.parse(response);
                let imgGrid = document.querySelector('.wt-admin-img-form .img-grid');
                closeImageAddingDropzone();
                for (const [key, value] of Object.entries(response)) {
                    imgGrid.innerHTML += "<div class='item' data-name='"+ key +"' data-path='"+value+"'> <div class='edit-button' onclick=\"openImageEditForm('"+ key +"', '"+lang+"')\"></div> <div class='delete-item' onclick=\"deleteImageItem('"+ key +"')\"></div> <div class='move-buttons'> <div class='move-buttons-left' onclick=\"moveItemLeftRight('left', '"+ key +"')\"></div> <div class='move-buttons-right' onclick=\"moveItemLeftRight('right', '"+ key +"')\"></div> </div> <div class='img-item' style='background-image: url("+value+");'></div> <p class='item-text'>"+ key +"</p> </div>";
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    }
    else{
        messageBlockClasses.innerHTML = "Не добавлено ни единого изображения"
        messageBlockClasses.className = "message bad";
        setTimeout(timeoutToggle, 400);
    }
}
// remove image item from form
function deleteImageItem(name) {
    let item = document.querySelector('[data-name="'+name+'"]');
    item.remove();
}
// move image items
function moveItemLeftRight(direction, element) {

    element = document.querySelector('[data-name="'+element+'"]');
    let allElements = document.querySelectorAll('.img-grid .item');
    let index = 0;

    for(let i=0; i < allElements.length; i++) {
        if(element == allElements[i]) index = i;
    }

    switch(direction) {
        case 'left':
            if(index != 0){
                element.parentNode.insertBefore(element, allElements[index-1] );
            }
            break
        case 'right':
            if(index != allElements.length - 1){
                element.parentNode.insertBefore( allElements[index+1], element);
            }
            break
    }
}


function clearMeta(array) {
    let metaFormObject = {};
    $.each(array,
    function(i, v) {
        metaFormObject[v.name] = v.value;
    });
    return JSON.stringify( Object.fromEntries(Object.entries(metaFormObject).filter(([_, v]) => v != '')), null );
}

function uploadImagesPost() {

    // create filled check variable
    let checkFields = false;
    
    // get all images
    let formData = new FormData();

    for(let i in uploadsImages){
        formData.append(i, uploadsImages[i]);
    }

    // get meta inputs
    let metaForm = $('#product_meta :input').serializeArray();
    let meta = clearMeta(metaForm);

    // get all inputs except category
    let name = document.getElementsByName('name')[0].value;
    let price = document.getElementsByName('price')[0].value;
    let properties = document.getElementsByName('properties')[0].value;
    let more_info = document.getElementsByName('more_info')[0].value;
    let description = document.getElementsByName('description')[0].value;

    let category_select = document.getElementsByName('category')[0];
    var category = category_select.options[category_select.selectedIndex].value;

    // adding all inputs to virtual form
    formData.append('name', name);
    formData.append('meta', meta);
    formData.append('price', price);
    formData.append('properties', properties);
    formData.append('more_info', more_info); 
    formData.append('description', description);
    formData.append('category', category);

    // check filling
    if( !(name === "") && !(properties === "") && !(category === "") && !(price === "") && !(description === "") && !(more_info === "") && (uploadsImages.length > 0) ){
        checkFields = true;
    }


    if(checkFields){

        $.ajax({
            url: "/admin/upload-product",
            type: "post",
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            success: function (response) {
                console.log(response);
                window.location.href = "/admin/create-product";
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    }
    

}

function updateImagesPost(path, lang) {

    // create filled check variable
    let checkFields = false;

    // get all images and images for remove
    let formData = new FormData();

    let images = document.querySelectorAll('.img-grid .item');
    let imagesList = '';
    for(let i = 0; i < images.length; i++){
        imagesList += images[i].getAttribute('data-name') + ' ';
    }

    // get meta inputs
    let metaForm = $('#product_meta :input').serializeArray();
    let meta = clearMeta(metaForm);

    // get all inputs except category
    let name = document.getElementsByName('name')[0].value;
    let price = document.getElementsByName('price')[0].value;
    let properties = document.getElementsByName('properties')[0].value;
    let more_info = document.getElementsByName('more_info')[0].value;
    let description = document.getElementsByName('description')[0].value;

    let category_select = document.getElementsByName('categorySelect')[0];
    var category = category_select.options[category_select.selectedIndex].value;

    // adding all inputs to virtual form
    formData.append('name', name);
    formData.append('meta', meta);
    formData.append('price', price);
    formData.append('properties', properties);
    formData.append('more_info', more_info);
    formData.append('description', description);
    formData.append('category', category);
    formData.append('images', imagesList);

    // check filling
    if( !(name === "") && !(properties === "") && !(category === "") && !(price === "") && !(description === "") && !(more_info === "") && !(imagesList === "")){
        checkFields = true;
    }

    if(checkFields){

        $.ajax({
            url: "/admin/update-product/" + path +"/"+ lang,
            type: "post",
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            //data : { "images" : formData.getAll('images') },
            success: function (response) {
                // setTimeout(document.location.reload(), 50);
                console.log(response);
                window.location.href = "/admin/products";
                
    
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //console.log(textStatus, errorThrown);
            }
        });

    }
    // console.log(uploadsImages);
}

//////// Page select image
function selectImageForPage(name) {
    let imageList = $('.wt-admin-img-form-on-page');
    imageList.attr('data-name',name);

    if(imageList.css('display') != 'block') {
        imageList.fadeToggle();
    }
    // console.log(name);
}

function closeImgFogmOnPage() {
    let imageList = $('.wt-admin-img-form-on-page');
    imageList.attr('data-name','');

    if(imageList.css('display') == 'block') {
        imageList.fadeToggle();
    }
}

function addImgToPageField(e) {
    let imageList = $('.wt-admin-img-form-on-page');
    let fieldName = imageList.attr('data-name');
    let imgName = e.getAttribute('data-name');
    let imgPath = e.getAttribute('data-path');

    let fieldP = $('#image_field_'+fieldName+' p');
    let fieldImg = $('#image_field_'+fieldName+' img');
    let fieldInput = $('#image_field_'+fieldName+' input');

    fieldP.text(imgName);
    fieldInput.val(imgName);
    fieldImg.attr('src', imgPath);
    closeImgFogmOnPage();
}