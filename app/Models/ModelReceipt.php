<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelReceipt extends Model
{
    public function allData()
    {
        return $this->db->table('tbl_receipt')
            ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_receipt.kode_customer', 'left')
            ->join('tbl_account', 'tbl_account.kode_account = tbl_receipt.kode_account', 'left')
            ->orderBy('tgl_receipt', 'DESC')
            ->orderBy('no_receipt', 'DESC')
            ->get()->getResultArray();
    }

    public function get_pibycust($kode_customer)
    {
        return $this->db->table('tbl_salesinv')
            ->where('total_invoice != (total_bayar+total_retur+total_potongan+total_admin+total_pph23+total_pph4)')
            ->where('tbl_salesinv.kode_customer', $kode_customer)
            ->orderBy('no_invoice', 'asc')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_receipt')->insert($data);
    }

    public function add_detail($data1)
    {
        $this->db->table('tbl_detail_receipt')->insert($data1);
    }

    public function detail($no_receipt)
    {
        return $this->db->table('tbl_receipt')
            ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_receipt.kode_customer', 'left')
            ->join('tbl_account', 'tbl_account.kode_account = tbl_receipt.kode_account', 'left')
            ->where('no_receipt', $no_receipt)
            ->get()->getRowArray();
    }

    public function detail_cr($no_receipt)
    {
        return $this->db->table('tbl_detail_receipt')
            ->join('tbl_salesinv', 'tbl_salesinv.no_invoice = tbl_detail_receipt.no_invoice', 'left')
            ->where('no_receipt', $no_receipt)
            ->orderBy('id_receipt', 'ASC')
            ->get()->getResultArray();
    }

    public function detail_outstanding($kode_customer)
    {
        return $this->db->table('tbl_salesinv')
            ->where('kode_customer', $kode_customer)
            ->where('total_invoice != (total_bayar+total_retur)')
            ->orderBy('tgl_invoice', 'ASC')
            ->get()->getResultArray();
    }

    public function edit($data)
    {
        $this->db->table('tbl_receipt')
            ->where('no_receipt', $data['no_receipt'])
            ->update($data);
    }

    public function edit_detail($data)
    {
        $this->db->table('tbl_detail_receipt')
            ->where('id_receipt', $data['id_receipt'])
            ->update($data);
    }

    public function delete_master($no_receipt)
    {
        $this->db->table('tbl_receipt')
            ->where('no_receipt', $no_receipt)
            ->delete();
    }

    public function delete_detail($no_receipt)
    {
        $this->db->table('tbl_detail_receipt')
            ->where('no_receipt', $no_receipt)
            ->delete();
    }



    public function pelunasan()
    {
        return $this->db->table('tbl_detail_receipt')
            ->select('no_invoice, sum(potongan) as totpot, sum(jumlah_bayar) as totbyr')
            ->groupBy('no_invoice')
            ->get()->getResultArray();
    }

    public function updateSaldo($raw1)
    {
        $this->db->table('tbl_salesinv')
            ->where('no_invoice', $raw1['no_invoice'])
            ->update($raw1);
    }

    public function clearSaldo($data)
    {
        $this->db->table('tbl_salesinv')
            ->where('no_invoice', $data['no_invoice'])
            ->update($data);
    }
}
