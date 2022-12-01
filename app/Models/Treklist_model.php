<?php 
	namespace App\Models;
	use CodeIgniter\Model;

	use CodeIgniter\Controller;
	use App\Controllers\Home;

	class Treklist_model extends Model{		

		public function getTrekLists(){
			$home = new Home();
	  		$url = base_url().'/ridingsolo/treks/gettreks';
	  		// echo $url;die();
	  		return $home->CallAPI('GET',$url);
		}

		public function getTrekFaqs($trek_id){
			$home = new Home();
			$url = base_url().'/ridingsolo/treks/getfaq/'.$trek_id;
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
			$url = base_url().'/ridingsolo/treks/addtrekfaq';
			$data['status'] = 0;
			$data['createdBy'] = '1';
			// echo $url;
			// var_dump(json_encode($data));die();
			return $home->CallAPI('POST',$url,$data);
		}
		
		public function getEditFaq($faq_id){
			// echo $faq_id;die;
			$home = new Home();
			$url = base_url().'/ridingsolo/treks/getEditFaq/'.$faq_id;
			// echo $url;die();
			return $home->CallAPI('GET',$url);
		}

		public function updateFaq($data){
			$home = new Home();
			$url = base_url().'/ridingsolo/treks/updatetrekfaq';
			$data['status'] = 0;
			$data['createdBy'] = '1';
			return $home->CallAPI('POST',$url,$data);
		}

		public function deleteTrekFaq($data){
			// var_dump($data);die();
			$home = new Home();
			$url = base_url().'/ridingsolo/treks/updatetrekfaqstatus';
			return $home->CallAPI('POST',$url,$data);
		}

		public function getGalleryimages($trek_id){
			$home = new Home();
			$url = base_url().'/ridingsolo/treks/trekgallery/'.$trek_id;
			return $home->CallAPI('GET',$url);
		}
		
		public function addgalleryDetails($data){
			// var_dump($data);die;
			$home = new Home();
			$url = base_url().'/ridingsolo/treks/addtrekgallery';
			$data['status'] = 0;
			$data['createdBy'] = '1';
			// echo $url."<br>";var_dump(json_encode($data));die();
			return $home->CallAPI('POST',$url,$data);
		}

		public function getTrekitinerary($trek_id =""){       
	        $home = new home();
	        $url = base_url().'/ridingsolo/treks/gettrekitinerary/'.$trek_id;
	       return $home->CallAPI('GET',$url);      
	    }

	    public function edittrekiterinarydata($data){           
	        $home = new home();   
	        //print_r(json_encode($data));exit;     
	       $url = base_url().'/ridingsolo/treks/edittrekiterinarydata';
	       return $home->CallAPI('POST',$url,$data);          
	    }


	    public function getTrek($trek_id =""){       
	        $home = new home();
	        $url = base_url().'/ridingsolo/treks/gettrek/'.$trek_id;
	        return $home->CallAPI('GET',$url);
	      
	    }

	    public function updateTrek($data){     
	    	// var_dump($data);die;
	        $home = new home();      
	       $url = base_url().'/ridingsolo/treks/updatetrekinfo';
	       // echo $url;var_dump(json_encode($data));die;
	       return $home->CallAPI('POST',$url,$data);          
   		}

   		public function addtrek($data){           
	        $home = new home();     
	       $url = base_url().'/ridingsolo/treks/addtrek';
	       return $home->CallAPI('POST',$url,$data);          
	    }



		
	    


	}

?>