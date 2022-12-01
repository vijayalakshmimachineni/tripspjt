<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;



/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    // define('RESTAPYKEY',urldecode('78e7fc94-0169-4b9a-994d-5e402cfbb01'));
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    public function CallAPI($method, $url, $data = false){
      // echo $method;echo $url; 
      // var_dump($data);die();
       try{
        $curl = curl_init();
            switch ($method){
            case "POST":
              curl_setopt($curl, CURLOPT_POST, true);
              if ($data) {
                $data['user_id'] = "1";
                $data['apiKey'] = RESTAPYKEY;                  
                $data = json_encode($data);

              // var_dump($data);die();
               curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              }                    
              break;
            case "PUT":
              curl_setopt($curl, CURLOPT_POST, 1);
              curl_setopt($curl, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
              $data['user_id'] = "1";
              $data['apiKey'] = RESTAPYKEY;                    
              curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              break;
            case "DELETE":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
              $url =  $url ."/1/".RESTAPYKEY;
              break;
            default:
              if ($data) {
                $data = json_encode($data);
                $url = sprintf("%s?%s", $url, http_build_query($data));
              }                    
          }        
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      // echo $url;die();  
      $result = curl_exec($curl);
      // print_r($result);exit();
         
      curl_close($curl);
      $decoded = json_decode($result);
      // echo 'res--';print_r(trim($decoded));exit();
      if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
        die('error occured: ' . $decoded->response->errormessage);
      }
      return $decoded;
    }catch(Exception $e) {
      die('error occured: ' . $e);
    }
    }

}
