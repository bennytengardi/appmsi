<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual02 extends Model
{
    public function lapjual02($dari, $sampai, $kodecust, $typelap)
    {
        if ($typelap == "REKAP") {
            if ($kodecust != 'ALL') {
                return $this->db->table('tbl_salesinv')
                    ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                    ->where('tgl_invoice >=', $dari)
                    ->where('tgl_invoice <=', $sampai)
                    ->where('tbl_salesinv.kode_customer =', $kodecust)
                    ->orderBy('tbl_salesinv.kode_customer')
                    ->orderBy('tgl_invoice')
                    ->get()->getResultArray();
            } else {
                return $this->db->table('tbl_salesinv')
                    ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                    ->where('tgl_invoice >=', $dari)
                    ->where('tgl_invoice <=', $sampai)
                    ->orderBy('tbl_salesinv.kode_customer')
                    ->orderBy('tgl_invoice')
                    ->get()->getResultArray();
            }
        } else {
            if ($kodecust != 'ALL') {
                return $this->db->table('tbl_detail_salesinv')
                    ->join('tbl_salesinv', 'tbl_detail_salesinv.no_invoice = tbl_salesinv.no_invoice')
                    ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                    ->join('tbl_barang', 'tbl_detail_salesinv.id_barang = tbl_barang.id_barang')
                    ->where('tgl_invoice >=', $dari)
                    ->where('tgl_invoice <=', $sampai)
                    ->where('tbl_salesinv.kode_customer =', $kodecust)
                    ->orderBy('tbl_salesinv.kode_customer')
                    ->orderBy('tgl_invoice')
                    ->orderBy('tbl_detail_salesinv.no_invoice')
                    ->get()->getResultArray();
            } else {
                return $this->db->table('tbl_detail_salesinv')
                    ->join('tbl_salesinv', 'tbl_detail_salesinv.no_invoice = tbl_salesinv.no_invoice')
                    ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                    ->join('tbl_barang', 'tbl_detail_salesinv.kode_barang = tbl_barang.kode_barang')
                    ->where('tgl_invoice >=', $dari)
                    ->where('tgl_invoice <=', $sampai)
                    ->orderBy('tbl_salesinv.kode_customer')
                    ->orderBy('tgl_invoice')
                    ->orderBy('tbl_detail_salesinv.no_invoice')
                    ->get()->getResultArray();
            }
        }
    }
}
