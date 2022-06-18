<?php 
class ImageController extends CI_Controller{

    public function index(){
        $this->load->view('image/image');
    }
    public function store(){
        if(isset($_FILES["image"]["name"]))  
           {  
                // echo json_encode($_FILES["image"]["name"]);
                $config['upload_path'] = './assets/images';  
                $config['allowed_types'] = 'jpg|jpeg|png|gif';  
                $this->load->library('upload', $config);  
                if(!$this->upload->do_upload('image'))  
                {  
                     echo $this->upload->display_errors();  
                }  
                else  
                {  
                    $data = $this->upload->data(); print_r($data);  exit;
                     echo '<img src="'.base_url().'assets/images/'.$data["file_name"].'" width="300" height="225" class="img-thumbnail" />';  
                }  
           }
    }

   
}