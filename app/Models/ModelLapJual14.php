<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual14 extends Model
{
    public function trxDebet($sampai, $custno)
    {
        if ($custno == 'ALL') {
            return $this->db->table('tbl_salesinv')
                ->where('tgl_invoice <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_salesinv')
                ->where('tgl_invoice <=', $sampai)
                ->where('kode_customer =', $custno)
                ->get()->getResultArray();
        }
    }

    public function trxCredit($sampai, $custno)
    {
        if ($custno == 'ALL') {
            return $this->db->table('tbl_detail_receipt')
                ->select('no_invoice, sum(jumlah_bayar+potongan+admin+pph23+pph4) as totbyr')
                ->join('tbl_receipt', 'tbl_detail_receipt.no_receipt = tbl_receipt.no_receipt')
                ->groupBy('tbl_detail_receipt.no_invoice')
                ->where('tgl_receipt <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_receipt')
                ->select('no_invoice, sum(jumlah_bayar+potongan+admin+pph23+pph4) as totbyr')
                ->join('tbl_receipt', 'tbl_detail_receipt.no_receipt = tbl_receipt.no_receipt')
                ->groupBy('tbl_detail_receipt.no_invoice')
                ->where('tgl_receipt <=', $sampai)
                ->where('kode_customer =', $custno)
                ->get()->getResultArray();
        }
    }

    public function trxRetur($sampai, $custno)
    {
        if ($custno == 'ALL') {
            return $this->db->table('tbl_salesrtn')
                ->where('tgl_retur <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_salesrtn')
                ->where('tgl_retur <=', $sampai)
                ->where('kode_customer =', $custno)
                ->get()->getResultArray();
        }
    }


    public function clearOutstandingPiutang()
    {
        $this->db->table('outstandingpiutang')->emptyTable();
    }

    public function insertOutstandingPiutang($raw2)
    {
        $this->db->table('outstandingpiutang')->insert($raw2);
    }

    public function UpdateOutstandingPiutang($raw3)
    {
        $this->db->table('outstandingpiutang')
            ->where('no_invoice', $raw3['no_invoice'])
            ->update($raw3);
    }

    public function getOutstandingPiutang()
    {
        return $this->db->table('outstandingpiutang')
            ->join('tbl_customer', 'outstandingpiutang.kode_customer = tbl_customer.kode_customer')
            ->where('total_invoice > total_bayar+total_retur')
            ->orderBy('nama_customer', 'ASC')
            ->orderBy('outstandingpiutang.kode_customer', 'ASC')
            ->orderBy('tgl_invoice', 'ASC')
            ->get()->getResultArray();
    }
}
