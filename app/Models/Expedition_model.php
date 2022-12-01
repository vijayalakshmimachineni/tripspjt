<?php 
	namespace App\Models;
	use CodeIgniter\Model; 

	use CodeIgniter\Controller;
	use App\Controllers\Home; 

	class Expedition_model extends Model{		

		public function getExpeditionLists(){
			$home = new Home();
	  		$url = base_url().'/ridingsolo/expeditions/getexpeditions';
	  		// echo $url;die();
	  		return $home->CallAPI('GET',$url);
		}

		public function getExpeditionFaqs($expedition_id){
			$home = new Home();
			$url = base_url().'/ridingsolo/expeditions/getfaq/'.$expedition_id;
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
			$url = base_url().'/ridingsolo/expeditions/addexpeditionfaq';
			$data['status'] = 0;
			$data['createdBy'] = '1';
			return $home->CallAPI('POST',$url,$data);
		}
		
		public function getEditFaq($faq_id){
			$home = new Home();
			$url = base_url().'/ridingsolo/expeditions/getEditFaq/'.$faq_id;
			// echo $url;die();
			return $home->CallAPI('GET',$url);
		}

		public function updateFaq($data){
			$home = new Home();
			$url = base_url().'/ridingsolo/expeditions/updateexpeditionfaq'; 
			$data['status'] = 0;
			$data['createdBy'] = '1';
			return $home->CallAPI('POST',$url,$data);
		}

		public function deleteExpeditionFaq($data){
			$home = new Home();
			$url = base_url().'/ridingsolo/expeditions/updateexpeditionfaqstatus';
			
			return $home->CallAPI('POST',$url,$data);
		}

		public function getGalleryimages($expedition_id){
			$home = new Home();
			$url = base_url().'/ridingsolo/expeditions/expeditiongallery/'.$expedition_id;
			return $home->CallAPI('GET',$url);
		}
		
		public function addgalleryDetails($data){
			// var_dump($data);die;
			$home = new Home();
			$url = base_url().'/ridingsolo/expeditions/addexpeditiongallery';
			$data['status'] = 0;
			$data['createdBy'] = '1';
			// echo $url."<br>";var_dump(json_encode($data));die();
			return $home->CallAPI('POST',$url,$data);
		}

		/* sartaj code*/

	    public function getExpedition($expedition_id =""){	       
	        $home = new Home();
	        //$data = array();
	        $url = base_url().'/ridingsolo/expeditions/getexpedition/'.$expedition_id;
	        // echo $url;die;
	       return $home->CallAPI('GET',$url,$data);	      
	    }

	    public function get_itinerary_expedition($expedition_id =""){	       
	        $home = new Home();
	        $data = array();
	        $url = base_url().'/ridingsolo/expeditions/get_itinerary_expedition/'.$expedition_id;
	        // echo $url;die();
	       return $home->CallAPI('GET',$url,$data);	      
	    }

	    public function editExpeditiondata($data){           
	        $home = new Home();   	          
	       $url = base_url().'/ridingsolo/expeditions/updateexpedition';
	       // echo $url;var_dump(json_encode($data));die;
	       return $home->CallAPI('POST',$url,$data);          
	    }

	    public function addexpedition($data){           
	        $home = new Home();   
	        //print_r(json_encode($data));exit;     
	       $url = base_url().'/ridingsolo/expeditions/addexpedition';//exit;
	       return $home->CallAPI('POST',$url,$data);          
	    }

	    public function editExpeditioniterinarydata($data){           
	        $home = new Home();   
	        //print_r(json_encode($data));exit;     
	       $url = base_url().'/ridingsolo/expeditions/editexpeditioniterinarydata';
	       return $home->CallAPI('POST',$url,$data);          
	    }

	    public function addExpeditioniterinarydata($data){           
	        $home = new Home();   
	        print_r(json_encode($data));exit;     
	       $url = base_url().'/ridingsolo/expeditions/addexpeditioniterinary';
	       // $url = base_url().'/ridingsolo/expeditions/addexpeditioniterinarydata';
	       return $home->CallAPI('POST',$url,$data);          
	    }

	    public function deleteitineraryexpedition($data){           
	        $home = new Home();   
	        //print_r(json_encode($data));exit;     
	       $url = base_url().'/ridingsolo/expeditions/deleteiterinary';//exit;
	       return $home->CallAPI('POST',$url,$data);          
	    }

	    public function editExpeditionstatus($data){           
	        $home = new Home();   
	        //print_r(json_encode($data));exit;     
	       $url = base_url().'/ridingsolo/expeditions/updateexpeditionsstatus';//exit;
	       return $home->CallAPI('POST',$url,$data);          
	    }

		

		
		
	    


	}

?>