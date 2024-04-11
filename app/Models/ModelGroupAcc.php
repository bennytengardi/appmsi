<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelGroupAcc extends Model
{
    public function allData()
    {
        return $this->db->table('tbl_groupacc')
            ->orderBy('kode_group', 'ASC')
            ->get()->getResultArray();
    }
}
