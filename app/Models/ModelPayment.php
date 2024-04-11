<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPayment extends Model
{
    public function allData()
    {
        return $this->db->table('tbl_payment')
            ->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_payment.kode_supplier', 'left')
            ->join('tbl_account', 'tbl_account.kode_account = tbl_payment.kode_account', 'left')
            ->orderBy('tgl_payment', 'DESC')
            ->orderBy('no_payment', 'DESC')
            ->get()->getResultArray();
    }

    public function get_pibysupp($kode_supplier)
    {
        return $this->db->table('tbl_purchinv')
            ->where('total_invoice  != (total_bayar + total_retur) ')
            ->where('tbl_purchinv.kode_supplier', $kode_supplier)
            ->orderBy('no_invoice', 'asc')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_payment')->insert($data);
    }

    public function add_detail($data1)
    {
        $this->db->table('tbl_detail_payment')->insert($data1);
    }

    public function detail($no_payment)
    {
        return $this->db->table('tbl_payment')
            ->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_payment.kode_supplier', 'left')
            ->join('tbl_account', 'tbl_account.kode_account = tbl_payment.kode_account', 'left')
            ->where('no_payment', $no_payment)
            ->get()->getRowArray();
    }

    public function detail_vp($no_payment)
    {
        return $this->db->table('tbl_detail_payment')
            ->join('tbl_purchinv', 'tbl_purchinv.no_invoice = tbl_detail_payment.no_invoice', 'left')
            ->where('no_payment', $no_payment)
            ->orderBy('id_payment', 'ASC')
            ->get()->getResultArray();
    }

    public function detail_outstanding($kode_supplier)
    {
        return $this->db->table('tbl_purchinv')
            ->where('kode_supplier', $kode_supplier)
            ->where('total_invoice != (total_bayar+total_retur+total_potongan)')
            ->orderBy('tgl_invoice', 'ASC')
            ->get()->getResultArray();
    }


    public function edit($data)
    {
        $this->db->table('tbl_payment')
            ->where('no_payment', $data['no_payment'])
            ->update($data);
    }

    public function edit_detail($data)
    {
        $this->db->table('tbl_detail_payment')
            ->where('id_payment', $data['id_payment'])
            ->update($data);
    }

    public function delete_master($no_payment)
    {
        $this->db->table('tbl_payment')
            ->where('no_payment', $no_payment)
            ->delete();
    }

    public function delete_detail($no_payment)
    {
        $this->db->table('tbl_detail_payment')
            ->where('no_payment', $no_payment)
            ->delete();
    }
}
