<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapBeli03 extends Model
{
    public function lapbeli03($dari, $sampai, $kodebrg, $typelap)
    {
        if ($typelap == "REKAP") {
            return $this->db->table('tbl_detail_purchinv')
                ->select('tbl_detail_purchinv.kode_barang,nama_barang, sum(qty) as totqty,sum(qty*harga) as totrp')
                ->join('tbl_barang', 'tbl_detail_purchinv.kode_barang = tbl_barang.kode_barang')
                ->join('tbl_purchinv', 'tbl_detail_purchinv.no_invoice = tbl_purchinv.no_invoice')
                ->groupBy('tbl_detail_purchinv.kode_barang')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->get()->getResultArray();
        } else {
            if ($kodebrg != 'ALL') {
                return $this->db->table('tbl_detail_purchinv')
                    ->join('tbl_purchinv', 'tbl_detail_purchinv.no_invoice = tbl_purchinv.no_invoice')
                    ->join('tbl_supplier', 'tbl_purchinv.kode_supplier = tbl_supplier.kode_supplier')
                    ->join('tbl_barang', 'tbl_detail_purchinv.kode_barang = tbl_barang.kode_barang')
                    ->where('tgl_invoice >=', $dari)
                    ->where('tgl_invoice <=', $sampai)
                    ->where('tbl_detail_purchinv.kode_barang =', $kodebrg)
                    ->orderBy('tbl_detail_purchinv.kode_barang')
                    ->orderBy('tgl_invoice')
                    ->get()->getResultArray();
            } else {
                return $this->db->table('tbl_detail_purchinv')
                    ->join('tbl_purchinv', 'tbl_detail_purchinv.no_invoice = tbl_purchinv.no_invoice')
                    ->join('tbl_supplier', 'tbl_purchinv.kode_supplier = tbl_supplier.kode_supplier')
                    ->join('tbl_barang', 'tbl_detail_purchinv.kode_barang = tbl_barang.kode_barang')
                    ->where('tgl_invoice >=', $dari)
                    ->where('tgl_invoice <=', $sampai)
                    ->orderBy('tbl_detail_purchinv.kode_barang')
                    ->orderBy('tgl_invoice')
                    ->get()->getResultArray();
            }
        }
    }
}
