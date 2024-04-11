<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual18 extends Model
{
    public function lapjual18($dari, $sampai, $kodebrg, $typelap)
    {
        if ($kodebrg != 'ALL') {
            return $this->db->table('tbl_detail_salesinv')
                ->join('tbl_salesinv', 'tbl_detail_salesinv.no_invoice = tbl_salesinv.no_invoice')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->join('tbl_barang', 'tbl_detail_salesinv.kode_barang = tbl_barang.kode_barang')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->where('tbl_detail_salesinv.kode_barang =', $kodebrg)
                ->orderBy('tbl_detail_salesinv.kode_barang')
                ->orderBy('tgl_invoice')
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_salesinv')
                ->join('tbl_salesinv', 'tbl_detail_salesinv.no_invoice = tbl_salesinv.no_invoice')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->join('tbl_barang', 'tbl_detail_salesinv.kode_barang = tbl_barang.kode_barang')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->orderBy('tbl_detail_salesinv.kode_barang')
                ->orderBy('tgl_invoice')
                ->get()->getResultArray();
        }
    }
}
