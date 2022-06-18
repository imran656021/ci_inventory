<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BrandController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('BrandModel', '', true);
	}
	public function index()
	{
		$this->load->view('brands/list');
	}
	public function allData(){
		$allData = $this->BrandModel->allData();
		$response['allData'] = $allData;
		echo json_encode($response);
	}

	public function store()
	{
		$this->load->library('form_validation');
		// $this->form_validation->set_rules('name', 'Name', 'reqiured');
		$this->form_validation->set_rules('name', 'Name', 'required|is_unique[brand.name]|max_length[50]|alpha_numeric');
		if ($this->form_validation->run() == true) {
			$response['status'] = 1;
			$data['name'] = $this->input->post('name');
			$data['entry_date'] =  date('Y-m-d H:i:s');
			$response['insertId'] = $this->BrandModel->store($data);
			if (!empty($response['insertId'])) {
				$response['db_res'] = "Data Insert Successfully";
			} else {
				$response['db_res'] = "Something went wrong";
			}
		} else {
			$response['status'] = 0;
			$response['nameError'] = strip_tags(form_error('name'));
		}

		echo json_encode($response);
		// echo $name = $this->input->post('name');
	}


	public function singleData($id)
	{
		$dbSingleData = $this->BrandModel->singleData($id);
		$response['row'] = $dbSingleData;
		echo json_encode($response);
	}
	public function deleteBrand($id)
	{
		
		$deleteBrand = $this->BrandModel->deleteBrand($id);
		if (!empty($deleteBrand)) {
			$response['deleteBrand'] = $deleteBrand;
		}
		echo json_encode($response);

	}

	//==================edite part ===============

	// 
	public function updateBrand(){
		$id = $this->input->post('id');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required');
		if ($this->form_validation->run() == true) {
			$response['status'] = 1;
			$data['name'] = $this->input->post('name');
			//model call 
			$response['db_res'] = $this->BrandModel->updateBrand($id, $data);
			
		} else {
			$response['status'] = 0;
			$response['nameError'] = strip_tags(form_error('name'));
		}

		echo json_encode($response);

	}
}
