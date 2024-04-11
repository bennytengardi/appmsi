<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdjustment extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_adjustment')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_adjustment.kode_barang', 'left')
            ->orderBy('no_adjustment', 'DESC')
            ->get()->getResultArray();
    }

    public function detail($no_adjustment)
    {
        return $this->db->table('tbl_adjustment')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_adjustment.kode_barang', 'left')
            ->where('no_adjustment', $no_adjustment)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_adjustment')->insert($data);
    }


    public function edit($data)
    {
        $this->db->table('tbl_adjustment')
            ->where('no_adjustment', $data['no_adjustment'])
            ->update($data);
    }


    public function hapus($no_adjustment)
    {
        $this->db->table('tbl_adjustment')
            ->where('no_adjustment', $no_adjustment)
            ->delete();
    }
}
