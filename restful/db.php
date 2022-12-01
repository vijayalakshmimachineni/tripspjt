<?php
session_start();
$_SESSION['uid']='1';
$session_uid=$_SESSION['uid'];
define("SITE_KEY", "yoursitekey");
define("DB_PREFIX", "tbl_");
define("EXCELPATH", $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpoffice/phpspreadsheet/');
define('UPLOADFILEPATH', $_SERVER['DOCUMENT_ROOT'] . '/uploads/attendance_data/');
define('UPLOADPATH', $_SERVER['DOCUMENT_ROOT'] . '/myproject/documents/students/');
define('CONTROLLERPATH', 'Controllers/');
define('PHPSPREADSHEET', $_SERVER['DOCUMENT_ROOT'] . '/vendor/PhpOffice/PhpSpreadsheet/Spreadsheet');
define('SPREADSHEETWRITER', $_SERVER['DOCUMENT_ROOT'] . '/vendor/PhpOffice/PhpSpreadsheet/Writer/Xlsx');
define('PASSKEY','kcihtittui');

function getDB() {
	$dbhost="127.0.0.1";
	$dbuser="root";
	$dbpass="";
	$dbname="slim";

	$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	//$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbConnection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
  // var_dump($dbConnection);die;
	return $dbConnection;
}

function apiKey($session_uid){
  $key=md5(SITE_KEY.$session_uid);
  return hash('sha256', $key.$_SERVER['REMOTE_ADDR']);
}

function prc_get_multiset($sql, $data = array(), $fetchMode = PDO::FETCH_ASSOC) {
  $db = getDB();
  $res = $db->prepare($sql);
  foreach ($data as $key => $value) {
     $res->bindValue("$key", $value);      
  }
  $res->execute();
  $i = 1; $row = array();
  do {
    $rowset = $res->fetchAll(PDO::FETCH_ASSOC);
    if ($rowset) {
       $row[] = $rowset;
    }
    $i++;
  } while ($res->nextRowset());  
  return $row;
}

function loadUtility($utility) {
  global $utilityClass;
  require_once 'Utilities/'.$utility.'.php';
  return new $utility; 
}

$apiKey=apiKey($session_uid);
?>