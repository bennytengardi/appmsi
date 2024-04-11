<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual03 extends Model
{
    public function lapjual03($dari, $sampai, $kodebrg, $typelap)
    {
        return $this->db->table('tbl_detail_salesinv')
            ->select('tbl_detail_salesinv.kode_barang,nama_barang,kode_satuan, sum(qty) as totqty,sum(qty*harga) as totrp')
            ->join('tbl_barang', 'tbl_detail_salesinv.id_barang = tbl_barang.id_barang')
            ->join('tbl_salesinv', 'tbl_detail_salesinv.no_invoice = tbl_salesinv.no_invoice')
            ->groupBy('tbl_detail_salesinv.kode_barang')
            ->where('tgl_invoice >=', $dari)
            ->where('tgl_invoice <=', $sampai)
            ->get()->getResultArray();
     }
}
