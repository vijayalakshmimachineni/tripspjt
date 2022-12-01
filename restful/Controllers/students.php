<?php
use PhpOffice\PhpSpreadsheet\Shared\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
	/* messages */
	$app->post('/students/uploadstudents','uploadStudents');
	// $app->post('/students/addParents','addParents');
	// $app->post('/students/addAcademic', 'addAcademic');
	// $app->post('/students/:', 'editrole');

	// use PhpOffice\PhpSpreadsheet\Spreadsheet;
	// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


	function uploadStudents(){

		$request = \Slim\Slim::getInstance()->request();
		// var_dump($request->getBody());die();
		$update = json_decode($request->getBody());
		$excel = new Spreadsheet();
	    $reader = new Xlsx($excel);
		
		 //$reader 	= new Phpoffice\PhpSpreadsheet\Reader\Xlsx();

		$spreadsheet 	= $reader->load(UPLOADPATH.$update->file_name);
		$sheet_data 	= $spreadsheet->getActiveSheet()->toArray(null,true,true,true);
		
			$db = getDB();
		// var_dump(count($sheet_data));die();
		for($i=2; $i <= count($sheet_data); $i++){		
			$student_name = $sheet_data[$i]['B'];
			if($student_name != ''){
				$address = $sheet_data[$i]['I'];
				$course_name = $sheet_data[$i]['C'];
				$section_name = $sheet_data[$i]['D'];
				$sql = "SELECT * FROM ".DB_PREFIX."course WHERE course_name= '".$course_name."'";
				try {		
					$stmt = $db->prepare($sql); 
			    	$stmt->execute();
					$courses = $stmt->fetch(PDO::FETCH_OBJ);
				}catch(PDOException $e) {
					echo '{"error":{"text":'. $e->getMessage() .'}}'; 
				}

				$course_id = $courses->course_id;
				$course_code = $courses->course_code;
				$sql1 = "SELECT count(student_id) AS course_count FROM ".DB_PREFIX."student_academic";
				try {			
					$stmt1 = $db->prepare($sql1); 
			    	$stmt1->execute();
					$course_count = $stmt1->fetch(PDO::FETCH_OBJ);
				}catch(PDOException $e) {
					echo '{"error":{"text":'. $e->getMessage() .'}}'; 
				}

				$sql2 = "SELECT * FROM ".DB_PREFIX."section WHERE course_id = '".$course_id."' AND section_name = '".$section_name."'";
				try {		
					$stmt2 = $db->prepare($sql2); 
			    	$stmt2->execute();
					$sections = $stmt2->fetch(PDO::FETCH_OBJ);
				}catch(PDOException $e) {
					echo '{"error":{"text":'. $e->getMessage() .'}}';
				}
				
				$section_id = $sections->section_id;
				$hid = (int)$course_count->course_count + 1; 
				
				if($hid >= 1 && $hid < 10){
					// echo 'hi';die();
					$hid = '00'.$hid;
				}
				else if($hid >=10 && $hid < 100 ){
					$hid = '0'.$hid;
				}			

				$admission_number = '10'.$course_code.'022'.$hid;
				// echo $admission_number;die;	

				$students = array();
				$students['admission_number'] = $admission_number;
				$students['student_name']	= $student_name;
				$students['present_address']	= $address;
				$students['section_id']	=  $section_id;
				$students['branch_id'] =	1;
				$students['year_id']	=	1;
				$students['course_id']	=	$course_id;
				$students['user_password'] = $admission_number;
				$students['passkey'] = PASSKEY;
				$students['father_name'] = $sheet_data[$i]['E'];
				$students['father_mobile'] = $sheet_data[$i]['F'];
				$students['mother_name'] = $sheet_data[$i]['G'];
				$students['mother_mobile'] = $sheet_data[$i]['H'];
				$students['password'] = 'AES_ENCRYPT("'.$students["user_password"].'","'.$students["passkey"].'")';
				// echo "<pre>";print_r($students);die();
				
				$sql_s = "INSERT INTO ".DB_PREFIX."student (admission_number, student_name, present_address,branch_id,year_id) VALUES(:admission_number, :student_name, :present_address, :branch_id,:year_id)";
			
				$stmt_s = $db->prepare($sql_s);  
				$stmt_s->bindParam(":admission_number", $students['admission_number']);
				$stmt_s->bindParam(":student_name", $students['student_name']);
				$stmt_s->bindParam(":present_address", $students['present_address']);
				$stmt_s->bindParam(":branch_id", $students['branch_id']);
				$stmt_s->bindParam(":year_id", $students['year_id']);
				$stmt_s->execute();

				$student_id = $db->lastInsertId();
		  		$students['student_id'] = $student_id;
		  		// var_dump($students);die();

		  		$parents = [
					['parent_firstname'=> $students['father_name'],
					'parent_mobile_number' => $students['father_mobile'],
					'relation_type' => 1,
					'student_id' => $students['student_id']],
					['parent_firstname'=> $students['mother_name'],
						'parent_mobile_number' => $students['mother_mobile'],
						'relation_type' => 2,
						'student_id' => $students['student_id']
					]
				];

				for ($p=0; $p < count($parents); $p++) {
			  		$sql_p = "INSERT INTO ".DB_PREFIX."student_parents (student_id,parent_firstname,parent_mobile_number,relation_type)VALUES(:student_id, :parent_firstname, :parent_mobile_number, :relation_type)";
			  		$stmt_p = $db->prepare($sql_p);  
					$stmt_p->bindParam(":student_id", $parents[$p]['student_id']);
					$stmt_p->bindParam(":parent_firstname", $parents[$p]['parent_firstname']);
					$stmt_p->bindParam(":parent_mobile_number", $parents[$p]['parent_mobile_number']);
					$stmt_p->bindParam(":relation_type", $parents[$p]['relation_type']);
					$stmt_p->execute();
					$parent_id[] = $db->lastInsertId();
				}					
		  		$students['parent_id'] = $parent_id[0];

		  		$sql_a = "INSERT INTO ".DB_PREFIX."student_academic (admission_number,student_id,branch_id,year_id,course_id,section_id)VALUES(:admission_number, :student_id, :branch_id, :year_id,:course_id,:section_id)";
		  		$stmt_a = $db->prepare($sql_a); 
				$stmt_a->bindParam(":admission_number", $students['admission_number']);
				$stmt_a->bindParam(":student_id", $students['student_id']);
				$stmt_a->bindParam(":branch_id", $students['branch_id']);
				$stmt_a->bindParam(":year_id", $students['year_id']);
				$stmt_a->bindParam(":course_id", $students['course_id']);
				$stmt_a->bindParam(":section_id", $students['section_id']);
				$stmt_a->execute();
				// echo $students['password'];die;
		  		
		  		$sql_u = "call addUsers (:user_name,:user_password,:passkey,:branch_id,:year_id,:parent_id,@result)";
		  		$stmt_u = $db->prepare($sql_u); 
				$stmt_u->bindParam(":user_name", $students['admission_number']);
				$stmt_u->bindParam(":user_password", $students['password']);
				$stmt_u->bindParam(":passkey", $students['passkey']);
				$stmt_u->bindParam(":branch_id", $students['branch_id']);
				$stmt_u->bindParam(":year_id", $students['year_id']);
				$stmt_u->bindParam(":parent_id", $students['parent_id']);
				$stmt_u->execute();	
				$db->query("select @result as result");//->fetch(PDO::FETCH_ASSOC);
				$stmt_u->fetch(PDO::FETCH_ASSOC);

				// $sql_u = "INSERT INTO ".DB_PREFIX."users ( `user_name`, `user_password`, `branch_id`, `year_id`,`parent_id`) VALUES ('".$students['admission_number']."',AES_ENCRYPT('".$students['user_password']."','".$students['passkey']."'),'".$students['branch_id']."','".$students['year_id']."','".$students['parent_id']."')";
				// $db->query($sql_u);
			}
		}
		$db = null;	
		echo '{"sucess": "Sucessfully added"}';
	}