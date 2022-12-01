<?php 
    namespace App\Controllers; 
    use CodeIgniter\Controller;
    use App\Models\Expedition_model;
      
    class Expeditions extends Controller
    {
        public function index() { 
            $model = new Expedition_model();
            $data['expeditions'] = $model->getExpeditionLists();   
            // var_dump($data['expeditions']->allexpeditions);die(); 
            return view('expeditionslist_view',$data);
        }

        public function expeditionFaq($expedition_id){
            $model = new Expedition_model();
            $data['exp_faqs'] = $model->getExpeditionFaqs($expedition_id); 
            $data['expedition_id'] = $expedition_id;
             if(empty($data['exp_faqs']->faq)){
                $data['exp_faqs']->faq = [];
            } 
            // var_dump($data);die();            
            return view('expeditionsfaq_view',$data);
        }

        public function addExpeditionFaq($expedition_id){ 
            $model = new Expedition_model(); 
            $data['categories'] = $model->getCategories();
            $data['expedition_id'] = $expedition_id;  
            // var_dump($data);die;
            return view('addExpeditionFaq',$data);
        }

        public function saveFaq(){
            $model = new Expedition_model();
            $data = array(
                'catId' => $this->request->getPost('category_id'),
                'question' => $this->request->getPost('question'),
                'answer' => $this->request->getPost('answer'),
                'expedition_id' => $this->request->getPost('expedition_id')
            );       
            $model->saveFaq($data);
            return $this->response->redirect(base_url('/expeditionsFaq/'.$data['expedition_id'])); 
        }

        public function editFaq($faq_id){
            // echo $faq_id;die();
            $model = new Expedition_model();
            $data['faq'] = $model->getEditFaq($faq_id)->faq[0]; 
            $data['categories'] = $model->getCategories();
            // var_dump($data);die();
            return view('editExpeditionFaq',$data);
        }

        public function updateFaq(){
            $model = new Expedition_model();
            $data = array(
                'catId' => $this->request->getPost('category_id'),
                'question' => $this->request->getPost('question'),
                'answer' => $this->request->getPost('answer'),
                'faq_id' => $this->request->getPost('faq_id'),
                'expedition_id' => $this->request->getPost('expedition_id')
            );   
            // var_dump($data);die();    
            $model->updateFaq($data);
            return $this->response->redirect(base_url('/expeditionsFaq/'.$data['expedition_id'])); 
        }

        public function deleteExpeditionFaq($faq_id,$expedition_id){
            // echo $faq_id;echo "<br>".$expedition_id;die();
            $model = new Expedition_model();
            $data = array(
                'faq_id' => $faq_id,
                'status' => '9',
                'modified_by' => '1'
            );  
            $model->deleteExpeditionFaq($data);
           return $this->response->redirect(base_url('/expeditionsFaq/'.$expedition_id)); 
        }

        public function expeditionGallery($expedition_id){
            $data['expedition_id'] = $expedition_id;
            $model = new Expedition_model();
            $data['galleryImages'] = $model->getGalleryimages($expedition_id); 
            if(empty($data['galleryImages']->gallery_image)){
                $data['galleryImages']->gallery_image = [];
            }
            // var_dump($data);die();
            return view('expeditiongallery_view',$data);
        }

        public function addGalleryDetails($expedition_id){
            // echo IMGUPLOAD.'expeditions/';die();
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
                    $img->move(IMGUPLOAD.'expeditions/');
                    $data = [
                       'image_name' =>  $img->getName(),
                       'ext'  => $arr[1],
                       'expedition_id' => $expedition_id];
                    $model = new Expedition_model();
                    $result = $model->addgalleryDetails($data);
                }
            }
            if($result){
                $data['galleryImages'] = $model->getGalleryimages($expedition_id); 
                return $this->response->redirect(base_url('/expeditionGallery/'.$expedition_id)); 
                // $this->session->sets("success_msg","images added successfully");
            }
        }

        /* sartaj code*/
        public function storeExpedition() {
      
            helper(['form']);
            $rules = [
                'expedition_fee'      => 'required',
                'expedition_days'      => 'required',
                'expedition_nights'      => 'required',
                'expedition_title'      => 'required|is_unique[expedition_title]'
            ];
            
            if($this->validate($rules)){ 
                $ExpeditionsModel = new Expedition_model();
                $Expedition_overview = str_replace('"','\'', $this->request->getVar('Expedition_overview'));
                $things_carry = str_replace('"','\'', $this->request->getVar('things_carry'));
                $terms = str_replace('"','\'', $this->request->getVar('terms'));
                $mapimage = str_replace('"','\'', $this->request->getVar('map_image'));
                $data = [
                    'expedition_title'     => $this->request->getVar('expedition_title'),
                    'expedition_fee'    => $this->request->getVar('expedition_fee'),                
                    'expedition_days' =>$this->request->getVar('Expedition_days'),
                    'expedition_nights' =>$this->request->getVar('Expedition_days'),
                    'expedition_overview'=> htmlspecialchars($Expedition_overview, ENT_QUOTES),
                    'things_carry' => htmlspecialchars($things_carry, ENT_QUOTES),
                    'terms' => htmlspecialchars($terms, ENT_QUOTES),
                    'map_image' => htmlspecialchars($mapimage, ENT_QUOTES),
                    'created_date' =>date('Y-m-d H:i:s'),
                    'created_by' =>1,
                    'status' =>0
                ];

                $a = $ExpeditionsModel->addExpedition($data);
                //print_r($a);exit;
                if($a->status ==200){
                    $_SESSION['message'] = $a->message;
                    return redirect()->to('addExpedition');
                }else{

                    $data['validation'] = $this->validator;
                    echo view('addExpedition', $data);
                }
                
            }else{
                $data['validation'] = $this->validator;
                echo view('addExpedition', $data);
            }
        }

        public function addExpedition(){
            helper(['form']);
            $rules = [ ];
            
            if($this->validate($rules)){ 

             }else{
                $data['validation'] = $this->validator;
            
                echo view('addExpedition',$data);
            }
        }

        public function editExpedition(){
            $ExpeditionsModel = new Expedition_model();
            helper(['form']);
            $rules = [
                'expedition_id'      => 'required'
            ];
              
            if($this->validate($rules)){                

                $Expedition_overview = str_replace('"','\'', $this->request->getVar('expedition_overview'));
                $things_carry = str_replace('"','\'', $this->request->getVar('things_carry'));
                $terms = str_replace('"','\'', $this->request->getVar('terms'));
                $mapimage = str_replace('"','\'', $this->request->getVar('map_image'));
                $data = [
                    'expedition_id'    => $this->request->getVar('expedition_id'),
                    'expedition_title'    => $this->request->getVar('expedition_title'),
                    'expedition_overview'=> htmlspecialchars($Expedition_overview, ENT_QUOTES),
                    'things_carry' => htmlspecialchars($things_carry, ENT_QUOTES),
                    'terms' => htmlspecialchars($terms, ENT_QUOTES),
                    'map_image' => htmlspecialchars($mapimage, ENT_QUOTES),
                    'modified_date' =>date('Y-m-d H:i:s'),
                    'modified_by' =>1,

                ];
               
               $a = $ExpeditionsModel->editExpeditiondata($data);
               
                return redirect()->to('/expeditionsList');
            }else{
                $rules = [];
                $Expedition = (array) $ExpeditionsModel->getExpedition($expedition_id);           
                if($Expedition['status'] =200){
                     $data['result']  = $Expedition['Expedition_details']->Expeditions;
                }
                if($this->validate($rules)){}else{
                    $data['Headding']="Edit Expedition";
                $data['validation'] = $this->validator;
                echo view('expeditionedit', $data);
                }
            }
        
        }

        function getExpedition($expedition_id=''){
            $ExpeditionsModel = new Expedition_model();
            helper(['form']);
            $rules = [ ];
            $Expedition = (array) $ExpeditionsModel->getExpedition($expedition_id);

            if($Expedition['status'] =200){
                $data['result']  = $Expedition['expedition_details']->expeditions;
            }
            // print_r($data['result']);exit;
            $data['Headding']="Edit Expedition";
            if($this->validate($rules)){}else{
                $data['validation'] = $this->validator;
            }
            echo view('expeditionedit',$data);
        }
        
        function getExpeditionitinerary($expedition_id=''){
            $ExpeditionsModel = new Expedition_model();
            $data['expedition_id'] =$expedition_id;
            helper(['form']);
            $rules = [ ];
            $Expedition = (array) $ExpeditionsModel->get_itinerary_Expedition($expedition_id);
            //print_r($Expedition);exit;
            if($Expedition['status'] =200){
                 $data['result']  = json_decode(json_encode($Expedition['allexpeditions']));
            }
           // echo "<pre>";
            //print_r($data['result']);
            $data['Headding']="Itinerary Expedition";
            if($this->validate($rules)){

            }else{
                $data['validation'] = $this->validator;
            }
            echo view('expedition_itinerary',$data);
        }


    function expeditioniterinarystore(){
        $entered = $this->request->getVar();
        $c = count($this->request->getVar('iterinary_id'));
        helper(['form']);
       
        if(1){ 
            $ExpeditionsModel = new Expedition_model();
            for($i=0;$i<$c;$i++){
                //if($entered['iterinary_id'][$i]){
                if(1){
                    $udata = [
                        'iterinary_id'=>$this->request->getVar('iterinary_id')[$i],
                        'iterinary_title'=>$this->request->getVar('iterinary_title')[$i],
                        'iterinary_details' =>$this->request->getVar('iterinary_details')[$i],
                        'expedition_id'=>$this->request->getVar('expedition_id'),
                        'modified_date'=>date('Y-m-d H:i:s'),
                        'modified_by'=>"1"
                    ];
                    //print_r($udata);//exit;
                    $a[] = $ExpeditionsModel->editExpeditioniterinarydata($udata);
                }else{                
                    $idata = [                    
                        'expedition_id'=>$this->request->getVar('expedition_id'),
                        'created_date'=>date('Y-m-d H:i:s'),
                        'created_by'=>"1",
                        'status'=>"0",
                        'iterinary_title'=>$this->request->getVar('iterinary_title')[$i],
                        'iterinary_details' =>$this->request->getVar('iterinary_details')[$i]
                    ];
                    $a[] = $ExpeditionsModel->addExpeditioniterinarydata($idata);                
                }           
                //print_r($udata);exit;
            }
            if($a){
                $_SESSION['message'] = $a->message;
                return redirect()->to('/expeditionslist');
            }
            
        }else{
            $data['validation'] = $this->validator;
            echo view('Expeditions\addExpedition', $data);
        }
    }

        public function deleteexpedition($lid)
        {
            $ExpeditionsModel = new Expedition_model();
                
            $data = [
                'expedition_id'  => $lid,                
                'status'    => "9",                
                'modified_date' =>date('Y-m-d H:i:s'),
                'modified_by' =>1,

            ];
           
           $a = $ExpeditionsModel->editExpeditionstatus($data);
           
            return redirect()->to('/expeditionslist');
           
        }
        public function deleteitineraryExpedition($lid)    {
            $ExpeditionsModel = new Expedition_model();
                
            $data = [
                'iterinary_id'  => $lid,                
                'status'    => "9",                
                'modified_date' =>date('Y-m-d H:i:s'),
                'modified_by' =>1,

            ];
           
           $a = $ExpeditionsModel->deleteitineraryExpedition($data);
           
        }

        function fileupload(){
          
            $file = $this->request->getFile('file');
            $foldername = $this->request->getvar('foldername');
           if ($file) {
              if (!$_FILES['file']['error']) {
                $name = md5(rand(100, 200));
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $filename = $name.'.'.$ext;

               $file->move(baseimgURL.'Expedition/'.$foldername.'/', $filename);
              
                echo SITEURL.$foldername.'/Expedition/'.$filename; //change this URL
              } else {
                echo $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
              }
            }
            
        }

       

       
     
    }