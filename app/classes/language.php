<?php

	require __DIR__ .'/../../vendor/autoload.php';

	class Language {

		// database connection and table name
    	private $conn;
    	private $table_name = "languages";
    	public $id;
	    public $slug;
	    public $name;
		//public $icon;

    	// constructor
	    public function __construct($db){
	        $this->conn = $db;
	    }

	    function getAll(){

		    $query = "SELECT
		                *
		            FROM
		                " . $this->table_name . "
					";

		    $stmt = $this->conn->prepare( $query );

		    $stmt->execute();

		    return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	}

?>