<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual07 extends Model
{
    public function awalDebet($dari, $custno)
    {
        if ($custno == 'ALL') {
            return $this->db->table('tbl_salesinv')
                ->select('kode_customer, sum(total_invoice) as awldbt')
                ->groupBy('kode_customer')
                ->where('tgl_invoice <', $dari)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_salesinv')
                ->select('kode_customer, sum(total_invoice) as awldbt')
                ->groupBy('kode_customer')
                ->where('tgl_invoice <', $dari)
                ->where('kode_customer =', $custno)
                ->get()->getResultArray();
        }
    }

    public function awalCredit($dari, $custno)
    {
        if ($custno == 'ALL') {
            return $this->db->table('tbl_receipt')
                ->select('kode_customer, sum(total_bayar+total_potongan) as awlcrd')
                ->groupBy('kode_customer')
                ->where('tgl_receipt <', $dari)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_receipt')
                ->select('kode_customer, sum(total_bayar+total_potongan) as awlcrd')
                ->groupBy('kode_customer')
                ->where('tgl_receipt <', $dari)
                ->where('kode_customer =', $custno)
                ->get()->getResultArray();
        }
    }

    public function updateSaldoAwal($raw1)
    {
        $this->db->table('tbl_customer')
            ->where('kode_customer', $raw1['kode_customer'])
            ->update($raw1);
    }

    public function trxDebet($dari, $sampai, $custno)
    {
        if ($custno == 'ALL') {
            return $this->db->table('tbl_salesinv')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_salesinv')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->where('kode_customer =', $custno)
                ->get()->getResultArray();
        }
    }

    public function trxCredit($dari, $sampai, $custno)
    {
        if ($custno == 'ALL') {
            return $this->db->table('tbl_receipt')
                ->where('tgl_receipt >=', $dari)
                ->where('tgl_receipt <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_receipt')
                ->where('tgl_receipt >=', $dari)
                ->where('tgl_receipt <=', $sampai)
                ->where('kode_customer =', $custno)
                ->get()->getResultArray();
        }
    }

    public function clearKartuPiutang()
    {
        $this->db->table('kartupiutang')->emptyTable();
    }

    public function insertKartuPiutang($raw1)
    {
        $this->db->table('kartupiutang')->insert($raw1);
    }

    public function getKartuPiutang()
    {
        return $this->db->table('kartupiutang')
            ->join('tbl_customer', 'kartupiutang.kode_customer = tbl_customer.kode_customer')
            ->orderBy('kartupiutang.kode_customer', 'ASC')
            ->orderBy('tgl_bukti', 'ASC')
            ->orderBy('rectype', 'ASC')
            ->get()->getResultArray();
    }
}
