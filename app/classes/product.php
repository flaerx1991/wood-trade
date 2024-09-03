<?php

	require __DIR__ .'/../../vendor/autoload.php';

    class Product {

      // database connection and table name
      private $conn;
      private $table_name = "products";
      private $id;

      public $p_key;//req
      public $lang;
      public $slug;//req
      public $name; //req
      public $meta; //req
      public $price; //req
      public $images; //req
      public $properties; //req
      public $more_info;
      public $description;
      public $category; //req
  
      public function __construct($db){
          $this->conn = $db;
      }

      function productExists(){

        // query to check if email exists
        $query = "SELECT * FROM " . $this->table_name . "
                WHERE lang=:lang AND p_key=:slug
                LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare( $query );

        $this->slug=htmlspecialchars(strip_tags($this->slug));

        $stmt->bindParam(":lang", $this->lang);
        $stmt->bindParam(":slug", $this->slug);

        $stmt->execute();

        $num = $stmt->rowCount();

        if($num>0) return true;
        else return false;
      }

      function translationExists($key, $lang){

        $query = "SELECT id
                FROM " . $this->table_name . "
                WHERE p_key=:key AND lang=:lang
                LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );

        $this->p_key=htmlspecialchars(strip_tags($key));
        $this->lang=htmlspecialchars(strip_tags($lang));

        $stmt->bindParam(":key", $key);
        $stmt->bindParam(":lang", $lang);
        $stmt->execute();

        $num = $stmt->rowCount();

        if($num>0){
            return true;
        }
        return false;
      }

      function creatable(){
        $ret = 'php - ебучая говнина';
        if(strlen(preg_replace('/\s+/u','',$this->name)) == 0) return 'name empty';
        if(strlen(preg_replace('/[^0-9]/','',$this->price)) == 0) return 'price empty';
        // if(strlen(preg_replace('/\s+/u','',$this->images)) == 0) return 'image empty';
        if(strlen(preg_replace('/\s+/u','',$this->properties)) == 0) return 'properties empty';
        if(strlen(preg_replace('/\s+/u','',$this->category)) == 0) return 'category empty';
        return $ret;
      }

      function create(){

        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                  SET
                    p_key=:key,
                    lang=:lang,
                    slug=:slug,
                    name=:name,
                    meta=:meta,
                    price=:price,
                    images=:images,
                    properties=:properties,
                    more_info=:more_info,
                    description=:description,
                    category=:category";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->p_key=htmlspecialchars(strip_tags($this->p_key));
        $this->lang=htmlspecialchars(strip_tags($this->lang));
        $this->slug=htmlspecialchars(strip_tags($this->slug));
        $this->name=htmlspecialchars(strip_tags($this->name));
        // $this->meta=htmlspecialchars(strip_tags($this->meta));
        $this->price=(int) htmlspecialchars(strip_tags($this->price));
        // $this->images=htmlspecialchars(strip_tags($this->images));
        $this->properties=htmlspecialchars(strip_tags($this->properties));
        $this->more_info=htmlspecialchars(strip_tags($this->more_info));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category=htmlspecialchars(strip_tags($this->category));

        // bind values
        $stmt->bindParam(":key", $this->p_key);
        $stmt->bindParam(":lang", $this->lang);
        $stmt->bindParam(":slug", $this->slug);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":meta", $this->meta);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":images", $this->images);
        $stmt->bindParam(":properties", $this->properties);
        $stmt->bindParam(":more_info", $this->more_info);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category", $this->category);



        // var_dump($stmt->debugDumpParams());


        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

      }

      function update($id){

        $query = "UPDATE
                      " . $this->table_name . "
                    SET
                      slug=:slug,
                      name=:name,
                      meta=:meta,
                      price=:price,
                      images=:images,
                      properties=:properties,
                      more_info=:more_info,
                      description=:description,
                      category=:category
                    WHERE
                      id=:id";

        $stmt = $this->conn->prepare($query);

        // // bind values
        $stmt->bindParam(":slug", $this->slug);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":meta", $this->meta);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":images", $this->images);
        $stmt->bindParam(":properties", $this->properties);
        $stmt->bindParam(":more_info", $this->more_info);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":id", $id);

        if($stmt->execute()){
          return true;
        }else{
          return false;
        }
	    }

      function updateImages() {
         //change images for all locales
         $query = "UPDATE " . $this->table_name . "
                  SET
                    images=:images 
                  WHERE
                    p_key=:p_key";

          $stmt = $this->conn->prepare($query);

          // // bind values
          $stmt->bindParam(":p_key", $this->p_key);
          $stmt->bindParam(":images", $this->images);

          $stmt->execute();
      }

      function addImagesToProducts($p_key, $image) {

        $query = "SELECT images
                  FROM " . $this->table_name . "
                  WHERE p_key=:p_key
                  LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":p_key", $p_key);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row['images'] == NULL) {

          $query = "UPDATE
                      " . $this->table_name . "
                    SET
                      images=:images
                    WHERE
                      p_key=:p_key";

          $stmt = $this->conn->prepare($query);

          $image = $image . ' ';

          // // bind values
          $stmt->bindParam(":p_key", $p_key);
          $stmt->bindParam(":images", $image);

          $stmt->execute();

        }
        else {

          $query = "UPDATE
                    " . $this->table_name . "
                  SET
                    images=CONCAT(images,:images) 
                  WHERE
                    p_key=:p_key";

          $stmt = $this->conn->prepare($query);

          $image = $image . ' ';

          // // bind values
          $stmt->bindParam(":p_key", $p_key);
          $stmt->bindParam(":images", $image);

          $stmt->execute();

        }
      }

      function updateKey(){
        $query = "UPDATE " . $this->table_name . "
                  SET
                    p_key=:n_key
                  WHERE
                    p_key=:p_key";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":n_key", $this->slug);
        $stmt->bindParam(":p_key", $this->p_key);

        $stmt->execute();
      }

      function readAllFrom($from_record_num, $records_per_page){

        $query = "SELECT
							*
						FROM
							" . $this->table_name . "
						WHERE
							lang = '" . BASELOCALE . "'
						ORDER BY
							name ASC
						LIMIT
							{$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
		  }

      function readAll($lang){

        $query = "SELECT
								*
							FROM
								" . $this->table_name . "
							WHERE lang = '" .$lang. "'
							ORDER BY
								name ASC";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt->fetchAll();
      }

      function getByID($id){

        $query = "SELECT
                    `slug`, 
                    `name`,
                    `meta`,
                    `price`, 
                    `images`, 
                    `properties`, 
                    `more_info`, 
                    `description`, 
                    `category`
                FROM
                    " . $this->table_name . "
                WHERE
                    id=:id";
  
        $stmt = $this->conn->prepare( $query );
  
        // bind given email value
        $stmt->bindParam(":id", $id);
        
  
        $stmt->execute();
        
  
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
          
        if($row) {
          //$this->id = $row['id'];
          //$this->collection_number_local = $row['collection_number_local'];
          $this->slug = $row['slug'];
          $this->name = $row['name'];
          $this->meta = $row['meta'];
          $this->price = $row['price'];
          $this->images = $row['images'];
          $this->properties = $row['properties'];
          $this->more_info = $row['more_info'];
          $this->description = $row['description'];
          $this->category = $row['category'];
  
        }
      }

      function getBySlug($slug, $lang){

        $query = "SELECT
                    `id`,
                    `p_key`,
                    `slug`, 
                    `name`,
                    `meta`,
                    `price`, 
                    `images`, 
                    `properties`, 
                    `more_info`, 
                    `description`, 
                    `category`
                FROM
                    " . $this->table_name . "
                WHERE
                    slug=:slug AND lang=:lang";
  
        $stmt = $this->conn->prepare( $query );
  
        // bind given email value
        $stmt->bindParam(":slug", $slug);
        $stmt->bindParam(":lang", $lang);
  
        $stmt->execute();
        // var_dump($stmt);
  
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
          $this->id = $row['id'];
          $this->p_key = $row['p_key'];
          $this->slug = $row['slug'];
          $this->name = $row['name'];
          $this->meta = $row['meta'];
          $this->price = $row['price'];
          $this->images = $row['images'];
          $this->properties = $row['properties'];
          $this->more_info = $row['more_info'];
          $this->description = $row['description'];
          $this->category = $row['category'];
  
        }
      }

      function getByKey(){
        $query = "SELECT *
                  FROM " . $this->table_name . "
                  WHERE p_key=:key
                  LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":key", $this->p_key);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
          $this->price = $row['price'];
          $this->images = $row['images'];
          $this->category = $row['category'];
        }
      }

      function getAllByKey(){
        $query = "SELECT `lang`, `slug`
                  FROM " . $this->table_name . "
                  WHERE p_key=:p_key";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":p_key", $this->p_key);

        $stmt->execute();

        return $stmt->fetchAll();
        // return $this->p_key;
      }

      function getByKeyAndLang($key, $lang){
        $query = "SELECT *
                  FROM " . $this->table_name . "
                  WHERE p_key=:key AND lang=:lang
                  LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":key", $key);
        $stmt->bindParam(":lang", $lang);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
          $this->id = $row['id'];
          $this->p_key = $row['p_key'];
          $this->slug = $row['slug'];
          $this->lang = $row['lang'];
          $this->name = $row['name'];
          $this->meta = $row['meta'];
          $this->price = $row['price'];
          $this->images = $row['images'];
          $this->properties = $row['properties'];
          $this->more_info = $row['more_info'];
          $this->description = $row['description'];
          $this->category = $row['category'];
        }
      }

      function getIDbyKeyAndLang(){

        $query = "SELECT id
                  FROM " . $this->table_name . "
                  WHERE p_key=:p_key AND lang=:lang
                  LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":p_key", $this->p_key);
        $stmt->bindParam(":lang", $this->lang);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['id'];
      }

      function getAllByCategoryAndLang() {

        $query = "SELECT *
                  FROM " . $this->table_name . "
                  WHERE category=:category AND lang=:lang";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":lang", $this->lang);

        $stmt->execute();

        return $stmt->fetchAll();
      }

      function getID(){
        return $row['id'];
      }
    }

?>