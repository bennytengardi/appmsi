<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual17 extends Model
{
    public function lapjual17($dari, $sampai,$kodedivisi, $typelap)
    {
        if ($typelap == "REKAP") {
            return $this->db->table('tbl_salesinv')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->where('tbl_salesinv.kodejual =', 'SALES')
                ->where('tbl_salesinv.kode_divisi =', $kodedivisi)
                ->orderBy('tgl_invoice')
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_salesinv')
                ->join('tbl_salesinv', 'tbl_detail_salesinv.no_invoice = tbl_salesinv.no_invoice')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->join('tbl_barang', 'tbl_barang.id_barang = tbl_detail_salesinv.id_barang')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->where('tbl_salesinv.kode_divisi =', $kodedivisi)
                ->where('tbl_salesinv.kodejual =', 'SALES')
                ->orderBy('tgl_invoice')
                ->orderBy('tbl_detail_salesinv.no_invoice')
                ->get()->getResultArray();
        }
    }
}
