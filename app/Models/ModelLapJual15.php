<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual15 extends Model
{
    public function trxDebet($sampai, $kdsales)
    {
        if ($kdsales == 'ALL') {
            return $this->db->table('tbl_salesinv')
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesinv.kode_customer')
                ->where('tgl_invoice <=', $sampai)
                ->orderBy('tgl_invoice', 'ASC')
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_salesinv')
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesinv.kode_customer')
                ->where('tgl_invoice <=', $sampai)
                ->where('tbl_salesinv.kode_salesman =', $kdsales)
                ->orderBy('tgl_invoice', 'ASC')
                ->get()->getResultArray();
        }
    }

    public function trxCredit($sampai, $kdsales)
    {
        if ($kdsales == 'ALL') {
            return $this->db->table('tbl_detail_receipt')
                ->select('tbl_detail_receipt.no_invoice, sum(jumlah_bayar+potongan) as totbyr')
                ->join('tbl_receipt', 'tbl_detail_receipt.no_receipt = tbl_receipt.no_receipt')
                ->join('tbl_salesinv', 'tbl_salesinv.no_invoice = tbl_detail_receipt.no_invoice')
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesinv.kode_customer')
                ->groupBy('tbl_detail_receipt.no_invoice')
                ->where('tgl_receipt <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_receipt')
                ->select('tbl_detail_receipt.no_invoice, sum(jumlah_bayar+potongan) as totbyr')
                ->join('tbl_receipt', 'tbl_detail_receipt.no_receipt = tbl_receipt.no_receipt')
                ->join('tbl_salesinv', 'tbl_salesinv.no_invoice = tbl_detail_receipt.no_invoice')
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesinv.kode_customer')
                ->groupBy('tbl_detail_receipt.no_invoice')
                ->where('tbl_salesinv.kode_salesman =', $kdsales)
                ->where('tgl_receipt <=', $sampai)
                ->get()->getResultArray();
        }
    }

    public function trxRetur($sampai, $kdsales)
    {
        if ($kdsales == 'ALL') {
            return $this->db->table('tbl_salesrtn')
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesrtn.kode_customer')
                ->join('tbl_salesinv', 'tbl_salesinv.no_invoice = tbl_salesrtn.no_invoice')
                ->where('tgl_retur <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_salesrtn')
                ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesrtn.kode_customer')
                ->join('tbl_salesinv', 'tbl_salesinv.no_invoice = tbl_salesrtn.no_invoice')
                ->where('tgl_retur <=', $sampai)
                ->where('tbl_salesinv.kode_salesman =', $kdsales)
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
            ->join('tbl_salesman', 'outstandingpiutang.kode_salesman = tbl_salesman.kode_salesman')
            ->join('tbl_customer', 'outstandingpiutang.kode_customer = tbl_customer.kode_customer')
            ->where('total_invoice > total_bayar + total_retur')
            ->orderBy('outstandingpiutang.kode_salesman', 'ASC')
            ->orderBy('nama_customer', 'ASC')
            ->orderBy('outstandingpiutang.kode_customer', 'ASC')
            ->orderBy('tgl_invoice', 'ASC')
            ->get()->getResultArray();
    }
}
