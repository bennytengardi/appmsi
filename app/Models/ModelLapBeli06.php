<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapBeli06 extends Model
{
    public function awalDebet($dari)
    {
        return $this->db->table('tbl_purchinv')
            ->select('kode_supplier, sum(total_invoice) as awl')
            ->groupBy('kode_supplier')
            ->where('tgl_invoice <', $dari)
            ->get()->getResultArray();
    }

    public function awalCredit($dari)
    {
        return $this->db->table('tbl_payment')
            ->select('kode_supplier, sum(total_bayar+total_potongan) as awl')
            ->groupBy('kode_supplier')
            ->where('tgl_payment <', $dari)
            ->get()->getResultArray();
    }

    public function trxDebet($dari, $sampai)
    {
        return $this->db->table('tbl_purchinv')
            ->select('kode_supplier, sum(total_invoice) as awl')
            ->groupBy('kode_supplier')
            ->where('tgl_invoice >=', $dari)
            ->where('tgl_invoice <=', $sampai)
            ->get()->getResultArray();
    }

    public function trxCredit($dari, $sampai)
    {
        return $this->db->table('tbl_payment')
            ->select('kode_supplier, sum(total_bayar+total_potongan) as awl')
            ->groupBy('kode_supplier')
            ->where('tgl_payment >=', $dari)
            ->where('tgl_payment <=', $sampai)
            ->get()->getResultArray();
    }

    public function updateSaldoAwal($raw1)
    {
        $this->db->table('tbl_supplier')
            ->where('kode_supplier', $raw1['kode_supplier'])
            ->update($raw1);
    }
}
