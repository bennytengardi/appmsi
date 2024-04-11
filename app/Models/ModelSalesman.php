<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSalesman extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_salesman')
            ->orderBy('kode_salesman', 'DESC')
            ->get()->getResultArray();
    }


    public function detail($kode_salesman)
    {
        return $this->db->table('tbl_salesman')
            ->where('kode_salesman', $kode_salesman)
            ->get()->getRowArray();
    }

    public function getSls($kode_salesman)
    {
        return $this->db->table('tbl_salesman')
            ->where('kode_salesman', $kode_salesman)
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_salesman')->insert($data);
    }


    public function edit($data)
    {
        $this->db->table('tbl_salesman')
            ->where('kode_salesman', $data['kode_salesman'])
            ->update($data);
    }

    public function hapus($kode_salesman)
    {
        $this->db->table('tbl_salesman')
            ->where('kode_salesman', $kode_salesman)
            ->delete();
    }
}
