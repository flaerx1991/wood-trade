
<?php

	require __DIR__ .'/../../vendor/autoload.php';

	class News {

		// database connection and table name
    	private $conn;
    	private $table_name = "news";
    	public $locale;
	    public $slug;
			public $identifier;
      public $title;
	    public $data;
      public $img = null;

    	// constructor
	    public function __construct($db){
	        $this->conn = $db;
	    }

			public function getAll() {

				$query = "SELECT identifier, title
									FROM	" . $this->table_name ."
									WHERE locale = '" . BASELOCALE ."'";

				//var_dump($query);
				$stmt = $this->conn->prepare($query);
				$stmt->execute();
				$result = $stmt->fetchAll();
				return $result;

			}

			// create page
	    function create(){

	        //write query
	        $query = "INSERT INTO
	                    " . $this->table_name . "
	                SET
	                    identifier=:identifier, slug=:slug, locale=:locale, title=:title, created=:created";

	        $stmt = $this->conn->prepare($query);

	        // posted values
	        $this->identifier=htmlspecialchars(strip_tags($this->identifier));
	        $this->locale=htmlspecialchars(strip_tags($this->locale));
	        $this->slug=htmlspecialchars(strip_tags($this->slug));
	        $this->title=htmlspecialchars(strip_tags($this->title));

	        // to get time-stamp for 'created' field
	        $this->timestamp = date('Y-m-d H:i:s');

	        // bind values
	        $stmt->bindParam(":identifier", $this->identifier);
	        $stmt->bindParam(":locale", $this->locale);
	        $stmt->bindParam(":slug", $this->slug);
	        $stmt->bindParam(":title", $this->title);
	        $stmt->bindParam(":created", $this->timestamp);

	        if($stmt->execute()){
	            return true;
	        }else{
	            return false;
	        }

	    }

			function newsExists(){

	        // query to check if email exists
	        $query = "SELECT slug, locale
	                FROM " . $this->table_name . "
	                WHERE slug = :slug AND locale =:locale
	                LIMIT 0,1";

	        // prepare the query
	        $stmt = $this->conn->prepare( $query );

	        // sanitize
	        $this->slug=htmlspecialchars(strip_tags($this->slug));
	        $this->locale=htmlspecialchars(strip_tags($this->locale));

	        // bind given email value
	        $stmt->bindParam(":slug", $this->slug);
	        $stmt->bindParam(":locale", $this->locale);

	        // execute the query
	        $stmt->execute();

	        // get number of rows
	        $num = $stmt->rowCount();

	        // if email exists, assign values to object properties for easy access and use for php sessions
	        if($num>0){
	            return true;
	        }

	        return false;
	    }

			public function getDefaultHead()
			{
				//$file = $_SERVER['DOCUMENT_ROOT']."/templates/".$twigTemplateName.".twig";
				$loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/layouts');
			    // $loader->addPath($_SERVER['DOCUMENT_ROOT'].'/layouts', 'layouts');
			    // $loader->addPath($_SERVER['DOCUMENT_ROOT'].'/libs/js', 'js');
			    // $loader->addPath($_SERVER['DOCUMENT_ROOT'].'/libs/js/particles', 'particles');
			    // $loader->addPath($_SERVER['DOCUMENT_ROOT'].'/libs/css', 'css');

			    $twig = new \Twig\Environment($loader);
			    $source = $twig->getLoader()->getSourceContext('header.twig');
			    $tokens = $twig->tokenize($source);
			    $parsed = $twig->parse($tokens);
			    $collected = [];
			    $this->collectNodes($parsed, $collected);

			    return array_keys($collected);
			}

			private function collectNodes($nodes, array &$collected)
			{
			    foreach ($nodes as $node) {
			        $childNodes = $node->getIterator()->getArrayCopy();
			        if (!empty($childNodes)) {
			            $this->collectNodes($childNodes, $collected); // recursion
			        } elseif ($node instanceof \Twig_Node_Expression_Name) {
			            $name = $node->getAttribute('name');
			            $collected[$name] = $node; // ensure unique values
			        }
			    }
			}

			function getDataByIdentifierLocale($identifier, $locale)
			{
			    $query = "SELECT
			                *
			            FROM
			                " . $this->table_name . "
			            WHERE
			                locale=:locale AND identifier=:identifier
						";

			    	$stmt = $this->conn->prepare( $query );

			    // sanitize
		        $this->identifier=htmlspecialchars(strip_tags($this->identifier));
		        $this->locale=htmlspecialchars(strip_tags($this->locale));

		        // bind given email value
		        $stmt->bindParam(":identifier", $this->identifier);
		        $stmt->bindParam(":locale", $this->locale);

			    	$stmt->execute();

			    	$row = $stmt->fetch(PDO::FETCH_ASSOC);

				  	if(isset($row))
						{
					    $this->slug = $row['slug'];
				      $this->title = $row['title'];
					    $this->data = $row['data'];
				      $this->image = $row['image'];
						}
				}


  }
?>
