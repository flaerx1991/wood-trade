<?php
  
  if($_SERVER['QUERY_STRING'] != '') {
    if (!isset($_SESSION['query'])) $_SESSION['query'] = $_SERVER['QUERY_STRING'];
    else if ($_SESSION['query'] != $_SERVER['QUERY_STRING']) $_SESSION['query'] = $_SERVER['QUERY_STRING'];
  }

  if( !isset($_SESSION['token']) ) {
		$_SESSION['token'] = bin2hex(random_bytes(32));
		$database = new Database();
		$db = $database->getConnection();

		$utm = htmlspecialchars( !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : "/");
		$remote_addr = htmlspecialchars( $_SERVER['REMOTE_ADDR'] );
		$http_client_ip = htmlspecialchars( (!empty( $_SERVER['HTTP_CLIENT_IP']) ) ? $_SERVER['HTTP_CLIENT_IP'] : "-"  ) ;
		$forwrded_for = htmlspecialchars( (!empty( $_SERVER['HTTP_X_FORWARDED_FOR']) ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : "-" );
		$referrer = htmlspecialchars( !empty( $_SERVER['HTTP_REFERER'] ) ?  $_SERVER['HTTP_REFERER'] : "-" );
		$date = date('Y-m-d');
		$time = date('h:i:s');
		$user_agent = htmlspecialchars( $_SERVER['HTTP_USER_AGENT'] );

		// $query = "INSERT INTO visitors
		// 			SET
		// 				query=:utm,
		// 				remote_addr=:remote_addr,
		// 				http_client_ip=:http_client_ip,
		// 				forwrded_for=:forwrded_for,
		// 				referrer=:referrer,
		// 				date=:date,
		// 				time=:time,
		// 				user_agent=:useragent";

		// $stmt = $db->prepare($query);

		// $stmt->bindParam(":utm", $utm);
		// $stmt->bindParam(":remote_addr", $remote_addr);
		// $stmt->bindParam(":http_client_ip", $http_client_ip);
		// $stmt->bindParam(":forwrded_for", $forwrded_for);
		// $stmt->bindParam(":referrer", $referrer);
		// $stmt->bindParam(":date", $date);
		// $stmt->bindParam(":time", $time);
		// $stmt->bindParam(":useragent", $user_agent);

		// $stmt->execute();

		//$arr = $stmt->errorInfo();
		//var_dump($remote_addr);
	}
?>
