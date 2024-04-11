<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual11 extends Model
{
    public function trxDebet($sampai, $kdsales)
    {
        return $this->db->table('tbl_salesinv')
            ->join('tbl_customer','tbl_customer.kode_customer = tbl_salesinv.kode_customer' )
            ->where('tgl_invoice <=', $sampai)
            ->where('tbl_customer.kode_salesman =', $kdsales)
            ->orderBy('tgl_invoice', 'ASC')
            ->get()->getResultArray();
    }

    public function trxCredit($sampai, $kdsales)
    {
        return $this->db->table('tbl_detail_receipt')
            ->select('tbl_detail_receipt.no_invoice, sum(jumlah_bayar+potongan) as totbyr')
            ->join('tbl_receipt', 'tbl_detail_receipt.no_receipt = tbl_receipt.no_receipt')
            ->join('tbl_salesinv', 'tbl_salesinv.no_invoice = tbl_detail_receipt.no_invoice')
            ->join('tbl_customer','tbl_customer.kode_customer = tbl_salesinv.kode_customer' )
            ->groupBy('tbl_detail_receipt.no_invoice')
            ->where('tbl_customer.kode_salesman =', $kdsales)
            ->where('tgl_receipt <=', $sampai)
            ->get()->getResultArray();
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
            ->where('total_invoice > total_bayar')
            ->orderBy('outstandingpiutang.kode_customer', 'ASC')
            ->orderBy('tgl_invoice', 'ASC')
            ->get()->getResultArray();
    }
}
