<?php

	require __DIR__ .'/../../vendor/autoload.php';

	class Page {

		// database connection and table name
    	private $conn;
    	private $table_name = "pages";
    	public $id;
	    public $slug;
	    public $lang;
	    public $data;
		public $static;

    	// constructor
	    public function __construct($db){
	        $this->conn = $db;
	    }

	    public function getAll($directory = 'templates') {

	    	$files = array_diff(scandir($directory), array('.', '..'));
			return $files;

		}

		public function getAllVariables($path = null) {

			$file = $_SERVER['DOCUMENT_ROOT']."/templates/".$path.".twig";
			if ( !file_exists( $file ) ) {
				return $file;
			}
			$content = file_get_contents($file);
			preg_match_all('/\{\%\s*([^\%\}]*)\s*\%\}|\{\{\s*([^\}\}]*)\s*\}\}/i', $content, $vars);
			return $vars;

		}


		// create page
    function create(){

        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    slug=:slug, lang=:lang, data=:data, created=:created";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->slug=htmlspecialchars(strip_tags($this->slug));
        $this->lang=htmlspecialchars(strip_tags($this->lang));
        $this->data=$this->data;

        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');

        // bind values
        $stmt->bindParam(":slug", $this->slug);
        $stmt->bindParam(":lang", $this->lang);
        $stmt->bindParam(":data", $this->data);
        $stmt->bindParam(":created", $this->timestamp);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    //update page
    function update(){

    	$query = "UPDATE
              " . $this->table_name . "
            SET
                name = :name,
                price = :price,
                description = :description,
                category_id  = :category_id
            WHERE
                id = :id";

  		$stmt = $this->conn->prepare($query);

        //write query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    data=:data, modified=:modified
                WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        $this->data=$this->data;
  		$this->id=$this->id;
        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');

        // bind values
        $stmt->bindParam(":data", $this->data);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":modified", $this->timestamp);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    function pageExists(){

        // query to check if email exists
        $query = "SELECT id, slug, lang
                FROM " . $this->table_name . "
                WHERE slug = :slug AND lang =:lang
                LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->slug=htmlspecialchars(strip_tags($this->slug));
        $this->lang=htmlspecialchars(strip_tags($this->lang));

        // bind given email value
        $stmt->bindParam(":slug", $this->slug);
        $stmt->bindParam(":lang", $this->lang);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){

            // // get record details / values
            // $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // // assign values to object properties
            // $this->id = $row['id'];
            // $this->email= $row['email'];
            // $this->product_id = $row['product_id'];
            // $this->variant_id = $row['variant_id'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }

	    function translationExists($lang){

	        // query to check if email exists
	        $query = "SELECT id, slug, lang
	                FROM " . $this->table_name . "
	                WHERE slug = :slug AND lang =:lang
	                LIMIT 0,1";

	        // prepare the query
	        $stmt = $this->conn->prepare( $query );

	        // sanitize
	        $this->slug=htmlspecialchars(strip_tags($this->slug));
	        $this->lang=htmlspecialchars(strip_tags($lang));

	        // bind given email value
	        $stmt->bindParam(":slug", $this->slug);
	     	$stmt->bindParam(":lang", $lang);
	        // execute the query
	        $stmt->execute();

	        // get number of rows
	        $num = $stmt->rowCount();

	        // if email exists, assign values to object properties for easy access and use for php sessions
	        if($num>0){
	            // return true because email exists in the database
	            return true;
	        }

	        // return false if email does not exist in the database
	        return false;
	    }


	    function getData(){

		    $query = "SELECT
		                id, data
		            FROM
		                " . $this->table_name . "
		            WHERE
		                slug=:slug AND lang=:lang
					";

		    $stmt = $this->conn->prepare( $query );

		    // sanitize
	        $this->slug=htmlspecialchars(strip_tags($this->slug));
	        $this->lang=htmlspecialchars(strip_tags($this->lang));

	        // bind given email value
	        $stmt->bindParam(":slug", $this->slug);
	        $stmt->bindParam(":lang", $this->lang);

		    $stmt->execute();

		    $row = $stmt->fetch(PDO::FETCH_ASSOC);

		  	if($row) {
		  		$this->id = $row['id'];
		    	$this->data = $row['data'];
				}

		}

		

	}

?>
