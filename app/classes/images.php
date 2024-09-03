<?php

	require __DIR__ .'/../../vendor/autoload.php';

    class Images{

        // database connection and table name
        private $conn;
        private $table_name = "images";
        private $meta_table_name = "img_meta";
        private $id;

        // main fields
        public $name;
        public $path;

        // meta fields
        public $img_id;
        public $product_key;
        public $meta;
        public $lang;
 
        public function __construct($db){
            $this->conn = $db;
        }

        function nameExist() {
            $query = "SELECT * FROM " . $this->table_name . "
                        WHERE 
                            name=:name";

            $stmt = $this->conn->prepare($query);

            $this->name=htmlspecialchars(strip_tags($this->name));

            $stmt->bindParam(':name', $this->name);

            $stmt->execute();

            $num = $stmt->rowCount();

            if($num > 0) { return true; }
            else{ return false; }
        }

        function metaExist($id) {
            $query = "SELECT * FROM " . $this->meta_table_name . "
                        WHERE 
                            lang=:lang AND img_id=:id";

            $stmt = $this->conn->prepare($query);

            $this->lang=htmlspecialchars(strip_tags($this->lang));
            $id=htmlspecialchars(strip_tags($id));

            $stmt->bindParam(':lang', $this->lang);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            $num = $stmt->rowCount();

            if($num > 0){ return true; }
            else{ return false; }
        }

        function sameNameCount() {
            $query = "SELECT * FROM " . $this->table_name . "
                        WHERE 
                            name
                        LIKE :name";

            $stmt = $this->conn->prepare($query);

            $this->name=htmlspecialchars(strip_tags($this->name));

            $name = $this->name.'(%';

            $stmt->bindParam(':name', $name);

            $stmt->execute();

            $num = $stmt->rowCount();

            if($num > 0){
                return (int)$num + 1;
            }
            else{
                $query = "SELECT * FROM " . $this->table_name . "
                        WHERE 
                            name
                        LIKE :name";

                $stmt = $this->conn->prepare($query);

                $name = $this->name;

                $stmt->bindParam(':name', $name);

                $stmt->execute();

                $num = $stmt->rowCount();

                return (int)$num;
            }
            
        }

        function upload() {
            $query = "INSERT INTO
                    " . $this->table_name . "
                  SET
                    name=:name,
                    path=:path";

            $stmt = $this->conn->prepare($query);

            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->path=htmlspecialchars(strip_tags($this->path));

            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":path", $this->path);
            
            $stmt->execute();
        }

        function addProductIDToImage($p_key, $name) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE name=:name";

            $stmt = $this->conn->prepare($query);

            // $name=htmlspecialchars(strip_tags($name));

            $stmt->bindParam(":name", $name);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $products_key = $row['product_key'];

            if($products_key != NULL) {
                $products_key = explode(' ', $products_key);
                $product_key = array_search($p_key, $products_key);

                if($product_key == false) {
                    $query = "UPDATE " . $this->table_name . " SET  product_key=CONCAT(product_key, :product_key) WHERE name=:name";

                    $p_key = $p_key." ";

                    $stmt = $this->conn->prepare($query);

                    $stmt->bindParam(":name", $name);
                    $stmt->bindParam(":product_key", $p_key);

                    $stmt->execute();
                }
            }
            else {
                $query = "UPDATE " . $this->table_name . " SET  product_key=:product_key WHERE name=:name";

                $p_key = $p_key." ";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":product_key", $p_key);

                $stmt->execute();
            }
        }

        function deleteImage() {
            $query = "DELETE FROM " . $this->table_name . "  WHERE name=:name";

            $stmt = $this->conn->prepare($query);

            $this->name=htmlspecialchars(strip_tags($this->name));

            $stmt->bindParam(":name", $this->name);

            $stmt->execute();
        }

        function changeImageName($name) {
            $query = "UPDATE " . $this->table_name . "
                        SET 
                            name=:name
                        WHERE
                            name=:oldName";

            $stmt = $this->conn->prepare($query);

            $name=htmlspecialchars(strip_tags($name));
            $this->name=htmlspecialchars(strip_tags($this->name));

            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":oldName", $name);

            if( $stmt->execute() ) { return true; }
            else { return false; }
        }

        function getAllImages() {
            $query = "SELECT * FROM " . $this->table_name . "
                        ORDER BY
                            name ASC";

            $stmt = $this->conn->prepare( $query );
            $stmt->execute();
    
            return $stmt;
        }

        function createMeta() {
            $query = "INSERT INTO
                    " . $this->meta_table_name . "
                  SET
                    img_id=:img_id,
                    meta=:meta,
                    lang=:lang";

            $stmt = $this->conn->prepare($query);

            $this->img_id=htmlspecialchars(strip_tags($this->img_id));
            $this->lang=htmlspecialchars(strip_tags($this->lang));

            $stmt->bindParam(":img_id", $this->img_id);
            $stmt->bindParam(":meta", $this->meta);
            $stmt->bindParam(":lang", $this->lang);
            
            $stmt->execute();
        }

        function updateMeta() {
            $query = "UPDATE " . $this->meta_table_name . "
                        SET 
                            meta=:meta
                        WHERE
                            img_id=:img_id AND lang=:lang";

            $stmt = $this->conn->prepare($query);

            $this->img_id=htmlspecialchars(strip_tags($this->img_id));
            $this->lang=htmlspecialchars(strip_tags($this->lang));

            $stmt->bindParam(":img_id", $this->img_id);
            $stmt->bindParam(":meta", $this->meta);
            $stmt->bindParam(":lang", $this->lang);

            $stmt->execute();
        }

        function deleteMeta($id) {
            $query = "DELETE FROM " . $this->meta_table_name . "
                        WHERE
                            img_id=:id";

            $stmt = $this->conn->prepare($query);

            $id=htmlspecialchars(strip_tags($id));

            $stmt->bindParam(":id", $id);

            $stmt->execute();
        }

        function getMetaByIDAndLang() {
            $query = "SELECT meta FROM " . $this->meta_table_name . "
                        WHERE
                            img_id=:img_id AND lang=:lang
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($query);

            $this->img_id=htmlspecialchars(strip_tags($this->img_id));
            $this->lang=htmlspecialchars(strip_tags($this->lang));

            $stmt->bindParam(":img_id", $this->img_id);
            $stmt->bindParam(":lang", $this->lang);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['meta'];
        }

        function getIDByName() {
            $query = "SELECT id FROM " . $this->table_name . "
                        WHERE
                            name=:name
                        LIMIT 0,1";

            $stmt = $this->conn->prepare( $query );

            $this->name=htmlspecialchars(strip_tags($this->name));

            $stmt->bindParam(":name", $this->name);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['id'];
        }

        function getPathByName() {
            $query = "SELECT path FROM " . $this->table_name . "
                        WHERE
                            name=:name
                        LIMIT 0,1";

            $stmt = $this->conn->prepare( $query );

            $this->name=htmlspecialchars(strip_tags($this->name));

            $stmt->bindParam(":name", $this->name);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $row['path'];
        }

        function getImageByName($name) {
            $query = "SELECT * FROM " . $this->table_name . "
                        WHERE
                            name=:name
                        LIMIT 0,1";

            $stmt = $this->conn->prepare( $query );

            $name=htmlspecialchars(strip_tags($name));

            $stmt->bindParam(":name", $name);

            $stmt->execute();
            
            return $stmt;
        }

        function getPKeysByName() {
            $query = "SELECT product_key FROM " . $this->table_name . "
                        WHERE
                            name=:name
                        LIMIT 0,1";

            $stmt = $this->conn->prepare( $query );

            $this->name=htmlspecialchars(strip_tags($this->name));

            $stmt->bindParam(":name", $this->name);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['product_key'];
        }

        function getImageMeta() {

        }

    }

?>