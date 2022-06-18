<?php
class ModelsModel extends CI_Model
{
    public function store($data)
    {
        $allDataCount = $this->db->count_all_results('models');
        if ($allDataCount == 0) {
            $res = $this->db->insert('models', $data);
            if ($res) {
                return "success";
            } else {
                return "error";
            }
        } else {
            
            $this->db->where('brand_id', $data['brand_id']);
            $this->db->where('name', $data['name']);
            $dupdicateResultCheck = $this->db->get('models')->row_array();



            if ($dupdicateResultCheck) {
                return  "duplicateData";
            } else {
                $res = $this->db->insert('models', $data);
                if ($res) {
                    return "success";
                }
            }
        }
    }
    public function allData(){
        $result['models'] = $this->db->select('id,brand_id,name,DATE_FORMAT(entry_date,"%d/%m/%y") as entry_date')->get('models')->result_array();
        $result['brand'] = $this->db->get('brand')->result_array();
        return $result;
        
    }
    public function editModel($id){
        $result['models'] = $this->db->where('id', $id)->get('models')->row_array();
        $result['brand'] = $this->db->get('brand')->result_array();
        return $result;
        
    }

    public function updateModel($id, $data){
        $duplicate = $this->db
        ->where('id !=', $id)
        ->where('name', $data['name'])
        ->where('brand_id', $data['brand_id'])
        ->get('models')
        ->row_array();
        if($duplicate){
            return "duplicate";
        }else{
            $res = $this->db->where('id', $id)->update('models', $data);
        if ($res) {
            return "success";
        }else{
            return "error";
        }
        }
        
    }

    public function delete($id){
        $res = $this->db->where('id', $id)->delete('models');
        if($res){
            return "success";
        }
    }
}
