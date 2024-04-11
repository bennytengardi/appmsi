<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual21 extends Model
{
    public function lapjual21($dari, $sampai,$kodedivisi)
    {
        return $this->db->table('tbl_detail_salesinv')
            ->join('tbl_salesinv', 'tbl_detail_salesinv.no_invoice = tbl_salesinv.no_invoice')
            ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
            ->join('tbl_barang', 'tbl_detail_salesinv.kode_barang = tbl_barang.kode_barang')
            ->where('tgl_invoice >=', $dari)
            ->where('tgl_invoice <=', $sampai)
            ->where('tbl_salesinv.kode_divisi =', $kodedivisi)
            ->orderBy('tgl_invoice')
            ->orderBy('tbl_detail_salesinv.no_invoice')
            ->get()->getResultArray();
    }
}
