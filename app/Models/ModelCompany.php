<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCompany extends Model
{
    public function allData()
    {
        return $this->db->table('tbl_company')
            ->orderBy('id_company', 'ASC')
            ->get()->getRowArray();
    }

    public function edit($data)
    {
        $this->db->table('tbl_company')
            ->update($data);
    }
}
