<?php 
	namespace App\Models;
	use CodeIgniter\Model; 

	use CodeIgniter\Controller;
	use App\Controllers\Home;

	class Biketrip_model extends Model{

		public function getBikeTripLists(){
			$home = new Home();
	  		$url = base_url().'/ridingsolo/biketrips/getbiketrips';
	  		// echo $url;die();
	  		return $home->CallAPI('GET',$url);
		}

		public function getBiketripFaqs($tripId){
			$home = new Home();
			$url = base_url().'/ridingsolo/biketrips/getfaq/'.$tripId;
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
			$url = base_url().'/ridingsolo/biketrips/addtripfaq';
			$data['status'] = 0;
			$data['createdBy'] = '1';
			// var_dump(json_encode($data));die();
			return $home->CallAPI('POST',$url,$data);
		}
		
		public function getEditFaq($faq_id){
			$home = new Home();
			$url = base_url().'/ridingsolo/biketrips/getEditFaq/'.$faq_id;
			// echo $url;die();
			return $home->CallAPI('GET',$url);
		}

		public function updateFaq($data){
			$home = new Home();
			$url = base_url().'/ridingsolo/biketrips/updatetripfaq'; 
			$data['status'] = 0;
			$data['createdBy'] = '1';
			// var_dump(json_encode($data));die;
			return $home->CallAPI('POST',$url,$data);
		}

		public function deleteBikeFaq($data){
			// var_dump(json_encode($data));die();
			$home = new Home();
			$url = base_url().'/ridingsolo/biketrips/updatetripfaqstatus';
			// echo $url;die;
			return $home->CallAPI('POST',$url,$data);
		}
		
		public function getGalleryimages($trip_id){
			$home = new Home();
			$url = base_url().'/ridingsolo/biketrips/getgallery/'.$trip_id;
			// echo $url;die();
			return $home->CallAPI('GET',$url);
		}
		
		public function addgalleryDetails($data){
			// var_dump($data);die;
			$home = new Home();
			$url = base_url().'/ridingsolo/biketrips/addgallery';
			$data['status'] = 0;
			$data['createdBy'] = '1';
			// echo $url."<br>";var_dump(json_encode($data));die();
			return $home->CallAPI('POST',$url,$data);
		}

		/* sartaj code*/
		public function get_itinerary_trip($trip_id =""){       
	        $home = new Home();
	        $data = array();
	        $url = base_url().'/ridingsolo/biketrips/gettripitinerary/'.$trip_id;
	        return $home->CallAPI('GET',$url,$data);	      
	    }

	     public function addtripiterinarydata($data){           
	        $home = new home();   
	       // print_r(json_encode($data));//exit;     
	        $url = base_url().'/biketrips/addbiketripiterinary';//exit;
	       return $home->CallAPI('POST',$url,$data);          
	    }

	    public function edittripiterinarydata($data){           
	        $home = new Home();   
	        //print_r(json_encode($data));exit;     
	       $url = base_url().'/ridingsolo/biketrips/editbiketripiterinary';
	       return $home->CallAPI('POST',$url,$data);          
	    }

	     public function addtrip($data){           
	        $home = new Home();
	       $url = base_url().'/ridingsolo/biketrips/addbiketrip';
	       echo $url;var_dump(json_encode($data));
	       return $home->CallAPI('POST',$url,$data);          
	    }

	    public function getTrip($trip_id =""){       
	        $home = new Home();
	        //$data = array();
	        $url = base_url().'/ridingsolo/biketrips/getbiketrip/'.$trip_id;
	       return $home->CallAPI('GET',$url);	      
	    }

	    public function edittripdata($data){           
	        $home = new Home();   
	        //print_r(json_encode($data));exit;     
	       $url = base_url().'/biketrips/updatebiketrip';
	       return $home->CallAPI('POST',$url,$data);          
	    }

		
		
	    


	}

?>