<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapBeli10 extends Model
{
    public function lapbeli10($dari, $sampai, $kodedivisi, $typelap)
    {
        if ($typelap == "REKAP") {
            return $this->db->table('tbl_purchinv')
                ->join('tbl_supplier', 'tbl_purchinv.kode_supplier = tbl_supplier.kode_supplier')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->where('tbl_purchinv.kode_divisi =', $kodedivisi)
                ->orderBy('tgl_invoice')
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_purchinv')
                ->join('tbl_purchinv', 'tbl_detail_purchinv.no_invoice = tbl_purchinv.no_invoice')
                ->join('tbl_supplier', 'tbl_purchinv.kode_supplier = tbl_supplier.kode_supplier')
                ->join('tbl_barang', 'tbl_detail_purchinv.kode_barang = tbl_barang.kode_barang')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->where('tbl_purchinv.kode_divisi =', $kodedivisi)
                ->orderBy('tgl_invoice')
                ->orderBy('tbl_detail_purchinv.no_invoice')
                ->get()->getResultArray();
        }
    }
}