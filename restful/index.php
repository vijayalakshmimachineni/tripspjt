<?php

include 'db.php';
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

// use SPREADSHEETWRITER;
require 'routes.php';
// require CONTROLLERPATH.'business.php';
require CONTROLLERPATH.'roles.php';
require CONTROLLERPATH.'users.php';
require CONTROLLERPATH.'students.php';
require 'vendor/autoload.php';





$app->run();
function addContactformdetails() {
  $request = \Slim\Slim::getInstance()->request();
  $update = json_decode($request->getBody());
	$sql = "INSERT INTO ".DB_PREFIX."contact(first_name,last_name,email,mobile_number,message,job,hdykus,created_date,state)values(:first_name,:last_name,:email,:mobile_number,:message,:job,:hdykus,:created_date,:state)";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(":first_name", $update->first_name); 
		$stmt->bindParam(":last_name", $update->last_name);
		$stmt->bindParam(":email", $update->email);  
		$stmt->bindParam(":mobile_number", $update->mobile_number);
		$stmt->bindParam(':job',$update->job);
		$stmt->bindParam(':state',$update->state);
		$stmt->bindParam(':hdykus',$update->hdykus);  
    $stmt->bindParam(":message", $update->message);
    $stmt->bindParam(':created_date',$update->created_date);
		$stmt->execute();
 		$contact_id = $db->lastInsertId();
 		$db = null;
    echo json_encode($contact_id);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
?>