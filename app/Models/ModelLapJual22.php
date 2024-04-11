<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual22 extends Model
{
    public function lapjual22($dari, $sampai,$kodedivisi, $typelap)
    {
        if ($typelap == "REKAP") {
            return $this->db->table('tbl_salesord')
                ->join('tbl_customer', 'tbl_salesord.kode_customer = tbl_customer.kode_customer')
                ->where('tgl_so >=', $dari)
                ->where('tgl_so <=', $sampai)
                ->where('tbl_salesord.kode_divisi =', $kodedivisi)
                ->orderBy('tgl_so')
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_salesord')
                ->join('tbl_salesord', 'tbl_detail_salesord.no_so = tbl_salesord.no_so')
                ->join('tbl_customer', 'tbl_salesord.kode_customer = tbl_customer.kode_customer')
                ->join('tbl_barang', 'tbl_detail_salesord.id_barang = tbl_barang.id_barang')
                ->where('tgl_so >=', $dari)
                ->where('tgl_so <=', $sampai)
                ->where('tbl_salesord.kode_divisi =', $kodedivisi)
                ->orderBy('tgl_so')
                ->orderBy('tbl_detail_salesord.no_so')
                ->get()->getResultArray();
        }
    }
}
