<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLogHistory extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_loghistory')
            ->orderBy('jamtrx', 'DESC')
            ->get()->getResultArray();
    }
    
    public function add($data)
    {
        $this->db->table('tbl_loghistory')->insert($data);
    }

    public function hapus()
    {
        $this->db->table('tbl_loghistory')->emptyTable();
    }

}
