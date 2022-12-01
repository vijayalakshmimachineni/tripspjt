<?php 
    namespace App\Controllers; 
    use CodeIgniter\Controller;
    use App\Models\LeisurePackages_model;
     
    class LeisurePackages extends Controller
    {
        public function index() { 
            $model = new LeisurePackages_model();
            $data['leisurePackages'] = $model->getLeisurePackagesLists();   
            // var_dump($data);die(); 
            return view('leisurepackageslist_view',$data);
        }

        public function leisurePackagesFaq($leisure_id){
            $model = new LeisurePackages_model();
            $data['lp_faqs'] = $model->getLeisurePackagesFaqs($leisure_id); 
            $data['leisure_id'] = $leisure_id;
             if(empty($data['lp_faqs']->faq)){
                $data['lp_faqs']->faq = [];
            } 
            // var_dump($data);die();            
            return view('leisurePackagesfaq_view',$data);
        }

        public function addLeisurePackagesFaq($leisure_id){ 
            $model = new LeisurePackages_model(); 
            $data['categories'] = $model->getCategories();
            $data['leisure_id'] = $leisure_id;  
            // var_dump($data);die;
            return view('addLeisurePackagesFaq',$data);
        }

        public function saveFaq(){
            $model = new LeisurePackages_model();
            $data = array(
                'catId' => $this->request->getPost('category_id'),
                'question' => $this->request->getPost('question'),
                'answer' => $this->request->getPost('answer'),
                'leisure_id' => $this->request->getPost('leisure_id')
            );       
            // var_dump($data);
            $model->saveFaq($data);
            return $this->response->redirect(base_url('/leisurepackagesFaq/'.$data['leisure_id'])); 
        }

        public function editFaq($faq_id){
            // echo $faq_id;die();
            $model = new LeisurePackages_model();
            $data['faq'] = $model->getEditFaq($faq_id)->faq[0]; 
            $data['categories'] = $model->getCategories();
            // var_dump($data);die();
            return view('editLeisurePackagesFaq',$data);
        }

        public function updateFaq(){
            $model = new LeisurePackages_model();
            $data = array(
                'catId' => $this->request->getPost('category_id'),
                'question' => $this->request->getPost('question'),
                'answer' => $this->request->getPost('answer'),
                'faq_id' => $this->request->getPost('faq_id'),
                'leisure_id' => $this->request->getPost('lp_id')
            );   
            // var_dump($data);die();    
            $model->updateFaq($data);
            return $this->response->redirect(base_url('/leisurepackagesFaq/'.$data['leisure_id'])); 
        }

        public function deleteLeisurePackagesFaq($faq_id,$leisure_id){
            // echo $faq_id;echo "<br>".$leisure_id;die();
            $model = new LeisurePackages_model();
            $data = array(
                'faq_id' => $faq_id,
                'status' => '9',
                'modified_by' => '1'
            );  
            $model->deleteLeisurePackagesFaq($data);
           return $this->response->redirect(base_url('/leisurepackagesFaq/'.$leisure_id)); 
        }

         public function leisurepackageGallery($leisure_id){
            $data['leisure_id'] = $leisure_id;
            $model = new LeisurePackages_model();
            $data['galleryImages'] = $model->getGalleryimages($leisure_id); 
            if(empty($data['galleryImages']->gallery_image)){
                $data['galleryImages']->gallery_image = [];
            }
            // var_dump($data);die();
            return view('lpgallery_view',$data);
        }

        public function addGalleryDetails($leisure_id){
            // var_dump($_FILES);die;
            helper(['form', 'url']);
            if($_FILES['file']['name']!=''){
                $input = $this->validate([
                    'file' => [
                        'uploaded[file]',
                        'mime_in[file,image/jpg,image/jpeg,image/png]',
                        'max_size[file,2048]',
                    ]
                ]);
                if (!$input) {
                    print_r('Choose a valid file');
                } else {
                    $img = $this->request->getFile('file');
                    // var_dump($img);die();
                    $arr = explode('/', $img->getClientMimeType());
                    // var_dump($arr);die();
                    $img->move(IMGUPLOAD.'leisurepackages/');
                    $data = [
                       'image_name' =>  $img->getName(),
                       'ext'  => $arr[1],
                       'leisure_id' => $leisure_id];
                    $model = new LeisurePackages_model();
                    $result = $model->addgalleryDetails($data);
                }
            }
            if($result){
                $data['galleryImages'] = $model->getGalleryimages($leisure_id); 
                return $this->response->redirect(base_url('/leisurepackageGallery/'.$leisure_id)); 
                // $this->session->sets("success_msg","images added successfully");
            }
        }

        /* sartaj code*/
        public function storeleisure(){
            helper(['form']);
           $rules = [            
                'pkg_days'      => 'required',                
            ];
            
            if($this->validate($rules)){ 
                $LeisurepackagesModel = new LeisurePackages_model();
                $pkg_overview = str_replace('"','\'', $this->request->getVar('pkg_overview'));
                $inclusion_exclusion = str_replace('"','\'', $this->request->getVar('inclusion_exclusion'));
                $terms_conditions = str_replace('"','\'', $this->request->getVar('terms_conditions'));
                $where_report = str_replace('"','\'', $this->request->getVar('where_report'));
                $data = [
                    'pkg_name'     => $this->request->getVar('pkg_name'),
                    'pkg_days' =>$this->request->getVar('pkg_days'),
                    'pkg_overview'=> htmlspecialchars($pkg_overview, ENT_QUOTES),
                    'inclusion_exclusion' => htmlspecialchars($inclusion_exclusion, ENT_QUOTES),
                    'terms_conditions' => htmlspecialchars($terms_conditions, ENT_QUOTES),
                    'where_report' => htmlspecialchars($where_report, ENT_QUOTES),
                    'created_date' =>date('Y-m-d H:i:s'),
                    'created_by' =>1,
                    'status' =>0
                ];

                $a = $LeisurepackagesModel->addleisure($data);
                //print_r($a);exit;
                if($a->status ==200){
                    $_SESSION['message'] = $a->message;
                    return redirect()->to('leisure');
                }else{

                    $data['validation'] = $this->validator;
                    echo view('leisurepackages\addleisure', $data);
                }
                
            }else{
                $data['validation'] = $this->validator;
                echo view('leisurepackages\addleisure', $data);
            }
        }

        public function addleisure(){
            helper(['form']);
            $rules = [ ];
            
            if($this->validate($rules)){ 

             }else{
                $data['validation'] = $this->validator;
            
                echo view('addleisure',$data);
            }
        }

        public function editleisure()
        {
            $LeisurepackagesModel = new LeisurePackages_model();
            helper(['form']);
            $rules = [
                'leisure_id'      => 'required'
            ];
             // print_r($this->request->getVar());exit;
            if($this->validate($rules)){             

                $pkg_overview = str_replace('"','\'', $this->request->getVar('pkg_overview'));
                $inclusion_exclusion = str_replace('"','\'', $this->request->getVar('inclusion_exclusion'));
                $terms_conditions = str_replace('"','\'', $this->request->getVar('terms_conditions'));
                $where_report = str_replace('"','\'', $this->request->getVar('where_report'));
                $data = [
                    'leisure_id'    => $this->request->getVar('leisure_id'),
                    'pkg_name'    => $this->request->getVar('pkg_name'),
                    'pkg_overview'=> htmlspecialchars($pkg_overview, ENT_QUOTES),
                    'inclusion_exclusion' => htmlspecialchars($inclusion_exclusion, ENT_QUOTES),
                    'terms_conditions' => htmlspecialchars($terms_conditions, ENT_QUOTES),
                    'where_report' => htmlspecialchars($where_report, ENT_QUOTES),
                    'modified_date' =>date('Y-m-d H:i:s'),
                    'modified_by' =>1,

                ];
               
               $a = $LeisurepackagesModel->editleisuredata($data);
               
                return redirect()->to('/leisurepackagesList');
            }else{
                $rules = [];
                $leisure = (array) $LeisurepackagesModel->getleisure($leisure_id);           
                if($leisure['status'] =200){
                     $data['result']  = $leisure['leisure_details']->leisures;
                }
                if($this->validate($rules)){}else{
                    $data['Headding']="Edit leisure";
                $data['validation'] = $this->validator;
                echo view('leisureedit', $data);
                }
            }
        
        } 

        public function deleteLeisure($lid)
        {
            $LeisurepackagesModel = new LeisurePackages_model();
                
            $data = [
                'leisure_id'  => $lid,                
                'status'    => "9",                
                'modified_date' =>date('Y-m-d H:i:s'),
                'modified_by' =>1,

            ];
           
           $a = $LeisurepackagesModel->editleisurestatus($data);
           
            return redirect()->to('/leisureslist');
           
        }
        public function deleteitineraryLeisure($lid)
        {
            $LeisurepackagesModel = new LeisurepackagesModel();
                
            $data = [
                'lpitinerary_id'  => $lid,                
                'status'    => "9",                
                'modified_date' =>date('Y-m-d H:i:s'),
                'modified_by' =>1,

            ];
           
           $a = $LeisurepackagesModel->deleteitineraryLeisure($data);
           
            return redirect()->to('/leisureslist');
           
        }

        function getleisure($leisure_id=''){
            $LeisurepackagesModel = new LeisurePackages_model();
            helper(['form']);
            $rules = [ ];
            $leisure = (array) $LeisurepackagesModel->getleisure($leisure_id);
            //print_r($leisure);
            if($leisure['status'] =200){
                 $data['result']  = $leisure['leisure']->Packages;
            }
            
            $data['Headding']="Edit leisure";
            if($this->validate($rules)){}else{
                $data['validation'] = $this->validator;
            }
            echo view('leisureedit',$data);
        }

        function getleisureitinerary($leisure_id=''){
            $LeisurepackagesModel = new LeisurePackages_model();
            $data['leisure_id'] =$leisure_id;
            helper(['form']);
            $rules = [ ];
            $leisure = (array) $LeisurepackagesModel->get_itinerary_leisure($leisure_id);
            //print_r($leisure);exit;
            if($leisure['status'] =200){
                 $data['result']  = json_decode(json_encode($leisure['leisure']));
            }
           // echo "<pre>";
            //print_r($data['result']);
            $data['Headding']="Itinerary leisure";
            if($this->validate($rules)){

            }else{
                $data['validation'] = $this->validator;
            }
            echo view('leisure_itinerary',$data);
        }

        function fileupload(){          
            $file = $this->request->getFile('file');
            $foldername = $this->request->getvar('foldername');
           if ($file) {
              if (!$_FILES['file']['error']) {
                $name = md5(rand(100, 200));
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $filename = $name.'.'.$ext;

               $file->move(baseimgURL.'Leisurepackages/'.$foldername.'/', $filename);
              
                echo SITEURL.'Leisurepackages/'.$foldername.'/'.$filename; //change this URL
              } else {
                echo $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
              }
            }
            
        }

    function leisureiterinarystore(){
        $entered = $this->request->getVar();
        //echo count($entered);//exit;
        //print_r(count($this->request->getVar('lpitinerary_id')));exit;
        $c = count($this->request->getVar('lpitinerary_id'));
        //print_r($udata);lpitinerary_id
        //exit;
        helper(['form']);
       
        if(1){ 
            $LeisurepackagesModel = new LeisurePackages_model();
            for($i=0;$i<$c;$i++){
                echo $entered['lpitinerary_id'][$i];
                if($entered['lpitinerary_id'][$i]){
                    $udata = [
                        'lpitinerary_id'=>$entered['lpitinerary_id'][$i],
                        'title'=>$this->request->getVar('title')[$i],
                        'description' =>$this->request->getVar('description')[$i],
                        'leisure_id'=>$this->request->getVar('leisure_id'),
                        'ndate'=>date('Y-m-d H:i:s'),
                        'user'=>"1",
                        'status'=>"0"
                    ];
                    $a[] = $LeisurepackagesModel->editleisureiterinarydata($udata);
                }else{                
                    $idata = [                    
                        
                        'title'=>$this->request->getVar('title')[$i],
                        'description' =>$this->request->getVar('description')[$i],
                        'leisure_id'=>$this->request->getVar('leisure_id'),
                        'ndate'=>date('Y-m-d H:i:s'),
                        'user'=>"1",
                        'status'=>"0"
                    ];
                    //echo "here";
                    $a[] = $LeisurepackagesModel->addleisureiterinarydata($idata);                
                }           
                //print_r($udata);exit;
            }


            
           // print_r($a);exit;
            if($a){
                $_SESSION['message'] = $a->message;
                return redirect()->to('/leisurepackagesList');
            }
            
        }else{
            $data['validation'] = $this->validator;
            echo view('addleisure', $data);
        }
    }
   

       

       
     
    }