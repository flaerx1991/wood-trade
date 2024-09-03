<?php
// core configuration
require __DIR__ .'/../../vendor/autoload.php';
 
// set page title
$page_title = "Register";
 
// include login checker
$require_login=false;
 
// include page header HTML
include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";
 
echo "<div class='col-md-12'>";
 
    // if form was posted
	if($_POST){
	 	
	 	var_dump($_POST);

	    // get database connection
	    $database = new Database();
	    $db = $database->getConnection();
	 
	    // initialize objects
	    $user = new User($db);
	    //$utils = new Utils();
	 
	    // set user email to detect if it already exists
	    $user->login=$_POST['login'];
	 	
	 	//var_dump($user);

	    // check if email already exists
	    if($user->loginExists()){
	        echo "<div class='alert alert-danger'>";
	            echo "The login you specified is already registered.";
	        echo "</div>";
	    }
	 
	    else{
	        // set values to object properties
			$user->login=$_POST['login'];
			$user->role_id=0;
			$user->password=$_POST['password'];
			$user->status=0;
			 
			// create the user
			if($user->create()){
			 
			    echo "<div class='alert alert-info'>";
			        echo "Successfully registered.";
			    echo "</div>";
			 
			    // empty posted values
			    $_POST=array();
			 
			}else{
			    echo "<div class='alert alert-danger' role='alert'>Unable to register. Please try again.</div>";
			}
	    }
	}
?>
<form action='register' method='post' id='register'>
 
    <table class='table table-responsive'>
 
        <tr>
            <td class='width-30-percent'>Login</td>
            <td><input type='text' name='login' class='form-control' required value="<?php echo isset($_POST['login']) ? htmlspecialchars($_POST['login'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>
  
        <tr>
            <td>Password</td>
            <td><input type='password' name='password' class='form-control' required id='passwordInput'></td>
        </tr>
 
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span> Register
                </button>
            </td>
        </tr>
 
    </table>
</form>

<?php
 
echo "</div>";
 
// include page footer HTML
include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";

?>