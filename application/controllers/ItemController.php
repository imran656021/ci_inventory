<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItemController extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ItemModel');
	}

	public function index()
	{
		$this->load->view('items/list');
	}

	//=====================retrive brands and models list ==============
	public function allFormData(){
		$db_res = $this->ItemModel->allFormData();
		echo json_encode($db_res);
	}

	public function modelListExitBrandId($id){
		$response = $this->ItemModel->modelListExitBrandId($id);
		echo json_encode($response);
	}

	//insert Data in Database==================
	public function store(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|alpha_numeric');
		$this->form_validation->set_rules('brand_id','Brand Id','required');
		$this->form_validation->set_rules('model_id', 'Model Id','required|alpha_numeric');
        if($this->form_validation->run()){
            $data['brand_id'] = $this->input->post('brand_id'); 
            $data['model_id'] = $this->input->post('model_id'); 
            $data['name'] = $this->input->post('name'); 
            $data['entry_date'] = date('Y-m-d H:i:s');

           // ====================models store method call===================
            $db_res = $this->ItemModel->store($data);
			if(!empty($db_res)){
				$response['status'] = 1;
				$response['db_res'] = $db_res;
			}

        }else{
			$response['status'] = 0;
            $response['brand_id_error'] = strip_tags(form_error('brand_id'));
            $response['model_id_error'] = strip_tags(form_error('model_id'));
            $response['name_error'] = strip_tags(form_error('name'));
        }

		echo json_encode($response);
		
	}

	//show Item ========================
	public function showItem(){
		 $response = $this->ItemModel->showItem();
		 echo json_encode($response);
	}

	public function delete($id){
		$response = $this->ItemModel->delete($id);
		echo json_encode($response);
	}
	//retrive edit data===============

	public function editFormData($id){
		$response = $this->ItemModel->editFormData($id);
		echo json_encode($response);
	}

	//update item data ============================
	public function updateItem(){
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('brand_id','Brand Id','required');
		$this->form_validation->set_rules('model_id', 'Model Id','required');
        if($this->form_validation->run()){
			$id = $this->input->post('id');
            $data['brand_id'] = $this->input->post('brand_id'); 
            $data['model_id'] = $this->input->post('model_id'); 
            $data['name'] = $this->input->post('name'); 
            

           // ====================models store method call===================
            $db_res = $this->ItemModel->updateItem($id, $data);
			if(!empty($db_res)){
				$response['status'] = 1;
				$response['db_res'] = $db_res;
			}

        }else{
			$response['status'] = 0;
            $response['brand_id_error'] = strip_tags(form_error('brand_id'));
            $response['model_id_error'] = strip_tags(form_error('model_id'));
            $response['name_error'] = strip_tags(form_error('name'));
        }

		echo json_encode($response);
	}
}
