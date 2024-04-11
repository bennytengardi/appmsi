<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCounter extends Model
{
    public function allData()
    {
        return $this->db->table('tbl_counter')
            ->get()->getRowArray();
    }

    public function edit($data)
    {
        $this->db->table('tbl_counter')
            ->update($data);
    }
    
    public function updctr($data)
    {
        $this->db->table('tbl_counter')
            ->update($data);
    }
}
