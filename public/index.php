<?php

#define('ROOT_PATH','/Applications/mamp/htdocs/wdtr-production/wood-tradecomua');
define('ROOT_PATH','wood-trade.com.ua');

require ROOT_PATH.'/config/core.php';
include_once ROOT_PATH.'/vendor/autoload.php';

#DB Entry
$database = new Database();
$db = $database->getConnection();

#Multilang
$language = new Language($db);
$locales = $language->getAll();

#ADMIN
Route::add('/admin\/?', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/main.php');
}, ['get','post']);

Route::add('/admin/login', function() {
  include(ROOT_PATH.'/app/middleware/login.php');
}, ['get','post']);

Route::add('/admin/logout', function() {
  include(ROOT_PATH.'/app/middleware/logout.php');
});

Route::add('/admin/register', function() {
  include(ROOT_PATH.'/app/middleware/register.php');
}, ['get','post']);
#END ADMIN

#Product categories
Route::add('/admin/categories', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/product_categories/main.php');
});

Route::add('/admin/create-product-category', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/product_categories/create_product_category.php');
}, ['get']);

Route::add('/admin/create-product-category', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/product_categories/create_product_category.php');
}, ['post']);

Route::add('/admin/edit-product-category/([a-z-0-9-\/]*)/([a-z-0-9-\/]*)', function($path, $locale) {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/product_categories/edit_product_category.php');
}, ['get']);

Route::add('/admin/edit-product-category/([a-z-0-9-\/]*)/([a-z-0-9-\/]*)', function($path, $locale) {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/product_categories/edit_product_category.php');
}, ['post']);

#Products
Route::add('/admin/products', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/products/main.php');
});

Route::add('/admin/create-product', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/products/create_product.php');
}, ['get']);

Route::add('/admin/create-product', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/products/create_product.php');
}, ['post']);

Route::add('/admin/upload-product', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/products/upload_product.php');
}, ['post']);

Route::add('/admin/edit-product/([a-z-0-9-\/]*)/([a-z-0-9-\/]*)', function($path, $locale) {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/products/edit_product.php');
}, ['get']);

Route::add('/admin/edit-product/([a-z-0-9-\/]*)/([a-z-0-9-\/]*)', function($path, $locale) {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/products/edit_product.php');
}, ['post']);

Route::add('/admin/update-product/([a-z-0-9-\/]*)/([a-z-0-9-\/]*)', function($path, $locale) {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/products/update_product.php');
}, ['post']);
#Images for products
// get image meta
Route::add('/admin/upload-images-to-product', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/upload_images_to_product.php');
}, ['get']);

Route::add('/admin/upload-images-to-product', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/upload_images_to_product.php');
}, ['post']);

#Images
Route::add('/admin/images', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/main.php');
});
// imades adding to post
Route::add('/admin/add-images', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/add_images.php');
}, ['get']);

Route::add('/admin/add-images', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/add_images.php');
}, ['post']);
// delete image
Route::add('/admin/delete-image', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/delete_image.php');
}, ['get']);

Route::add('/admin/delete-image', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/delete_image.php');
}, ['post']);
// images upload script
Route::add('/admin/upload-images', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/upload_images.php');
}, ['get']);

Route::add('/admin/upload-images', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/upload_images.php');
}, ['post']);
// images name change script
Route::add('/admin/change-images-name', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/change_images_name.php');
}, ['get']);

Route::add('/admin/change-images-name', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/change_images_name.php');
}, ['post']);
// set image meta
Route::add('/admin/set-images-meta', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/set_image_meta.php');
}, ['get']);

Route::add('/admin/set-images-meta', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/set_image_meta.php');
}, ['post']);
// get image meta
Route::add('/admin/get-images-meta', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/get_image_meta.php');
}, ['get']);

Route::add('/admin/get-images-meta', function() {
  include(ROOT_PATH.'/app/middleware/login_checker.php');
  include('admin/templates/images/get_image_meta.php');
}, ['post']);

#PAGES
Route::add('/admin/pages', function() {
  include('admin/middleware/login_checker.php');
  include('admin/templates/pages/main.php');
  // $view = new View('admin/templates/pages/main.php');
  // $view->render();
});

Route::add('/admin/create-page/([a-z-0-9-\/]*)/([a-z-0-9-\/]*)', function($path, $locale) {
  include('admin/middleware/login_checker.php');
  include('admin/templates/pages/create_page.php');
  // $view = new View('admin/templates/pages/main.php');
  // $view->render();
}, ['get']);

Route::add('/admin/create-page/([a-z-0-9-\/]*)/([a-z-0-9-\/]*)', function($path, $locale) {
  include('admin/middleware/login_checker.php');
  include('admin/templates/pages/create_page.php');
}, ['post']);

Route::add('/admin/edit-page/([a-z-0-9-\/]*)/([a-z-0-9-\/]*)', function($path, $locale) {
  include('admin/middleware/login_checker.php');
  include('admin/templates/pages/edit_page.php');
  // $view = new View('admin/templates/pages/main.php');
  // $view->render();
}, ['get']);

Route::add('/admin/edit-page/([a-z-0-9-\/]*)/([a-z-0-9-\/]*)', function($path, $locale) {
  include('admin/middleware/login_checker.php');
  include('admin/templates/pages/edit_page.php');
}, ['post']);

Route::add('/admin/static', function() {
  include('admin/middleware/login_checker.php');
  include('admin/templates/static/main.php');
  // $view = new View('admin/templates/pages/main.php');
  // $view->render();
});

Route::add('/admin/create-static/([a-z-0-9-\/]*)/([a-z-0-9-\/]*)', function($path, $locale) {
  include('admin/middleware/login_checker.php');
  include('admin/templates/static/create_static.php');
  // $view = new View('admin/templates/pages/main.php');
  // $view->render();
}, ['get']);

Route::add('/admin/create-static/([a-z-0-9-\/]*)/([a-z-0-9-\/]*)', function($path, $locale) {
  include('admin/middleware/login_checker.php');
  include('admin/templates/static/create_static.php');
}, ['post']);

Route::add('/admin/edit-static/([a-z-0-9-\/]*)/([a-z-0-9-\/]*)', function($path, $locale) {
  include('admin/middleware/login_checker.php');
  include('admin/templates/static/edit_static.php');
  // $view = new View('admin/templates/pages/main.php');
  // $view->render();
}, ['get']);

Route::add('/admin/edit-static/([a-z-0-9-\/]*)/([a-z-0-9-\/]*)', function($path, $locale) {
  include('admin/middleware/login_checker.php');
  include('admin/templates/static/edit_static.php');
}, ['post']);

Route::add('/admin/pages/([a-z-0-9-\/]*)', function($path) {
    include('admin/middleware/login_checker.php');
    include('admin/templates/pages/main.php');
  // $view = new View($path);
  // $view->render();
});
#END PAGES

Route::add('/toony', function() {

  $database = new Database();
  $db = $database->getConnection();
  $micro_type = new MicroType($db);
  $micro_type->getByID($_POST['id']);
  $response = json_encode($micro_type, JSON_UNESCAPED_UNICODE);
  print_r( $response);

}, ['post']);

Route::add('/product/([a-z-0-9-\/]*)', function($slug) {
  
  //echo $slug;
  $database = new Database();
  $db = $database->getConnection();

  $product = new Product($db);
  $path = "product-card";
  $lang = BASELOCALE;
  $_SESSION['language'] = $lang;
  $products["products"] = $product->readAll(BASELOCALE);

  $img = new Images($db);

  // get image and this meta for catalog
  $images = [];
  $images_meta = [];

  foreach($products["products"] as $key => $value) {
    $value['images'] = explode(" ", $value['images']);
    $images[$value['p_key']] = $value['images'][0];
  }
  
  foreach($images as $key => $value) {
    $img->name = $value;
    $img->img_id = $img->getIDByName();
    $img->lang = BASELOCALE;
    $img->name = $value;

    $images_meta[$key]['name'] = $value;
    $images_meta[$key]['path'] = $img->getPathByName();
    $images_meta[$key]['img_id'] = $img->img_id;

    $img_item_meta = $img->getMetaByIDAndLang();
    $img_item_meta = json_decode($img_item_meta, true);
    $images_meta[$key]['alt'] = $img_item_meta['alt'];
    $images_meta[$key]['title'] = $img_item_meta['title'];
    $images_meta[$key]['description'] = $img_item_meta['description'];
  }
  $images_meta['images_meta'] = $images_meta;
  
  $product->getBySlug($slug, $lang);
  if($product->p_key == null) $path = '404';

  $p_slugs = $product->getAllByKey();

  $p_slug = [];
  foreach($p_slugs as $key => $value){
    $p_slug[$value['lang']] = $value['slug'];
  }
  $p_slugs['p_slug'] = $p_slug;

  $page = new Page($db);
  $page->slug = $path;
  $page->lang = $lang;
  $page->getData();


  $te = new TemplateEditor($db);
  $partials = $te->getStaticPartials($path);

  $static = new StaticBlock($db);
  $staticData = [];

  $pc = new ProductCategory($db);
  $pc->lang = BASELOCALE;
  $pc_query = $pc->readAllByLang();
  $pc_query = $pc_query->fetchAll();
  $pc_all['categories'] = $pc_query;

  $language = new Language($db);
  $locales = $language->getAll();

  $product_data = array_combine( array_map(function($key){ return 'item_'.$key; }, array_keys( (array)$product )), (array)$product);

  $product_images_list = $product_data["item_images"];
  $product_images_list = explode(" ", $product_images_list);

  foreach($product_images_list as $key => $value){

    if($value != ""){
      $product_images[$key]['name'] = $value;
      $img->name = $value;
      $img->path = $img->getPathByName();
      $product_images[$key]['path'] = $img->path;
      $img->lang = BASELOCALE;
      $img->name = $value;
      $img_id = $img->getIDByName();
      $img->img_id = $img_id;
      $current_image_meta = $img->getMetaByIDAndLang();
      $current_image_meta = json_decode($current_image_meta, true);
      // var_dump($current_image_meta['alt']);
      if($current_image_meta != NULL) {
        $product_images[$key]['alt'] = $current_image_meta['alt'];
        $product_images[$key]['title'] = $current_image_meta['title'];
        $product_images[$key]['description'] = $current_image_meta['description'];
      }
      else{
        $product_images[$key]['alt'] = '';
        $product_images[$key]['title'] = '';
        $product_images[$key]['description'] = '';
      }
    }
  }
  $product_images['images'] = $product_images;

  $static->lang = $lang;

  foreach ($partials as $p) {
    $static->slug = $p;
    $static->getData();

    $static->data = json_decode($static->data, true);

    foreach($static->data as $key => $value) {
      if(strpos($key, 'image_') === (int)0) {

        $img->name = $value;
        $img->img_id = $img->getIDByName();
        $img->lang = BASELOCALE;
        $img->name = $value;

        $static->data[$key] = [];

        $static->data[$key]['name'] = $value;
        $static->data[$key]['path'] = $img->getPathByName();
        $static->data[$key]['img_id'] = $img->img_id;

        $img_item_meta = $img->getMetaByIDAndLang();
        $img_item_meta = json_decode($img_item_meta, true);
        $static->data[$key]['alt'] = $img_item_meta['alt'];
        $static->data[$key]['title'] = $img_item_meta['title'];
        $static->data[$key]['description'] = $img_item_meta['description'];        
      }
    }

    if (!is_null($static->data)) $staticData = array_merge ( (array)$staticData, $static->data );
  }

  $dynamic = json_decode($page->data, true);
  $static = json_decode($page->static, true);
  $meta = json_decode($product->meta, true);

  $data = array_merge((array)$dynamic, (array)$staticData, (array)$product_data, (array)$product_images, (array)$pc_all, (array)$meta, (array)$p_slugs, (array)$products, (array)$images_meta);
  $data["locales"] = $locales;
  $view = new View($path);
  $view->render($data, $slug);
  
}, ['get']);

Route::add('/catalog/([a-z-0-9-\/]*)', function($slug) {
  include(ROOT_PATH.'/app/middleware/session.php');

  $path = "catalog";

  $database = new Database();
  $db = $database->getConnection();
  $page = new Page($db);

  $pc = new ProductCategory($db);
  $pc->slug = $slug;
  $pc->c_key = $pc->getKeyBySlug();
  $pc->lang = BASELOCALE;
      
  if($pc->c_key == null) $path = "404";
  
  $page->slug = $path ? $path : 'main';
  $_SESSION['language'] = BASELOCALE;
  $page->lang = BASELOCALE;
  $page->getData();

  $te = new TemplateEditor($db);
  $partials = $te->getStaticPartials($page->slug);
  
  $static = new StaticBlock($db);
  $static->lang = BASELOCALE;
  $staticData = [];

  $pc_query = $pc->readAllByLang();
  $pc_query = $pc_query->fetchAll();
  $pc_all['categories'] = $pc_query;
  $pc_all['category_name'] =  $pc->getNameBySlugAndLang();

  $c_slugs = $pc->getAllSlugsAngLang();
  $c_slug = [];
  foreach($c_slugs as $key => $value){
    $c_slug[$value['lang']] = $value['slug'];
  }
  $c_slugs['c_slug'] = $c_slug;

  $product = new Product($db);
  $product->category = $pc->c_key;
  $product->lang = BASELOCALE;
  $products["products"] = $product->getAllByCategoryAndLang();

  $img = new Images($db);

  // get image and this meta
  $images = [];
  $images_meta = [];

  foreach($products["products"] as $key => $value) {
    $value['images'] = explode(" ", $value['images']);
    $images[$value['p_key']] = $value['images'][0];
  }
  
  foreach($images as $key => $value) {
    $img->name = $value;
    $img->img_id = $img->getIDByName();
    $img->lang = BASELOCALE;
    $img->name = $value;

    $images_meta[$key]['name'] = $value;
    $images_meta[$key]['path'] = $img->getPathByName();
    $images_meta[$key]['img_id'] = $img->img_id;

    $img_item_meta = $img->getMetaByIDAndLang();
    $img_item_meta = json_decode($img_item_meta, true);
    $images_meta[$key]['alt'] = $img_item_meta['alt'];
    $images_meta[$key]['title'] = $img_item_meta['title'];
    $images_meta[$key]['description'] = $img_item_meta['description'];
  }
  $images_meta['images_meta'] = $images_meta;

  $language = new Language($db);
  $locales = $language->getAll();

  foreach ($partials as $p) {
    $static->slug = $p;
    $static->getData();

    $static->data = json_decode($static->data, true);

    foreach($static->data as $key => $value) {
      if(strpos($key, 'image_') === (int)0) {

        $img->name = $value;
        $img->img_id = $img->getIDByName();
        $img->lang = BASELOCALE;
        $img->name = $value;

        $static->data[$key] = [];

        $static->data[$key]['name'] = $value;
        $static->data[$key]['path'] = $img->getPathByName();
        $static->data[$key]['img_id'] = $img->img_id;

        $img_item_meta = $img->getMetaByIDAndLang();
        $img_item_meta = json_decode($img_item_meta, true);
        $static->data[$key]['alt'] = $img_item_meta['alt'];
        $static->data[$key]['title'] = $img_item_meta['title'];
        $static->data[$key]['description'] = $img_item_meta['description'];        
      }
    }

    if (!is_null($static->data)) $staticData = array_merge ( (array)$staticData, $static->data );
  }
  
  $dynamic = json_decode($page->data, true);
  $static = json_decode($page->static, true);
  $meta = json_decode($product->meta, true);

  $data = array_merge((array)$dynamic, (array)$staticData, (array)$meta, (array)$pc_all, (array)$products, (array)$images_meta, (array)$c_slugs);
  
  $data["locales"] = $locales;
  $view = new View($path);
  $view->render($data);
  

}, ['get']);

foreach ($locales as $locale) {

  Route::add('/('.$locale['slug'].')\/catalog/([a-z-0-9-\/]*)', function($locale, $slug) {
    include(ROOT_PATH.'/app/middleware/session.php');

    $path = "catalog";

    $database = new Database();
    $db = $database->getConnection();
    $page = new Page($db);

    $pc = new ProductCategory($db);
    $pc->slug = $slug;
    $pc->c_key = $pc->getKeyBySlug();
    $pc->lang = $locale;
      
    if($pc->c_key == null) $path = "404";
    
    $page->slug = $path ? $path : 'main';
    $_SESSION['language'] = $locale;
    $page->lang = $locale;
    $page->getData();

    $te = new TemplateEditor($db);
    $partials = $te->getStaticPartials($page->slug);
    
    $static = new StaticBlock($db);
    $static->lang = $locale;
    $staticData = [];

    $pc_query = $pc->readAllByLang();
    $pc_query = $pc_query->fetchAll();
    $pc_all['categories'] = $pc_query;
    $pc_all['category_name'] =  $pc->getNameBySlugAndLang();

    $c_slugs = $pc->getAllSlugsAngLang();
    $c_slug = [];
    foreach($c_slugs as $key => $value){
      $c_slug[$value['lang']] = $value['slug'];
    }
    $c_slugs['c_slug'] = $c_slug;

    $product = new Product($db);
    $product->category = $pc->c_key;
    $product->lang = $locale;
    $products["products"] = $product->getAllByCategoryAndLang();

    $img = new Images($db);

    // get image and this meta
    $images = [];
    $images_meta = [];

    foreach($products["products"] as $key => $value) {
      $value['images'] = explode(" ", $value['images']);
      $images[$value['p_key']] = $value['images'][0];
    }
    
    foreach($images as $key => $value) {
      $img->name = $value;
      $img->img_id = $img->getIDByName();
      $img->lang = $locale;
      $img->name = $value;

      $images_meta[$key]['name'] = $value;
      $images_meta[$key]['path'] = $img->getPathByName();
      $images_meta[$key]['img_id'] = $img->img_id;

      $img_item_meta = $img->getMetaByIDAndLang();
      $img_item_meta = json_decode($img_item_meta, true);
      $images_meta[$key]['alt'] = $img_item_meta['alt'];
      $images_meta[$key]['title'] = $img_item_meta['title'];
      $images_meta[$key]['description'] = $img_item_meta['description'];
    }
    $images_meta['images_meta'] = $images_meta;

    $language = new Language($db);
    $locales = $language->getAll();

    foreach ($partials as $p) {
      $static->slug = $p;
      $static->getData();

      $static->data = json_decode($static->data, true);

      foreach($static->data as $key => $value) {
        if(strpos($key, 'image_') === (int)0) {

          $img->name = $value;
          $img->img_id = $img->getIDByName();
          $img->lang = $locale;
          $img->name = $value;

          $static->data[$key] = [];

          $static->data[$key]['name'] = $value;
          $static->data[$key]['path'] = $img->getPathByName();
          $static->data[$key]['img_id'] = $img->img_id;

          $img_item_meta = $img->getMetaByIDAndLang();
          $img_item_meta = json_decode($img_item_meta, true);
          $static->data[$key]['alt'] = $img_item_meta['alt'];
          $static->data[$key]['title'] = $img_item_meta['title'];
          $static->data[$key]['description'] = $img_item_meta['description'];        
        }
      }

      if (!is_null($static->data)) $staticData = array_merge ( (array)$staticData, $static->data );
    }
    
    $dynamic = json_decode($page->data, true);
    $static = json_decode($page->static, true);
    $meta = json_decode($product->meta, true);

    $data = array_merge((array)$dynamic, (array)$staticData, (array)$meta, (array)$pc_all, (array)$products, (array)$images_meta, (array)$c_slugs);
    
    $data["locales"] = $locales;
    $view = new View($path);
    $view->render($data);

  }, ['get']);

  Route::add('/('.$locale['slug'].')\/product/([a-z-0-9-\/]*)', function($locale, $slug) {
    //echo $slug;
    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);
    $path = "product-card";
    $lang = $locale;
    $_SESSION['language'] = $lang;
    $products["products"] = $product->readAll($lang);

    $img = new Images($db);

    // get image and this meta for catalog
    $images = [];
    $images_meta = [];

    foreach($products["products"] as $key => $value) {
      $value['images'] = explode(" ", $value['images']);
      $images[$value['p_key']] = $value['images'][0];
    }
    
    foreach($images as $key => $value) {
      $img->name = $value;
      $img->img_id = $img->getIDByName();
      $img->lang = $locale;
      $img->name = $value;

      $images_meta[$key]['name'] = $value;
      $images_meta[$key]['path'] = $img->getPathByName();
      $images_meta[$key]['img_id'] = $img->img_id;

      $img_item_meta = $img->getMetaByIDAndLang();
      $img_item_meta = json_decode($img_item_meta, true);
      $images_meta[$key]['alt'] = $img_item_meta['alt'];
      $images_meta[$key]['title'] = $img_item_meta['title'];
      $images_meta[$key]['description'] = $img_item_meta['description'];
    }
    $images_meta['images_meta'] = $images_meta;

    // END catalog images

    $product->getBySlug($slug, $lang);
    if($product->p_key == null) $path = '404';

    $p_slugs = $product->getAllByKey();

    $p_slug = [];
    foreach($p_slugs as $key => $value){
      $p_slug[$value['lang']] = $value['slug'];

    }
    $p_slugs['p_slug'] = $p_slug;

    $page = new Page($db);
    $page->slug = $path;
    $page->lang = $lang;
    $page->getData();

    $te = new TemplateEditor($db);
    $partials = $te->getStaticPartials($path);

    $static = new StaticBlock($db);
    $staticData = [];

    $pc = new ProductCategory($db);
    $pc->lang = $locale;
    $pc_query = $pc->readAllByLang();
    $pc_query = $pc_query->fetchAll();
    $pc_all['categories'] = $pc_query;

    $language = new Language($db);
    $locales = $language->getAll();

    $product_data = array_combine( array_map(function($key){ return 'item_'.$key; }, array_keys( (array)$product )), (array)$product);

    $product_images_list = $product_data["item_images"];
    $product_images_list = explode(" ", $product_images_list);

    foreach($product_images_list as $key => $value){

      if($value != ""){
        $product_images[$key]['name'] = $value;
        $img->name = $value;
        $img->path = $img->getPathByName();
        $product_images[$key]['path'] = $img->path;
        $img->lang = $locale;
        $img->name = $value;
        $img_id = $img->getIDByName();
        $img->img_id = $img_id;
        $current_image_meta = $img->getMetaByIDAndLang();
        $current_image_meta = json_decode($current_image_meta, true);
        // var_dump($current_image_meta['alt']);
        if($current_image_meta != NULL) {
          $product_images[$key]['alt'] = $current_image_meta['alt'];
          $product_images[$key]['title'] = $current_image_meta['title'];
          $product_images[$key]['description'] = $current_image_meta['description'];
        }
        else{
          $product_images[$key]['alt'] = '';
          $product_images[$key]['title'] = '';
          $product_images[$key]['description'] = '';
        }
      }
    }
    $product_images['images'] = $product_images;

    $static->lang = $lang;

    foreach ($partials as $p) {
      $static->slug = $p;
      $static->getData();

      $static->data = json_decode($static->data, true);

      foreach($static->data as $key => $value) {
        if(strpos($key, 'image_') === (int)0) {

          $img->name = $value;
          $img->img_id = $img->getIDByName();
          $img->lang = $locale;
          $img->name = $value;

          $static->data[$key] = [];

          $static->data[$key]['name'] = $value;
          $static->data[$key]['path'] = $img->getPathByName();
          $static->data[$key]['img_id'] = $img->img_id;

          $img_item_meta = $img->getMetaByIDAndLang();
          $img_item_meta = json_decode($img_item_meta, true);
          $static->data[$key]['alt'] = $img_item_meta['alt'];
          $static->data[$key]['title'] = $img_item_meta['title'];
          $static->data[$key]['description'] = $img_item_meta['description'];        
        }
      }

      if (!is_null($static->data)) $staticData = array_merge ( (array)$staticData, $static->data );
    }

    $dynamic = json_decode($page->data, true);
    $static = json_decode($page->static, true);
    $meta = json_decode($product->meta, true);

    $data = array_merge((array)$dynamic, (array)$staticData, (array)$product_data, (array)$product_images, (array)$pc_all, (array)$meta, (array)$p_slugs, (array)$products, (array)$images_meta); //, (array)$products добавить в мердж
    $data["locales"] = $locales;

    $view = new View($path);
    $view->render($data, $slug);

    // var_dump($product);


  }, ['get']);

  Route::add('/('.$locale['slug'].')\/?([a-z-0-9-\/]*)', function($locale, $path) {
    include(ROOT_PATH.'/app/middleware/session.php');

    $t_path = $path ? $_SERVER['DOCUMENT_ROOT'].'/templates/'.$path.'.twig' : $_SERVER['DOCUMENT_ROOT'].'/templates/main.twig';

    if ( !file_exists( $t_path ) ) {
      header('HTTP/1.0 404 Not Found');
      $path = '404';
    }

    $database = new Database();
    $db = $database->getConnection();
    $page = new Page($db);
    $page->slug = $path ? $path : 'main';
    $_SESSION['language'] = $locale;
    $page->lang = $locale;
    $page->getData($locale);
    
    $language = new Language($db);
    $locales = $language->getAll();

    $te = new TemplateEditor($db);
    $partials = $te->getStaticPartials($page->slug);

    $img = new Images($db);
    
    $static = new StaticBlock($db);
    $staticData = [];
    $static->lang = $locale;

    $pc = new ProductCategory($db);
    $pc->lang = $locale;
    $pc_query = $pc->readAllByLang();
    $pc_query = $pc_query->fetchAll();
    $pc_all['categories'] = $pc_query;

    foreach ($partials as $p) {
      $static->slug = $p;
      $static->getData();

      $static->data = json_decode($static->data, true);

      foreach($static->data as $key => $value) {
        if(strpos($key, 'image_') === (int)0) {

          $img->name = $value;
          $img->img_id = $img->getIDByName();
          $img->lang = BASELOCALE;
          $img->name = $value;

          $static->data[$key] = [];

          $static->data[$key]['name'] = $value;
          $static->data[$key]['path'] = $img->getPathByName();
          $static->data[$key]['img_id'] = $img->img_id;

          $img_item_meta = $img->getMetaByIDAndLang();
          $img_item_meta = json_decode($img_item_meta, true);
          $static->data[$key]['alt'] = $img_item_meta['alt'];
          $static->data[$key]['title'] = $img_item_meta['title'];
          $static->data[$key]['description'] = $img_item_meta['description'];        
        }
      }
      
      if (!is_null($static->data)) $staticData = array_merge ( (array)$staticData, $static->data );
    }

    $dynamic = json_decode($page->data, true);
    foreach($dynamic as $key => $value) {
      if(strpos($key, 'image_') === (int)0) {

        $img->name = $value;
        $img->img_id = $img->getIDByName();
        $img->lang = $locale;
        $img->name = $value;

        $dynamic[$key] = [];

        $dynamic[$key]['name'] = $value;
        $dynamic[$key]['path'] = $img->getPathByName();
        $dynamic[$key]['img_id'] = $img->img_id;

        $img_item_meta = $img->getMetaByIDAndLang();
        $img_item_meta = json_decode($img_item_meta, true);
        $dynamic[$key]['alt'] = $img_item_meta['alt'];
        $dynamic[$key]['title'] = $img_item_meta['title'];
        $dynamic[$key]['description'] = $img_item_meta['description'];        
      }
    }

    $data = array_merge((array)$dynamic, (array)$staticData, (array)$pc_all);
    $data["locales"] = $locales;
    
    if($path == "catalog") {
      $product = new Product($db);

      $products["products"] = $product->readAll($locale);

      // get image and this meta
      $images = [];
      $images_meta = [];

      foreach($products["products"] as $key => $value) {
        $value['images'] = explode(" ", $value['images']);
        $images[$value['p_key']] = $value['images'][0];
      }
      
      foreach($images as $key => $value) {
        $img->name = $value;
        $img->img_id = $img->getIDByName();
        $img->lang = $locale;
        $img->name = $value;

        $images_meta[$key]['name'] = $value;
        $images_meta[$key]['path'] = $img->getPathByName();
        $images_meta[$key]['img_id'] = $img->img_id;

        $img_item_meta = $img->getMetaByIDAndLang();
        $img_item_meta = json_decode($img_item_meta, true);
        $images_meta[$key]['alt'] = $img_item_meta['alt'];
        $images_meta[$key]['title'] = $img_item_meta['title'];
        $images_meta[$key]['description'] = $img_item_meta['description'];
      }
      $images_meta['images_meta'] = $images_meta;


      $data = array_merge($data, (array)$products, (array)$images_meta);
    }

    $view = new View($path);
    $view->render($data);

  }, ['get']);

}

Route::add('/([a-z-0-9-\/]*)', function($path) {
  include(ROOT_PATH.'/app/middleware/session.php');

  $t_path = $path ? $_SERVER['DOCUMENT_ROOT'].'/templates/'.$path.'.twig' : $_SERVER['DOCUMENT_ROOT'].'/templates/main.twig';
  if ( !file_exists( $t_path ) ) {
    header('HTTP/1.0 404 Not Found');// добавить в хедер <meta name="robots" content="noindex">
    $path = '404';
  }

  $database = new Database();
  $db = $database->getConnection();
  $page = new Page($db);
  
  $page->slug = $path ? $path : 'main';
  $_SESSION['language'] = BASELOCALE;
  $page->lang = BASELOCALE;
  $page->getData();

  $te = new TemplateEditor($db);
  $partials = $te->getStaticPartials($page->slug);

  $img = new Images($db);
  
  $static = new StaticBlock($db);
  $static->lang = BASELOCALE;
  $staticData = [];

  $pc = new ProductCategory($db);
  $pc->lang = BASELOCALE;
  $pc_query = $pc->readAllByLang();
  $pc_query = $pc_query->fetchAll();
  $pc_all['categories'] = $pc_query;

  $language = new Language($db);
  $locales = $language->getAll();

  foreach ($partials as $p) {
    $static->slug = $p;
    $static->getData();

    $static->data = json_decode($static->data, true);

    foreach($static->data as $key => $value) {
      if(strpos($key, 'image_') === (int)0) {

        $img->name = $value;
        $img->img_id = $img->getIDByName();
        $img->lang = BASELOCALE;
        $img->name = $value;

        $static->data[$key] = [];

        $static->data[$key]['name'] = $value;
        $static->data[$key]['path'] = $img->getPathByName();
        $static->data[$key]['img_id'] = $img->img_id;

        $img_item_meta = $img->getMetaByIDAndLang();
        $img_item_meta = json_decode($img_item_meta, true);
        $static->data[$key]['alt'] = $img_item_meta['alt'];
        $static->data[$key]['title'] = $img_item_meta['title'];
        $static->data[$key]['description'] = $img_item_meta['description'];        
      }
    }

    if (!is_null($static->data)) $staticData = array_merge ( (array)$staticData, $static->data );
  }
  
  $dynamic = json_decode($page->data, true);

  foreach($dynamic as $key => $value) {
    if(strpos($key, 'image_') === (int)0) {

      $img->name = $value;
      $img->img_id = $img->getIDByName();
      $img->lang = BASELOCALE;
      $img->name = $value;

      $dynamic[$key] = [];

      $dynamic[$key]['name'] = $value;
      $dynamic[$key]['path'] = $img->getPathByName();
      $dynamic[$key]['img_id'] = $img->img_id;

      $img_item_meta = $img->getMetaByIDAndLang();
      $img_item_meta = json_decode($img_item_meta, true);
      $dynamic[$key]['alt'] = $img_item_meta['alt'];
      $dynamic[$key]['title'] = $img_item_meta['title'];
      $dynamic[$key]['description'] = $img_item_meta['description'];        
    }
  }

  if($path == "catalog") {
    $product = new Product($db);

    $products["products"] = $product->readAll(BASELOCALE);

    // get image and this meta
    $images = [];
    $images_meta = [];

    foreach($products["products"] as $key => $value) {
      $value['images'] = explode(" ", $value['images']);
      $images[$value['p_key']] = $value['images'][0];
    }
    
    foreach($images as $key => $value) {
      $img->name = $value;
      $img->img_id = $img->getIDByName();
      $img->lang = BASELOCALE;
      $img->name = $value;

      $images_meta[$key]['name'] = $value;
      $images_meta[$key]['path'] = $img->getPathByName();
      $images_meta[$key]['img_id'] = $img->img_id;

      $img_item_meta = $img->getMetaByIDAndLang();
      $img_item_meta = json_decode($img_item_meta, true);
      $images_meta[$key]['alt'] = $img_item_meta['alt'];
      $images_meta[$key]['title'] = $img_item_meta['title'];
      $images_meta[$key]['description'] = $img_item_meta['description'];
    }
    $images_meta['images_meta'] = $images_meta;

    $data = array_merge((array)$dynamic, (array)$staticData, (array)$pc_all, (array)$products, (array)$images_meta);
  }
  else $data = array_merge((array)$dynamic, (array)$staticData, (array)$pc_all);
  
  $data["locales"] = $locales;
  $view = new View($path);
  $view->render($data);

}, ['get']);

Route::add('/submit-form', function() {
  $response = [
    'status' => false,
    'true' => '',
    'false' => ''
  ];

  if($_FILES){
    $file = $_FILES['file'];
  }

  switch ($_SESSION['language']) {
    case 'ru':
      $response['true'] = 'мы свяжемся с вами';
      $emailEmpty = 'Заполните поле почты';
      $nameEmpty = 'Имя не указано';
      $wronFile = 'Файл не подходящего формата';
      break;
    case 'ua':
      $response['true'] = 'ми з вами зв\'яжемось';
      $emailEmpty = 'Заповніть поле пошти';
      $nameEmpty = 'Ім\'я не вказано';
      $wronFile = 'Файл непридатного формату';
      break;
    case 'en':
      $response['true'] = 'we will contact you';
      $emailEmpty = 'Fill in the mail';
      $nameEmpty = 'Name not specified';
      $wronFile = 'File inappropriate format';
      break;
  }

  if($_POST){
    $name = $_POST['name'];
    $tel = $_POST['phone'];
    $email = $_POST['email'];

    if ( (strlen(preg_replace('/\s+/u','',$name)) == 0) ) {
      $response['false'] = $nameEmpty;
      print_r(json_encode($response, JSON_UNESCAPED_UNICODE));
    }
    else if ( (filter_var($email, FILTER_VALIDATE_EMAIL)) && (strlen(preg_replace('/\s+/u','',$email)) >= 8) ) {
      $response['status'] = true;

      $form = new Form($_POST);
      if($file){

        if($file['type'] == 'application/pdf'){
          $form->sendToSlack($file);
        }
        else{
          $response['status'] = false;
          $response['false'] = $wronFile;
        }
        print_r(json_encode($response, JSON_UNESCAPED_UNICODE));
      }
      else{
        $form->sendToSlack();
        print_r(json_encode($response, JSON_UNESCAPED_UNICODE));
      }
    }
    else {
      $response['false'] = $emailEmpty;
      print_r(json_encode($response, JSON_UNESCAPED_UNICODE));
    }
  }

}, ['post']);

  ///footer contfct form
  Route::add('/footer_contact_sand', function(){
    include(ROOT_PATH.'/app/middleware/session.php');

    $response = [
      'status' => false,
      'true' => '',
      'false' => ''
    ];

    switch ($_SESSION['language']) {
      case 'ru':
        $response['true'] = 'ожидайте звонка';
        $response['false'] = 'номер слишком короткий';
        break;
      case 'ua':
        $response['true'] = 'очікуйте дзвінка';
        $response['false'] = 'номер занадто короткий';
        break;
      case 'en':
        $response['true'] = 'expect a call';
        $response['false'] = 'the number is too short';
        break;

    }

    if($_POST){
      if(strlen(preg_replace('/[^0-9]/','',$_POST['phoneNumber'])) >= 9) {

        $message['text'] = "Телефон: ".$_POST['phoneNumber'];
        $json = json_encode($message);


        $slack_url = "https://hooks.slack.com/services/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";
        $ch = curl_init($slack_url);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_exec($ch);
        // echo curl_exec($ch);
        curl_close($ch);
        $response['status'] = true;
        print_r(json_encode($response, JSON_UNESCAPED_UNICODE));

      }
      else print_r(json_encode($response, JSON_UNESCAPED_UNICODE));
    }
  }, ['post']);

// Add a 404 not found route
Route::pathNotFound(function($path) {//, $locale
  header('HTTP/1.0 404 Not Found');
  
  $database = new Database();
  $db = $database->getConnection();

  $language = new Language($db);
  $locales = $language->getAll();
  $lang = BASELOCALE;

  foreach ($locales as $locale) {
    $path_lang = explode('/', $path);
    
    if(in_array($locale['slug'], $path_lang)){
      $lang = $locale['slug'];
    }
  }

  $path = '404';


  $database = new Database();
  $db = $database->getConnection();
  $page = new Page($db);
  
  $page->slug = $path ? $path : 'main';
  $_SESSION['language'] = $lang;
  $page->lang = $lang;
  $page->getData();

  $te = new TemplateEditor($db);
  $partials = $te->getStaticPartials($page->slug);
  
  $static = new StaticBlock($db);
  $static->lang = $lang;
  $staticData = [];

  $pc = new ProductCategory($db);
  $pc->lang = $lang;
  $pc_query = $pc->readAllByLang();
  $pc_query = $pc_query->fetchAll();
  $pc_all['categories'] = $pc_query;

  $language = new Language($db);
  $locales = $language->getAll();

  foreach ($partials as $p) {
    $static->slug = $p;
    $static->getData();

    $static->data = json_decode($static->data, true);

    if (!is_null($static->data)) $staticData = array_merge ( (array)$staticData, $static->data );
  }
  
  $dynamic = json_decode($page->data, true);

  $data = array_merge((array)$dynamic, (array)$staticData, (array)$pc_all);
  
  $data["locales"] = $locales;
  $view = new View($path);
  $view->render($data);

});

// Add a 405 method not allowed route
Route::methodNotAllowed(function($path, $method) {
  // Do not forget to send a status header back to the client
  // The router will not send any headers by default
  // So you will have the full flexibility to handle this case
  header('HTTP/1.0 405 Method Not Allowed');
  echo 'Error 405 :-(<br>';
  echo 'The requested path "'.$path.'" exists. But the request method "'.$method.'" is not allowed on this path!';
});

// Run the Router with the given Basepath
Route::run('/', true, true, false);

// Enable case sensitive mode, trailing slashes and multi match mode by setting the params to true
// Route::run(BASEPATH, true, true, true);

?>