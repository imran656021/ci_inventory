<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ModelsModel', '', true);
	}
	public function index()
	{
		$this->load->view('models/list');
	}
	public function store()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Model Name', 'required|max_length[100]|alpha_numeric');
		$this->form_validation->set_rules('brand_id', 'Brand Name', 'required');
		//When from validation run=================
		if ($this->form_validation->run()) {
			$response['status'] = 1;
			$data['brand_id'] =  $this->input->post('brand_id');
			$data['name'] = $this->input->post('name');
			$data['entry_date'] =  date('Y-m-d H:i:s');
			// print_r($data);
			$db_res = $this->ModelsModel->store($data);
			if ($db_res) {
				$response['db_res'] = $db_res;
			}
			
		}else{
			//=============================if form validation have some error=========================
			$response['status'] = 0;
			$response['brandIdError'] = strip_tags(form_error('brand_id'));
			$response['nameError'] = strip_tags(form_error('name'));
		}

		echo json_encode($response);
	}
	public function allData(){
		$db_res = $this->ModelsModel->allData();
		// print_r($db_res['brand']); exit;
		
		if($db_res){
			$response['models'] = $db_res['models'];
			$response['brand'] = $db_res['brand'];
			echo json_encode($response);
		}
	}
	public function editModel($id){
		$db_res = $this->ModelsModel->editModel($id);
		// print_r($db_res['brand']); exit;
		
		if($db_res){
			$response['models'] = $db_res['models'];
			$response['brand'] = $db_res['brand'];
			echo json_encode($response);
		}
	}
	public function delete($id){
		
		$db_res = $this->ModelsModel->delete($id);
		if($db_res){
			echo json_encode($db_res);
			
		}
	}
	public  function updateModel(){
		$id = $this->input->post('id');


		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Model Name', 'required|max_length[100]|alpha_numeric');
		$this->form_validation->set_rules('brand_id', 'Brand Name', 'required');
		//When from validation run=================
		if ($this->form_validation->run()) {
			$response['status'] = 1;
			$data['brand_id'] =  $this->input->post('brand_id');
			$data['name'] = $this->input->post('name');
			$data['entry_date'] =  date('Y-m-d H:i:s');
			// print_r($data);
			$db_res = $this->ModelsModel->updateModel($id, $data);
			if ($db_res) {
				$response['db_res'] = $db_res;
			}
			
		}else{
			//=============================if form validation have some error=========================
			$response['status'] = 0;
			$response['brandIdError'] = strip_tags(form_error('brand_id'));
			$response['nameError'] = strip_tags(form_error('name'));
		}

		echo json_encode($response);




		$data['name'] = $this->input->post('name');
		$data['brand_id'] = $this->input->post('brand_id');
	}
}
