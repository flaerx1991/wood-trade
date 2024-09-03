<?php
	// core configuration
	include_once $_SERVER['DOCUMENT_ROOT']."/config/core.php";

	// set page title
	$page_title = "Login";


	$require_login=false;

	// default to false
	$access_denied=false;

	// if the login form was submitted
	if($_POST){
	    // include classes
		include_once $_SERVER['DOCUMENT_ROOT']."/config/db.php";
		include_once $_SERVER['DOCUMENT_ROOT']."/admin/objects/user.php";

		// get database connection
		$database = new Database();
		$db = $database->getConnection();

		// initialize objects
		$user = new User($db);

		// check if email and password are in the database
		$user->login=$_POST['login'];

		// check if email exists, also get user details using this emailExists() method
		$login_exists = $user->loginExists();
		// validate login
		if ($login_exists && password_verify($_POST['password'], $user->password) && $user->status==1){

		 	// var_dump($login_exists);
		    // if it is, set the session value to true
		    $_SESSION['logged_in'] = true;
		    $_SESSION['user_id'] = $user->id;
		    $_SESSION['role_id'] = $user->role_id;
		    $_SESSION['login'] = htmlspecialchars($user->login, ENT_QUOTES, 'UTF-8') ;

		    // // if access level is 'Admin', redirect to admin section
		    // if($user->access_level=='Admin'){
		    //     header("Location: {$home_url}admin/index.php?action=login_success");
		    // }

		    // // else, redirect only to 'Customer' section
		    // else{
		    //     header("Location: {$home_url}index.php?action=login_success");
		    // }

		    header("Location: ".HOME_URL."admin");

		}

		//if username does not exist or password is wrong
		else{
		    $access_denied=true;
		}
	}

	// include page header HTML
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/header.php";

	echo "<div class='col-sm-6 col-md-4 col-md-offset-4'>";

	    // alert messages will be here

	    // actual HTML login form
	    echo "<div class='account-wall'>";
	        echo "<div id='my-tab-content' class='tab-content'>";
	            echo "<div class='tab-pane active' id='login'>";
	                echo "<img class='profile-img' src='/admin/resources/micro-logo1.png'>";
	                echo "<form class='form-signin' action='login' method='post'>";
	                    echo "<input type='text' name='login' class='form-control' placeholder='Login' required />";
	                    echo "<input type='password' name='password' class='form-control' placeholder='Password' required />";
	                    echo "<input type='submit' class='btn btn-lg btn-primary btn-block' value='Log In' />";
	                echo "</form>";
	            echo "</div>";
	        echo "</div>";
	    echo "</div>";

	echo "</div>";

	// footer HTML and JavaScript codes
	include_once $_SERVER['DOCUMENT_ROOT']."/admin/layouts/footer.php";

?>
