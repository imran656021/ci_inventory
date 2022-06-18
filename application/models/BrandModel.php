<?php
class BrandModel extends CI_Model
{
    public function allData()
    {
        // return $res = $this->db->order_by('id', 'DESC')->get('brand')->result_array();
        return $res = $this->db->select('id,name,DATE_FORMAT(entry_date,"%b%d,%Y") as entry_date')->order_by('id', 'DESC')->get('brand')->result_array();
    }
    public function store($data)
    {
        $this->db->insert('brand', $data);
        $insertId = $this->db->insert_id();
        if ($insertId) {
            return $insertId;
        }
    }

    public function singleData($id)
    {
        return $data = $this->db->where('id', $id)->get('brand')->row_array();
    }
    public function allDataCount()
    {
        return $allDataCount = $this->db->count_all_results('brand');
    }
    public function deleteBrand($id)
    {
        $res = $this->db->where('id', $id)->delete('brand');
        if ($res) {
            return "Brand Deleted Successfully";
        } else {
            return "Something Went Worng";
        }
    }
    public function updateBrand($id, $data)
    {
        $duplicate = $this->db
            ->where('id !=', $id)
            ->where('name', $data['name'])
            ->get('brand')
            ->row_array();
        if ($duplicate) {
            return 'duplicate';
        } else {
            $res = $this->db->where('id', $id)->update('brand', $data);

            if ($res) {
                return 'success';
            } else {
                return 'error';
            }
        }
    }
}
