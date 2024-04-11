<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapBeli08 extends Model
{
    public function trxDebet($sampai, $suppno)
    {
        if ($suppno == 'ALL') {
            return $this->db->table('tbl_purchinv')
                ->where('tgl_invoice <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_purchinv')
                ->where('tgl_invoice <=', $sampai)
                ->where('kode_supplier =', $suppno)
                ->get()->getResultArray();
        }
    }

    public function trxCredit($sampai, $suppno)
    {
        if ($suppno == 'ALL') {
            return $this->db->table('tbl_detail_payment')
                ->select('no_invoice, sum(jumlah_bayar+potongan) as totbyr')
                ->join('tbl_payment', 'tbl_detail_payment.no_payment = tbl_payment.no_payment')
                ->groupBy('tbl_detail_payment.no_invoice')
                ->where('tgl_payment <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_payment')
                ->select('no_invoice, sum(jumlah_bayar+potongan) as totbyr')
                ->join('tbl_payment', 'tbl_detail_payment.no_payment = tbl_payment.no_payment')
                ->groupBy('tbl_detail_payment.no_invoice')
                ->where('tgl_payment <=', $sampai)
                ->where('kode_supplier =', $suppno)
                ->get()->getResultArray();
        }
    }

    public function clearOutstandingHutang()
    {
        $this->db->table('outstandinghutang')->emptyTable();
    }

    public function insertOutstandingHutang($raw2)
    {
        $this->db->table('outstandinghutang')->insert($raw2);
    }

    public function UpdateOutstandingHutang($raw3)
    {
        $noinvoice = $raw3['no_invoice'];
        $totbayar  = $raw3['total_bayar'];
        $this->db->table('outstandinghutang')
            ->where('no_invoice', $noinvoice)
            ->update($raw3);
    }

    public function getOutstandingHutang()
    {
        return $this->db->table('outstandinghutang')
            ->join('tbl_supplier', 'outstandinghutang.kode_supplier = tbl_supplier.kode_supplier')
            ->where('total_invoice > total_bayar')
            ->orderBy('outstandinghutang.kode_supplier', 'ASC')
            ->orderBy('tgl_invoice', 'ASC')
            ->get()->getResultArray();
    }
}
