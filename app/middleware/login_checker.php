<?php

	// login checker for 'admin' access level
	 
	// if the session value is empty, he is not yet logged in, redirect him to login page
	if(empty($_SESSION['logged_in'])){

		if(!isset($require_login) || $require_login==true) header("Location: ".HOME_URL."admin/login");
		
	}
	 
	// add access level for roles
	// else if($_SESSION['role']!="ROLE"){
	//     header("Location: {$home_url}login.php?action=not_role");
	// }
	 
	else{
	    // no problem, stay on current page
	}

?>