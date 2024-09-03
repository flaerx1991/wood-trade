<?php

	require __DIR__ .'/../../vendor/autoload.php';

	class ProductCategory {

        // database connection and table name
  	    private $conn;
  	    private $table_name = "product_category";

        public $c_key;
        public $lang;
        public $slug;
        public $name;

        public function __construct($db)
  	    {
            $this->conn = $db;
        }

        function productCategoryExists() {

            // query to check if email exists
            $query = "SELECT slug
                    FROM " . $this->table_name . "
                    WHERE 
                    slug=:slug 
                    AND 
                    c_key=:slug 
                    LIMIT 0,1";

            // prepare the query
            $stmt = $this->conn->prepare( $query );

            $this->slug=htmlspecialchars(strip_tags($this->slug));

            $stmt->bindParam(":slug", $this->slug);
            $stmt->bindParam(":c_key", $this->slug);

            $stmt->execute();

            $num = $stmt->rowCount();

            if($num>0) return true;
            else return false;
        }

        function translationExists($key, $lang) {

            $query = "SELECT slug
                      FROM " . $this->table_name . "
                      WHERE c_key=:c_key 
                            AND
                            lang=:lang
                      LIMIT 0,1";

            $stmt = $this->conn->prepare( $query );

            $stmt->bindParam(":c_key", $key);
            $stmt->bindParam(":lang", $lang);

            $stmt->execute();

            $num = $stmt->rowCount();

            if($num>0) return true;
            else return false;
        }

        function create(){

            //write query
            $query = "INSERT INTO
                        " . $this->table_name . "
                      SET
                        c_key=:c_key,
                        lang=:lang,
                        slug=:slug,
                        name=:name
                      ";

            $stmt = $this->conn->prepare($query);

            // posted values
            $this->c_key=htmlspecialchars(strip_tags($this->c_key));
            $this->lang=htmlspecialchars(strip_tags($this->lang));
            $this->slug=htmlspecialchars(strip_tags($this->slug));
            $this->name=htmlspecialchars(strip_tags($this->name));

            // bind values
            $stmt->bindParam(":c_key", $this->c_key);
            $stmt->bindParam(":lang", $this->lang);
            $stmt->bindParam(":slug", $this->slug);
            $stmt->bindParam(":name", $this->name);

            //var_dump($stmt);


            if($stmt->execute()){
                return true;
            }else{
                return false;
            }

        }

        function getByKeyAndLang() {
            $query = "SELECT name
                      FROM " . $this->table_name . "
                      WHERE c_key=:c_key 
                            AND
                            lang=:lang
                      LIMIT 0,1";

            $stmt = $this->conn->prepare( $query );

            $stmt->bindParam(":c_key", $this->c_key);
            $stmt->bindParam(":lang", $this->lang);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->name = $row['name'];

            // return $stmt;
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

        function readAll(){

            $query = "SELECT
                        *
                    FROM
                        " . $this->table_name . "
                    ORDER BY
                        name ASC
                    ";
      
            $stmt = $this->conn->prepare( $query );
            $stmt->execute();
      
            return $stmt;
        }

        function readAllByLang() {
            $query = "SELECT
                        *
                    FROM
                        " . $this->table_name . "
                    WHERE
                        lang=:lang
                    ORDER BY
                        name ASC
                    ";

            $stmt = $this->conn->prepare( $query );

            $stmt->bindParam(":lang", $this->lang);

            $stmt->execute();
            
            return $stmt;
        }

        function update($id){

            $query = "UPDATE
                            " . $this->table_name . "
                        SET
                            slug=:slug,
                            name=:name
                        WHERE
                            id=:id";

            $stmt = $this->conn->prepare( $query );

            $stmt->bindParam(":slug", $this->slug);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":id", $id);

            $stmt->execute();

            return true;
      
        }

        function updateKey() {
            $query = "UPDATE " . $this->table_name . "
                  SET
                    c_key=:n_key
                  WHERE
                    c_key=:c_key";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":n_key", $this->slug);
            $stmt->bindParam(":c_key", $this->c_key);

            $stmt->execute();
        }

        function getKeyBySlug() {

            $query = "SELECT
                        `c_key`
                    FROM
                        " . $this->table_name . "
                    WHERE
                        slug=:slug";

            $stmt = $this->conn->prepare( $query );

            $stmt->bindParam(":slug", $this->slug);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['c_key'];
        }

        function getAllSlugsAngLang() {

            $query = "SELECT `lang`, `slug`
                  FROM " . $this->table_name . "
                  WHERE c_key=:c_key";

            $stmt = $this->conn->prepare( $query );

            $stmt->bindParam(":c_key", $this->c_key);

            $stmt->execute();

            return $stmt->fetchAll();
        }

        function getNameBySlugAndLang() {
            
            $query = "SELECT
                        `name`
                    FROM
                        " . $this->table_name . "
                    WHERE
                        slug=:slug AND lang=:lang";

            $stmt = $this->conn->prepare( $query );

            $stmt->bindParam(":slug", $this->slug);
            $stmt->bindParam(":lang", $this->lang);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['name'];
        }

        function getByID($id){

            $query = "SELECT
                        `slug`, `name`
                    FROM
                        " . $this->table_name . "
                    WHERE
                        id=:id";
      
            $stmt = $this->conn->prepare( $query );
      
            // sanitize
            $id=htmlspecialchars(strip_tags($id));
      
            // bind given email value
            $stmt->bindParam(":id", $id);
      
            $stmt->execute();
      
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
            if($row) {
              $this->slug = $row['slug'];
              $this->name = $row['name'];
            }
        }

        function getIDbyKeyAndLang(){

            $query = "SELECT id
                      FROM " . $this->table_name . "
                      WHERE c_key=:c_key AND lang=:lang
                      LIMIT 0,1";
    
            $stmt = $this->conn->prepare( $query );
    
            $stmt->bindParam(":c_key", $this->c_key);
            $stmt->bindParam(":lang", $this->lang);
    
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $row['id'];
          }

    }

?>