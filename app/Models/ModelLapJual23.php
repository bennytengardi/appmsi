<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual23 extends Model
{
    public function lapjual23($dari, $sampai,$kodedivisi, $typelap)
    {
        if ($typelap == "REKAP") {
            return $this->db->table('tbl_suratjln')
                ->join('tbl_customer', 'tbl_suratjln.kode_customer = tbl_customer.kode_customer')
                ->where('tgl_suratjln >=', $dari)
                ->where('tgl_suratjln <=', $sampai)
                ->where('tbl_suratjln.kode_divisi =', $kodedivisi)
                ->orderBy('tgl_suratjln')
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_suratjln')
                ->join('tbl_suratjln', 'tbl_detail_suratjln.no_suratjln = tbl_suratjln.no_suratjln')
                ->join('tbl_customer', 'tbl_suratjln.kode_customer = tbl_customer.kode_customer')
                ->join('tbl_barang', 'tbl_detail_suratjln.kode_barang = tbl_barang.kode_barang')
                ->where('tgl_suratjln >=', $dari)
                ->where('tgl_suratjln <=', $sampai)
                ->where('tbl_suratjln.kode_divisi =', $kodedivisi)
                ->orderBy('tgl_suratjln')
                ->orderBy('tbl_detail_suratjln.no_suratjln')
                ->get()->getResultArray();
        }
    }
}
