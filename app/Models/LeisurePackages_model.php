<?php 
	namespace App\Models;
	use CodeIgniter\Model; 

	use CodeIgniter\Controller;
	use App\Controllers\Home; 

	class LeisurePackages_model extends Model{		

		public function getLeisurePackagesLists(){
			$home = new Home();
	  		$url = base_url().'/ridingsolo/leisurepackages/getleisurepackages';
	  		// echo $url;die();
	  		return $home->CallAPI('GET',$url);
		}

		public function getLeisurePackagesFaqs($expedition_id){
			$home = new Home();
			$url = base_url().'/ridingsolo/leisurepackages/getfaq/'.$expedition_id;
			// echo $url;die(); 
			return $home->CallAPI('GET',$url);
		}

		public function getCategories(){
			$home = new Home();
			$url = base_url().'/ridingsolo/faq/getfaqcategories';
			// echo $url;die();
			return $home->CallAPI('GET',$url);
		}

		public function saveFaq($data){
			$home = new Home();
			$url = base_url().'/ridingsolo/leisurepackages/addlpfaq';
			$data['status'] = 0;
			$data['createdBy'] = '1';
			return $home->CallAPI('POST',$url,$data);
		}
		
		public function getEditFaq($faq_id){
			$home = new Home();
			$url = base_url().'/ridingsolo/leisurepackages/getEditFaq/'.$faq_id;
			// echo $url;die();
			return $home->CallAPI('GET',$url);
		}

		public function updateFaq($data){
			$home = new Home();
			$url = base_url().'/ridingsolo/leisurepackages/updatelpfaq'; 
			$data['status'] = 0;
			$data['createdBy'] = '1';
			// echo $url."<br>";
			// var_dump(json_encode($data));die;
			return $home->CallAPI('POST',$url,$data);
		}

		public function deleteLeisurePackagesFaq($data){
			$home = new Home();
			$url = base_url().'/ridingsolo/leisurepackages/updatelpfaqstatus';
			return $home->CallAPI('POST',$url,$data);
		}

		
		public function getGalleryimages($leisure_id){
			$home = new Home();
			$url = base_url().'/ridingsolo/leisurepackages/getgallery/'.$leisure_id;
			// echo $url;die();
			return $home->CallAPI('GET',$url);
		}
		
		public function addgalleryDetails($data){
			// var_dump($data);die;
			$home = new Home();
			$url = base_url().'/ridingsolo/leisurepackages/addgallery';
			$data['status'] = 0;
			$data['createdBy'] = '1';
			// echo $url."<br>";var_dump(json_encode($data));die();
			return $home->CallAPI('POST',$url,$data);
		}

		/* sartaj code */


    public function getleisure($leisure_id =""){       
        $home = new Home();
        //$data = array();
        $url = base_url().'/ridingsolo/leisurepackages/editleisurepackages/'.$leisure_id;
       return $home->CallAPI('GET',$url,$data);
      
    }

    public function get_itinerary_leisure($leisure_id =""){       
        $home = new Home();
        $data = array();
        $url = base_url().'/ridingsolo/leisurepackages/get_itinerary_leisure/'.$leisure_id;
       return $home->CallAPI('GET',$url,$data);
      
    }

    public function editleisuredata($data){           
        $home = new Home();   
        //print_r(json_encode($data));exit;     
       $url = base_url().'/ridingsolo/leisurepackages/updateleisure';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function editleisurestatus($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = base_url().'/ridingsolo/leisurepackages/updateleisurepackagestatus';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function deleteitineraryLeisure($data){           
        $home = new Home();   
        //print_r(json_encode($data));exit;     
       $url = base_url().'/ridingsolo/leisurepackages/deleteiterinary';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function addleisure($data){           
        $home = new Home();       
       $url = base_url().'/ridingsolo/leisurepackages/addleisure';
       
       return $home->CallAPI('POST',$url,$data);          
    }

    public function editleisureiterinarydata($data){           
        $home = new Home();   
        //print_r(json_encode($data));exit;     
       $url = base_url().'/ridingsolo/leisurepackages/editleisureiterinary';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function addleisureiterinarydata($data){           
        $home = new Home();   
        //print_r(json_encode($data));exit;     
       $url = base_url().'/ridingsolo/leisurepackages/addleisureiterinary';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

   	
		
	    


	}

?>