<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTandaTerima extends Model
{
    public function allData()
    {
        return $this->db->table('tbl_tandaterima')
            ->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_tandaterima.kode_supplier', 'left')
            ->orderBy('tgl_tandaterima', 'DESC')
            ->orderBy('no_tandaterima', 'DESC')
            ->get()->getResultArray();
    }

    public function get_pibysupp($kode_supplier)
    {
        return $this->db->table('tbl_purchinv')
            ->where('total_invoice > total_tt')
            ->where('tbl_purchinv.kode_supplier', $kode_supplier)
            ->orderBy('no_invoice', 'asc')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_tandaterima')->insert($data);
    }

    public function add_detail($data1)
    {
        $this->db->table('tbl_detail_tandaterima')->insert($data1);
    }

    public function detail($no_tandaterima)
    {
        return $this->db->table('tbl_tandaterima')
            ->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_tandaterima.kode_supplier', 'left')
            ->where('no_tandaterima', $no_tandaterima)
            ->get()->getRowArray();
    }

    public function detail_tt($no_tandaterima)
    {
        return $this->db->table('tbl_detail_tandaterima')
            ->join('tbl_purchinv', 'tbl_purchinv.no_invoice = tbl_detail_tandaterima.no_invoice', 'left')
            ->where('no_tandaterima', $no_tandaterima)
            ->orderBy('id_tandaterima', 'ASC')
            ->get()->getResultArray();
    }

    public function edit($data)
    {
        $this->db->table('tbl_tandaterima')
            ->where('no_tandaterima', $data['no_tandaterima'])
            ->update($data);
    }

    public function edit_detail($data)
    {
        $this->db->table('tbl_detail_tandaterima')
            ->where('id_tandaterima', $data['id_tandaterima'])
            ->update($data);
    }

    public function delete_master($no_tandaterima)
    {
        $this->db->table('tbl_tandaterima')
            ->where('no_tandaterima', $no_tandaterima)
            ->delete();
    }

    public function delete_detail($no_tandaterima)
    {
        $this->db->table('tbl_detail_tandaterima')
            ->where('no_tandaterima', $no_tandaterima)
            ->delete();
    }
}
