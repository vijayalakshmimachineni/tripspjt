<?php 
	namespace App\Models;
	use CodeIgniter\Model; 

	use CodeIgniter\Controller;
	use App\Controllers\Home;
 
	class Hostels_model extends Model{		

		public function getHostelsLists(){
			$home = new Home();
	  		$url = base_url().'/ridingsolo/hostels/gethostels';
	  		// echo $url;die();
	  		return $home->CallAPI('GET',$url);
		}

		public function getHostelsFaqs($hostel_id){
			$home = new Home();
			$url = base_url().'/ridingsolo/hostels/getfaq/'.$hostel_id;
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
			$url = base_url().'/ridingsolo/hostels/addhostelfaq';
			$data['status'] = 0;
			$data['createdBy'] = '1';
			// var_dump(json_encode($data));die();
			return $home->CallAPI('POST',$url,$data);
		}
		
		public function getEditFaq($faq_id){
			$home = new Home();
			$url = base_url().'/ridingsolo/hostels/getEditFaq/'.$faq_id;
			// echo $url;die();
			return $home->CallAPI('GET',$url);
		}

		public function updateFaq($data){
			$home = new Home();
			$url = base_url().'/ridingsolo/hostels/updatehostelfaq'; 
			$data['status'] = 0;
			$data['createdBy'] = '1';
			// var_dump(json_encode($data));die;
			return $home->CallAPI('POST',$url,$data);
		}

		public function deleteHostelFaq($data){
			// var_dump(json_encode($data));die();
			$home = new Home();
			$url = base_url().'/ridingsolo/hostels/updatehostelfaqstatus';
			// echo $url;var_dump(json_encode($data));die;
			return $home->CallAPI('POST',$url,$data);
		}

		public function getGalleryimages($hostel_id){
			$home = new Home();
			$url = base_url().'/ridingsolo/hostels/getgallery/'.$hostel_id;
			// echo $url;die();
			return $home->CallAPI('GET',$url);
		}
		
		public function addgalleryDetails($data){
			// var_dump($data);die;
			$home = new Home();
			$url = base_url().'/ridingsolo/hostels/addgallery';
			$data['status'] = 0;
			$data['createdBy'] = '1';
			// echo $url."<br>";var_dump(json_encode($data));die();
			return $home->CallAPI('POST',$url,$data);
		}

		/* sartaj code*/
		public function addhostel($data){           
	        $home = new Home();   
	        //print_r(json_encode($data));exit;     
	       $url = base_url().'/ridingsolo/hostels/addhostel';
	       return $home->CallAPI('POST',$url,$data);          
	    }
		

		
		
	    


	}

?>