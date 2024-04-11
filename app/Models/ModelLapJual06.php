<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual06 extends Model
{
    public function awalDebet($dari)
    {
        return $this->db->table('tbl_salesinv')
            ->select('kode_customer, sum(total_invoice) as awl')
            ->groupBy('kode_customer')
            ->where('tgl_invoice <', $dari)
            ->get()->getResultArray();
    }

    public function awalCredit($dari)
    {
        return $this->db->table('tbl_receipt')
            ->select('kode_customer, sum(total_bayar+total_potongan+total_pph4+total_pph23+total_admin) as awl')
            ->groupBy('kode_customer')
            ->where('tgl_receipt <', $dari)
            ->get()->getResultArray();
    }

    public function trxDebet($dari, $sampai)
    {
        return $this->db->table('tbl_salesinv')
            ->select('kode_customer, sum(total_invoice) as awl')
            ->groupBy('kode_customer')
            ->where('tgl_invoice >=', $dari)
            ->where('tgl_invoice <=', $sampai)
            ->get()->getResultArray();
    }

    public function trxCredit($dari, $sampai)
    {
        return $this->db->table('tbl_receipt')
            ->select('kode_customer, sum(total_bayar+total_potongan+total_pph4+total_pph23+total_admin) as awl')
            ->groupBy('kode_customer')
            ->where('tgl_receipt >=', $dari)
            ->where('tgl_receipt <=', $sampai)
            ->get()->getResultArray();
    }

    public function updateSaldoAwal($raw1)
    {
        $this->db->table('tbl_customer')
            ->where('kode_customer', $raw1['kode_customer'])
            ->update($raw1);
    }
}
