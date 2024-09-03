<?php
// 'user' object
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $id;
    public $role_id;
    public $login;
    public $password;
    public $status;
    public $created;
    public $modified;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // check if given email exist in the database
    function loginExists(){
     
        // query to check if email exists
        $query = "SELECT id, role_id, login, password, status
                FROM " . $this->table_name . "
                WHERE login = ?
                LIMIT 0,1";
     
        // prepare the query
        $stmt = $this->conn->prepare( $query );
     
        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->login));
     
        // bind given email value
        $stmt->bindParam(1, $this->login);
     
        // execute the query
        $stmt->execute();
     
        // get number of rows
        $num = $stmt->rowCount();
     
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
     
            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
            // assign values to object properties
            $this->id = $row['id'];
            $this->role_id = $row['role_id'];
            $this->login = $row['login'];
            $this->password = $row['password'];
            $this->status = $row['status'];
     
            // return true because email exists in the database
            return true;
        }
     
        // return false if email does not exist in the database
        return false;
    }

    // create new user record
    function create(){
     
        // to get time stamp for 'created' field
        $this->created=date('Y-m-d H:i:s');
     
        // insert query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    role_id = :role_id,
                    login = :login,
                    password = :password,
                    status = :status,
                    created = :created";
     
        // prepare the query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->role_id=htmlspecialchars(strip_tags($this->role_id));
        $this->login=htmlspecialchars(strip_tags($this->login));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->status=htmlspecialchars(strip_tags($this->status));
     
        // bind the values
        $stmt->bindParam(':role_id', $this->role_id);
        $stmt->bindParam(':login', $this->login);
     
        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
     
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':created', $this->created);
     
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }
    }

    public function showError($stmt){
        echo "<pre>";
            print_r($stmt->errorInfo());
        echo "</pre>";
    }
}
?>