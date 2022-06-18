<?php
class ItemModel extends CI_Model
{
    public function allFormData()
    {
        $db_res['brands'] = $this->db->get('brand')->result_array();
        $db_res['models'] = $this->db->get('models')->result_array();
        return $db_res;
    }
    public function modelListExitBrandId($id)
    {
        $this->db->where('brand_id', $id);
        return $db_res = $this->db->get('models')->result_array();
    }

    //insert Data in database=========================
    public function store($data)
    {

        $this->db->where('brand_id', $data['brand_id']);
        $this->db->where('model_id', $data['model_id']);
        $this->db->where('name', $data['name']);
        $dupdicateResultCheck = $this->db->get('items')->row_array();
        if ($dupdicateResultCheck) {
            return "duplicate";
        } else {
            $res = $this->db->insert('items', $data);
            if ($res) {
                return "success";
            }
        }
    }

    public function showItem()
    {
        $res = $this->db
            ->select('i.id,i.name,DATE_FORMAT(i.entry_date,"%d-%m-%Y") as "entry_date",m.name as model_name,b.name as brandname')
            ->from('items as i')
            ->join('models as m', 'i.model_id=m.id', 'left')
            ->join('brand as b', 'b.id = i.brand_id', 'left')
            ->order_by('i.entry_date', 'DESC')
            ->get();



        // echo $this->db->last_query();
        // exit;
        return $query = $res->result_array();
    }
    public function delete($id)
    {
        $db_res = $this->db->where('id', $id)->delete('items');
        if ($db_res) {
            return "success";
        } else {
            return "error";
        }
    }

    //=================retrive edite data ==========
    public function editFormData($id)
    {
        $db_res['item'] = $this->db->where('id', $id)->get('items')->row_array();
        $db_res['brands'] = $this->db->get('brand')->result_array();
        $db_res['models'] = $this->db->get('models')->result_array();
        return $db_res;
    }
    //update Item goes there==================
    public function updateItem($id, $data)
    {
        $duplicate = $this->db
            ->where('id !=', $id)
            ->where('name', $data['name'])
            ->where('brand_id', $data['brand_id'])
            ->where('model_id', $data['model_id'])
            ->get('items')
            ->row_array();
        if ($duplicate) {
            return "duplicate";
        } else {
            $res = $this->db->where('id', $id)->update('items', $data);
            if ($res) {
                return "success";
            } else {
                return "error";
            }
        }
    }
}
