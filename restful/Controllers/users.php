<?php
/* users */ 
$app->post('/users/checklogin','checkLogin');
$app->post('/users/checklock', 'checkLock');
$app->get('/users/getusers','getUsers');
$app->post('/users/adduser', 'addUser');
$app->post('/users/edituser', 'editUser');
$app->delete('/users/deleteuser/:user/:user_id/:apiKey','deleteUser');
$app->get('/users/checkusername/:user_name','checkusername');
$app->get('/users/checkuseremail/:user_email','checkuseremail');
$app->get('/users/getuserdetails/:user_id','getUserDetails');
$app->post('/users/checkpassword', 'checkPassword');
$app->post('/users/updatepassword', 'updatePassword');
$app->post('/users/addsubscribers','addSubscribers');
$app->get('/users/getbusinessusers','getBusinessUsers');
$app->get('/users/getcustomers','getCustomers');
$app->post('/users/checkmasterlogin','checkMasterLogin');


function checkLogin() {
	try{
		$request = \Slim\Slim::getInstance()->request();
		$update = json_decode($request->getBody());
		$passwordEn = "AES_ENCRYPT('".$update->password."','".$update->PASSKEY."')";
	  $sql = "CALL `check_login` ('".$update->user_name."',".$passwordEn.",@p2,@p3,@p4)";
	  $db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$users = $db->query("SELECT @p2 AS `p_result`, @p3 AS `p_userid`, @p4 AS `p_role_id`;")->fetch(PDO::FETCH_OBJ);
		$db = null;
    echo json_encode($users);
  }catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}	  
}
function checkMasterLogin() {
	try{
		$request = \Slim\Slim::getInstance()->request();
		$update = json_decode($request->getBody());
	  	$sql = "CALL `check_login_master` ('".$update->user_name."',@p2,@p3,@p4)";
	  	$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$users = $db->query("SELECT @p2 AS `p_result`, @p3 AS `p_userid`, @p4 AS `p_role_id`")->fetch(PDO::FETCH_OBJ);
		$db = null;
    	echo json_encode($users);
  }catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}	  
}
function checkLock() {
  try{
    $request = \Slim\Slim::getInstance()->request();
    $update = json_decode($request->getBody());
    $passwordEn = "AES_ENCRYPT('".$update->password."','".$update->PASSKEY."')";
    $sql = "SELECT user_id FROM ".DB_PREFIX."users WHERE user_id=".$update->admin_user." AND user_password=".$passwordEn;
    $db = getDB();
    $stmt = $db->prepare($sql);  
    $stmt->execute();
    $branch = $stmt->fetch(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($branch);
  }catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  } 
}
function getUsers() {
 
	$sql = "SELECT user_id, user_name, user_email, user_status, first_name, last_name  FROM ".DB_PREFIX."user  ORDER BY user_id DESC";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql); 
    $stmt->execute();
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"users": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
function addUser() {
	$request = \Slim\Slim::getInstance()->request();
	// var_dump(($request->getBody()));die();
	$update = json_decode($request->getBody());
	// var_dump($update);die();
	$sql = "CALL `add_user`( :first_name, :login_id, :user_password, :user_email, :user_status, :user_photo, :created_date, :created_by, @result, :pass_key, :last_name)";
	// echo $sql;die;
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		$update->user_photo = '';
		// $stmt->bindParam(":role_id", $update->role_id);
		$stmt->bindParam(":first_name", $update->first_name);
		$stmt->bindParam(":login_id", $update->login_id);
		$stmt->bindParam(":user_password", $update->user_password);
		$stmt->bindParam(":user_email", $update->user_email);
		$stmt->bindParam(":user_status", $update->user_status);
		$stmt->bindParam(":user_photo", $update->user_photo);
		$stmt->bindParam(":created_date", $update->created_date);
		$stmt->bindParam(":created_by", $update->created_by);
		$stmt->bindParam(":pass_key", $update->password_key);
		$stmt->bindParam(":last_name", $update->last_name);
		$stmt->execute();
		$res = $db->query("select @result as result")->fetch(PDO::FETCH_ASSOC);
		$update->id = $res['result'];
		$db = null;
		echo $update_id = json_encode($update->id);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
function editUser() {
	$request = \Slim\Slim::getInstance()->request();
	$update = json_decode($request->getBody());
	$sql = "CALL `update_user`(:role_id, :first_name, :user_email, :user_status, :user_photo, :modified_date, :modified_by, @result, :edit_user_id, :last_name)";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(":role_id", $update->role_id);
		$stmt->bindParam(":first_name", $update->first_name);
		$stmt->bindParam(":last_name", $update->last_name);
    $stmt->bindParam(":user_email", $update->user_email);
		$stmt->bindParam(":user_status", $update->user_status);
		$stmt->bindParam(":user_photo", $update->user_photo);
		$stmt->bindParam(":edit_user_id", $update->edit_user_id);
		$stmt->bindParam(":modified_date", $update->modified_date);
		$stmt->bindParam(":modified_by", $update->modified_by);
		$stmt->execute();
		$res = $db->query("select @result as result")->fetch(PDO::FETCH_ASSOC);
		$update->id = $res['result'];
		$db = null;
		echo json_encode($update->id);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
function deleteUser($user, $user_id, $apiKey) {
  $sever_apiKey = apiKey($user_id);
	$sql = "UPDATE ".DB_PREFIX."users SET user_status='9' WHERE user_id=:user_id";
	try {
		if($apiKey == $sever_apiKey) {
  		$db = getDB();
  		$stmt = $db->prepare($sql);  
  		$stmt->bindParam("user_id", $user);
  		$stmt->execute();
  		$db = null;
  		echo true;
    }
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}	
}
function checkusername($user_name) {
	$sql = "SELECT user_id FROM ".DB_PREFIX."users WHERE login_id=:user_name";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("user_name", $user_name); 
		$stmt->execute();
		$users = $stmt->fetch(PDO::FETCH_OBJ);
		$check = (!empty($users)) ? 1 : 0;
		$db = null;
		echo '{"check": ' . $check . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
function checkuseremail($user_email) {
	$sql = "SELECT user_id FROM ".DB_PREFIX."users WHERE user_email=:user_email";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("user_email", $user_email); 
		$stmt->execute();
		$users = $stmt->fetch(PDO::FETCH_OBJ);
		$check = (!empty($users)) ? 1 : 0;
		$db = null;
		echo '{"check": ' . $check . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
function checkPassword() {
  $request = \Slim\Slim::getInstance()->request();
  $update = json_decode($request->getBody());
  $apiKey = $update->apiKey;
  $sever_apiKey = apiKey($update->user_id);
  $sql = "SELECT user_id FROM ".DB_PREFIX."users WHERE user_id=:user_id AND user_password=AES_ENCRYPT('".$update->old_password."','".$update->pass_key."')";
  try {
    $db = getDB();
    $stmt = $db->prepare($sql);  
    $stmt->bindParam("user_id", $update->login_user_id); 
    $stmt->execute();
    $users = $stmt->fetch(PDO::FETCH_OBJ);
    $check = (!empty($users)) ? 1 : 0;
    $db = null;
    echo '{"check": ' . $check . '}';
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}
function updatePassword() {
  $request = \Slim\Slim::getInstance()->request();
  $update = json_decode($request->getBody());
  $apiKey = $update->apiKey;
  $sever_apiKey = apiKey($update->user_id);
  $sql = "UPDATE ".DB_PREFIX."users SET user_password=AES_ENCRYPT('".$update->new_password."','".$update->pass_key."'),modified_date=:modified_date,modified_by = :modified_by WHERE user_id=:user_id";
  try {
    $db = getDB();
    $stmt = $db->prepare($sql);  
    $stmt->bindParam(":user_id", $update->ch_user_id); 
    $stmt->bindParam(":modified_date", $update->modified_date);
    $stmt->bindParam(":modified_by", $update->modified_by); 
    $res = $stmt->execute();
    
    $db = null;
    echo $update->ch_user_id;
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}
function getUserDetails($user_id) {
	$sql = "SELECT u.user_id, u.user_name, u.user_email, u.user_status,case u.role_id when 5 then (select image from tbl_business b where b.business_id = u.business_id) when 7 then (select c.picture from tbl_crew c where c.crew_id=u.business_id) when 3 then (select picture from tbl_store_employees where emp_id=u.business_id) end as user_photo , u.role_id, u.login_id, u.first_name, u.last_name,u.business_id FROM tbl_users u WHERE u. user_id=:user_id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("user_id", $user_id); 
		$stmt->execute();
		$users = $stmt->fetch(PDO::FETCH_OBJ);
		$db = null;
		echo '{"user": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
function addSubscribers(){
	$request = \Slim\Slim::getInstance()->request();
  $update = json_decode($request->getBody());
	try{
		$sql = "INSERT INTO ".DB_PREFIX."subscribers(subscriber_email,created_date) values(:subscriber_email,:created_date)";
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(":subscriber_email", $update->subscriber_email); 
		$stmt->bindParam(":created_date", $update->created_date);
		$stmt->execute();
		$id = $db->lastInsertId();
		$db = null;
		echo json_encode($id);
  }
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
function  getBusinessUsers() {
	$sql = "SELECT user_id, user_name, user_email, user_status, getRole(role_id) as role_id, first_name, last_name  FROM ".DB_PREFIX."users
  WHERE user_status != '9' AND role_id IN(5) ORDER BY created_date DESC";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql); 
    $stmt->execute();
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"users": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
function getCustomers() {
	$sql = "SELECT user_id, user_name, user_email, user_status, getRole(role_id) as role_id, first_name, last_name  FROM ".DB_PREFIX."users
  WHERE user_status != '9' AND role_id IN(7) ORDER BY created_date DESC";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql); 
    $stmt->execute();
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"users": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

?>