<?php 
    namespace App\Controllers;
    use CodeIgniter\Controller;
    use App\Models\Treklist_model; 
     
    class Treklist extends Controller
    {
        public function index() {
            $model = new Treklist_model();
            $data['treks'] = $model->getTrekLists();   
            // var_dump($data);die();   
            return view('treklist_view',$data);
        }

        public function trekfaq($trek_id){
            $model = new Treklist_model();
            $data['trekfaqs'] = $model->getTrekFaqs($trek_id); 
            $data['trek_id'] = $trek_id;
            // var_dump($data);die();     
            if(empty($data['trekfaqs']->faq)){
                $data['trekfaqs']->faq = [];
            }     
            return view('trekfaq_view',$data);
        }

        public function addFaq($trek_id){ 
            $model = new Treklist_model(); 
            $data['categories'] = $model->getCategories();
            $data['trek_id'] = $trek_id;  
            // var_dump($data);die;
            return view('addTrekFaqs',$data);
        }

        public function saveFaq(){
            $model = new Treklist_model();
            $data = array(
                'cat_id' => $this->request->getPost('category_id'),
                'question' => $this->request->getPost('question'),
                'answer' => $this->request->getPost('answer'),
                'trek_id' => $this->request->getPost('trek_id')
            );  
            // var_dump(($data));die();       
            $model->saveFaq($data);
            return $this->response->redirect(base_url('/trekFaq/'.$data['trek_id'])); 
        }

        public function editFaq($faq_id){
            // echo $faq_id;die();
            $model = new Treklist_model();
            $data['faq'] = $model->getEditFaq($faq_id)->faq[0]; 
            $data['categories'] = $model->getCategories();
            // var_dump($data);die();
            return view('editTrekFaq',$data);
        }

        public function updateFaq(){
            $model = new Treklist_model();
            $data = array(
                'cat_id' => $this->request->getPost('category_id'),
                'question' => $this->request->getPost('question'),
                'answer' => $this->request->getPost('answer'),
                'faq_id' => $this->request->getPost('faq_id'),
                'trek_id' => $this->request->getPost('trek_id')
            );   
            // var_dump($data);die();       
            $model->updateFaq($data);
            return $this->response->redirect(base_url('/trekFaq/'.$data['trek_id'])); 
        }

        public function deleteTrekFaq($faq_id,$trek_id){
            // echo $faq_id;echo "<br>".$trek_id;die();
            $model = new Treklist_model();
            $data = array(
                'faq_id' => $faq_id,
                'status' => '9',
                'modified_by' => '1'
            );  
            $model->deleteTrekFaq($data);
           return $this->response->redirect(base_url('/trekFaq/'.$trek_id)); 
        }

        public function trekGallery($trek_id){
            $data['trek_id'] = $trek_id;
            $model = new Treklist_model();
            $data['galleryImages'] = $model->getGalleryimages($trek_id); 
            if(empty($data['galleryImages']->gallery_image)){
                $data['galleryImages']->gallery_image = [];
            }
            // var_dump($data);die;
            return view('trekgallery_view',$data);
        }

        public function addGallerydetails($trek_id){
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
                    $img->move(IMGUPLOAD.'treksgallery/');
                    $data = [
                       'image_name' =>  $img->getName(),
                       'ext'  => $arr[1],
                       'trek_id' => $trek_id];
                    $model = new Treklist_model();
                    $result = $model->addgalleryDetails($data);
                }
            }
            if($result){
                $data['galleryImages'] = $model->getGalleryimages($trek_id); 
                return $this->response->redirect(base_url('/trekGallery/'.$trek_id)); 
                // $this->session->sets("success_msg","images added successfully");
            }
        }

        /* sartaj code*/
        public function gettrekitinerary($trek_id=''){
            $TrekModel = new Treklist_model();
            $data['trek_id'] =$trek_id;
            helper(['form']);
            $rules = [ ];
            $trek = (array) $TrekModel->getTrekitinerary($trek_id);
            //print_r($trek);exit;
            if($trek['status'] =200){
                 $data['result']  = json_decode(json_encode($trek['trek_details']));
            }
           // echo "<pre>";
            // print_r($data['result']);
            $data['Headding']="Itinerary Trek";
            if($this->validate($rules)){

            }else{
                $data['validation'] = $this->validator;
            }
            echo view('trekitenary_view',$data);
        }

        public function trekiterinarystore()   {
            $entered = $this->request->getVar();
            //print_r($udata);
            //exit;
            helper(['form']);
           
            if(1){ 
                $TrekModel = new Treklist_model();
                for($i=0;$i<count($entered);$i++){
                if($entered['iterinary_id'][$i]){
                    $udata = [
                        'iterinary_id'=>$entered['iterinary_id'][$i],
                        'iterinary_title'=>$this->request->getVar('iterinary_title')[$i],
                        'iterinary_details' =>$this->request->getVar('iterinary_details')[$i],
                        'trek_id'=>$this->request->getVar('trek_id'),
                        'modified_date'=>date('Y-m-d H:i:s'),
                        'modified_by'=>"1"
                    ];
                    $a[] = $TrekModel->edittrekiterinarydata($udata);
                }else{                
                    $idata = [                    
                        'trek_id'=>$this->request->getVar('trek_id'),
                        'created_date'=>date('Y-m-d H:i:s'),
                        'created_by'=>"1",
                        'status'=>"0",
                        'iterinary_title'=>$this->request->getVar('iterinary_title')[$i],
                        'iterinary_details' =>$this->request->getVar('iterinary_details')[$i]
                    ];
                    $a[] = $TrekModel->addtrekiterinarydata($idata);                
                }           
                //print_r($udata);exit;
            }
        
           // print_r($a);exit;
            if($a){
                $_SESSION['message'] = $a->message;
                $data['treks'] = $TrekModel->getTrekLists();  
                 return view('treklist_view',$data);
                // return redirect()->to('/trekslist');
            }
            
            }else{
                $data['validation'] = $this->validator;
                echo view('addTrek', $data);
            }
        }
   

        public function addTrek(){
            helper(['form']);
            $rules = [ ];            
            if($this->validate($rules)){ 

            }else{
                $data['validation'] = $this->validator;
            
                echo view('addTrek',$data);
            }
        }

        public function storetrek(){
      
            helper(['form']);
            $rules = [
                'trek_fee'      => 'required',
                'trek_days'      => 'required',
                'trek_title'      => 'required|is_unique[sg_trekingdetails.trek_title]'
            ];
        
            if($this->validate($rules)){ 
                $TrekModel = new Treklist_model();
                $trek_overview = str_replace('"','\'', $this->request->getVar('trek_overview'));
                $things_carry = str_replace('"','\'', $this->request->getVar('things_carry'));
                $terms = str_replace('"','\'', $this->request->getVar('terms'));
                $mapimage = str_replace('"','\'', $this->request->getVar('map_image'));
                $data = [
                    'trek_title'     => $this->request->getVar('trek_title'),
                    'trek_fee'    => $this->request->getVar('trek_fee'),                
                    'trek_days' =>$this->request->getVar('trek_days'),
                    'trek_overview'=> htmlspecialchars($trek_overview, ENT_QUOTES),
                    'things_carry' => htmlspecialchars($things_carry, ENT_QUOTES),
                    'terms' => htmlspecialchars($terms, ENT_QUOTES),
                    'map_image' => htmlspecialchars($mapimage, ENT_QUOTES),
                    'created_date' =>date('Y-m-d H:i:s'),
                    'created_by' =>1,
                    'status' =>0
                ];
                // var_dump($data);die();
                $a = $TrekModel->addtrek($data);
                //print_r($a);exit;
                if($a->status ==200){
                    $treks['treks'] = $TrekModel->getTrekLists(); 
                    return view('treklist_view',$treks); 
                }else{

                    $data['validation'] = $this->validator;
                    return $this->response->redirect(base_url('/addTrek/'),$data);
                }
                
            }else{
                $data['validation'] = $this->validator;
                echo view('addTrek', $data);
            }
        }

        public function updateTrek()   {
            $TrekModel = new Treklist_model();
            helper(['form']);
            $rules = [
                'trek_id'      => 'required'
            ];
          
            if($this->validate($rules)){           

                $trek_overview = str_replace('"','\'', $this->request->getVar('trek_overview'));
                $things_carry = str_replace('"','\'', $this->request->getVar('things_carry'));
                $terms = str_replace('"','\'', $this->request->getVar('terms'));
                $mapimage = str_replace('"','\'', $this->request->getVar('map_image'));
                $data = [
                    'trek_id'    => $this->request->getVar('trek_id'),
                    'trek_title'    => $this->request->getVar('trek_title'),
                    'trek_overview'=> htmlspecialchars($trek_overview, ENT_QUOTES),
                    'things_carry' => htmlspecialchars($things_carry, ENT_QUOTES),
                    'terms' => htmlspecialchars($terms, ENT_QUOTES),
                    'map_image' => htmlspecialchars($mapimage, ENT_QUOTES),
                    'modified_date' =>date('Y-m-d H:i:s'),
                    'modified_by' =>1,
                ];
               
               $a = $TrekModel->updateTrek($data);
              
                    $treks['treks'] = $TrekModel->getTrekLists(); 
                    return view('treklist_view',$treks);                
              
                // return redirect()->to('/treklist_view');
            }else{
                $rules = [];
                $trek = (array) $TrekModel->getTrek($trek_id);           
                if($trek['status'] =200){
                     $data['result']  = $trek['trek_details']->treks;
                }
                if($this->validate($rules)){}
                else{
                    $data['Headding']="Edit Trek";
                    $data['validation'] = $this->validator;
                    echo view('edittrek', $data);
                }
            }    
        }

        public  function gettrek($trek_id=''){
            $TrekModel = new Treklist_model();
            helper(['form']);
            $rules = [ ];
            $trek = (array) $TrekModel->getTrek($trek_id);
            if($trek['status'] =200){
                 $data['result']  = $trek['trek_details']->treks;
            }
            
            $data['Headding']="Edit Trek";
            if($this->validate($rules)){}else{
                $data['validation'] = $this->validator;
            }
            echo view('edittrek',$data);
        }

        function fileupload(){
      
            $file = $this->request->getFile('file');
            $foldername = $this->request->getvar('foldername');
           if ($file) {
              if (!$_FILES['file']['error']) {
                $name = md5(rand(100, 200));
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $filename = $name.'.'.$ext;

               $file->move(baseimgURL.$foldername.'/', $filename);
              
                echo SITEURL.$foldername.'/'.$filename; //change this URL
              } else {
                echo $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
              }
        }
        
    }



     
    }