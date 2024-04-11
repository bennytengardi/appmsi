<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDivisi extends Model
{
    protected $table = "tbl_divisi";
    protected $primaryKey = 'kode_divisi';
    protected $allowedFields = ['kode_divisi'];

    public function allData()
    {
        return $this->db->table('tbl_divisi')
            ->orderBy('kode_divisi', 'ASC')
            ->get()->getResultArray();
    }
    
    public function detail($kode_divisi)
    {
        return $this->db->table('tbl_divisi')
            ->where('kode_divisi', $kode_divisi)
            ->get()->getRowArray();
    }

}
