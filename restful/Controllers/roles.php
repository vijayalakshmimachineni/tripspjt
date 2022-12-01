<?php
/* messages */
$app->post('/roles','getRoles');
$app->post('/roles/getadminroles','getAdminRoles');
$app->post('/addrole', 'addrole');
$app->post('/editrole/:role_id', 'editrole');
$app->delete('/deleterole/:role_id/:user_id/:apiKey','deleterole');
$app->get('/roles/getmodules','getModules');
$app->post('/roles/getprivileges','getPrivileges');
$app->post('/roles/accesspages','accessPages');
$app->post('/roles/checkrolename', 'checkRoleName');
$app->get('/roles/getbusinessroles','getBusinessroles');
$app->get('/roles/getcustomerroles','getCustomerroles');

function getRoles() {
  $request = \Slim\Slim::getInstance()->request();
  $update = json_decode($request->getBody());
  $apiKey = $update->apiKey;
  $sever_apiKey = apiKey($update->user_id);
	$sql = "SELECT * FROM ".DB_PREFIX."user_roles";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);  
    //$stmt->bindParam(":branch_id", $update->branch_id);
    $stmt->execute();
		$roles = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"roles": ' . json_encode($roles) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getAdminRoles() {
	try {
		$request = \Slim\Slim::getInstance()->request();
	  $update = json_decode($request->getBody());
	  $apiKey = $update->apiKey;
	  $sever_apiKey = apiKey($update->user_id);
		$sql = "SELECT * FROM ".DB_PREFIX."user_roles WHERE role_id IN(1,2)";	
		$db = getDB();
		$stmt = $db->prepare($sql);  
    $stmt->execute();
		$roles = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"roles": ' . json_encode($roles) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function addrole() {
	$request = \Slim\Slim::getInstance()->request();
	$update = json_decode($request->getBody());
	$apiKey = $update->apiKey;
	$sever_apiKey = apiKey($update->user_id);
	$sql = "INSERT INTO ".DB_PREFIX."user_roles (role_name, created_date, created_by, 	role_status) 
			VALUES (:role_name, :created_date, :created_by, :role_status)";
	try {
	  if($apiKey == $sever_apiKey) { 
	  	$update->role_status = '0';
			$db = getDB();
			$stmt = $db->prepare($sql);  
			$stmt->bindParam(":role_name", $update->role_name);
			$stmt->bindParam(":created_date", $update->created_date);
			$stmt->bindParam(":created_by", $update->created_by);
			$stmt->bindParam(":role_status", $update->role_status);
			$stmt->execute();
			$update->id = $db->lastInsertId();
			//privileges
			$privilege_status = '1';
			$sql = "INSERT INTO ".DB_PREFIX."privileges (role_id, privilege_status, created_date, created_by) VALUES(:role_id, :privilege_status, :created_date, :created_by)";
			$stmt = $db->prepare($sql);  
			$stmt->bindParam(":role_id", $update->id);
			$stmt->bindParam(":privilege_status", $privilege_status);
			$stmt->bindParam(":created_date", $update->created_date);
			$stmt->bindParam(":created_by", $update->created_by);
			$stmt->execute();
			$db = null;
			echo $update_id = $update->id;
	  }
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function editrole($role_id) {
	$request = \Slim\Slim::getInstance()->request();	
	$update = json_decode($request->getBody());
	$apiKey = $update->apiKey;
	$sever_apiKey = apiKey($update->user_id);
	$sql = "UPDATE ".DB_PREFIX."user_roles SET role_name=:role_name 
			WHERE role_id = :role_id";
	try {
		if($apiKey == $sever_apiKey) {
			$db = getDB();
			$stmt = $db->prepare($sql);  
			$stmt->bindParam(":role_name", $update->role_name);
			$stmt->bindParam(":role_id", $update->role_id);
			$stmt->execute();
			$update->id = $db->lastInsertId();
			$db = null;
			echo $update_id = $update->role_id;
	    }
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function deleterole($role_id, $user_id, $apiKey) {
  $sever_apiKey = apiKey($user_id);
	$sql = "UPDATE ".DB_PREFIX."user_roles SET status='9' WHERE role_id=:role_id";
	try {
		if($apiKey == $sever_apiKey) {
			$db = getDB();
			$stmt = $db->prepare($sql);  
			$stmt->bindParam(":role_id", $role_id);
			$stmt->execute();
			$db = null;
			echo true;
	  }
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}	
}

function getModules() {
	$sql = "SELECT module_id, module_name, parent_id, module_slug 
	FROM ".DB_PREFIX."modules ORDER BY module_name ASC";
	try {
		$db = getDB();
		$stmt = $db->query($sql);  
		$modules = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"modules": ' . json_encode($modules) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getPrivileges() {
	$request = \Slim\Slim::getInstance()->request();	
	$update = json_decode($request->getBody());
	$sql = "SELECT * 
	FROM ".DB_PREFIX."privileges WHERE role_id=:role_id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':role_id',$update->role_id);  
		$stmt->execute();
		$modules = $stmt->fetch(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($modules);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function accesspages() {
	$request = \Slim\Slim::getInstance()->request();	
	$update = json_decode($request->getBody());
	$apiKey = $update->apiKey;
	$sever_apiKey = apiKey($update->user_id);	
	try {
		if($apiKey == $sever_apiKey) {
			$sql = "SELECT * FROM ".DB_PREFIX."privileges WHERE role_id=:role_id";
			$db = getDB();
			$stmt = $db->prepare($sql);  
			$stmt->bindParam(":role_id", $update->role_id);
			$stmt->execute();
			$modules = $stmt->fetch(PDO::FETCH_OBJ);
			$privilege_name = $update->privilege_name;
			if($update->status == 'y') {
				if(!empty($modules)) {
					$data = array();
          $data[$privilege_name] = ($modules->$privilege_name != '') ? $modules->$privilege_name . ',' .$update->module_id : $update->module_id;            
          $up_sql = "UPDATE ".DB_PREFIX."privileges SET `".$privilege_name."`='".$data[$privilege_name]."'
          WHERE role_id=".$update->role_id;
          $up_stmt = $db->prepare($up_sql);  					
					$res = $up_stmt->execute();          
				}
				else {
					$data = array();
					$privilege_status = '1';
          $up_sql = "INSERT INTO ".DB_PREFIX."privileges 
          (role_id, `".$privilege_name."`, privilege_status, created_date, created_by)
          VALUES (:role_id, :module_id, :privilege_status, :created_date, :created_by)";
          $up_stmt = $db->prepare($up_sql);  
					$up_stmt->bindParam(":role_id", $update->role_id);
					$up_stmt->bindParam(":module_id", $update->module_id);	
					$up_stmt->bindParam(":privilege_status", $privilege_status);
					$up_stmt->bindParam(":created_date", $update->created_date);	
					$up_stmt->bindParam(":created_by", $update->created_by);						
					$res = $up_stmt->execute();        
				}
			}
			else {
				$values = explode(',', $modules->$privilege_name);
        $slugArray = array($update->module_id);
        $newValues = array_diff( $values, $slugArray);
        $data = array();
        $data[$privilege_name] = implode($newValues, ',');
        $up_sql = "UPDATE ".DB_PREFIX."privileges SET `".$privilege_name."`='".$data[$privilege_name]."'
        WHERE role_id=".$update->role_id;
        $up_stmt = $db->prepare($up_sql);  					
				$res = $up_stmt->execute(); 
			}
			$db = null;
			echo $res;
	    }
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function checkRoleName() {
	try{
		$request = \Slim\Slim::getInstance()->request();
		$update = json_decode($request->getBody());
		$sql="SELECT count(*) as role_count FROM ".DB_PREFIX."user_roles WHERE role_name=:role_name AND role_status!='9'";
		$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("role_name", $update->role_name);  
    $stmt->execute();
		$roles = $stmt->fetch(PDO::FETCH_OBJ);
		echo json_encode($roles->role_count);
		$db = null;		
	}catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  } 
}

function getBusinessroles() {
	try {	
		$sql = "SELECT * FROM ".DB_PREFIX."user_roles WHERE role_id IN(5)";	
		$db = getDB();
		$stmt = $db->prepare($sql);  
    $stmt->execute();
		$roles = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"roles": ' . json_encode($roles) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getCustomerroles() {
	try {		
		$sql = "SELECT * FROM ".DB_PREFIX."user_roles WHERE role_id IN(7)";	
		$db = getDB();
		$stmt = $db->prepare($sql);  
    $stmt->execute();
		$roles = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"roles": ' . json_encode($roles) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

?>