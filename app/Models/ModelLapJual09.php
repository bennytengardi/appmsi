<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual09 extends Model
{
    public function lapjual09($dari, $sampai, $kodesales, $kodedivisi,$typelap)
    {
        if ($typelap == "REKAP") {
            if ($kodesales == 'ALL') {
                return $this->db->table('tbl_salesinv')
                    ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                    ->join('tbl_salesman', 'tbl_salesinv.kode_salesman = tbl_salesman.kode_salesman')
                    ->where('tgl_invoice >=', $dari)
                    ->where('tgl_invoice <=', $sampai)
                    ->where('tbl_salesinv.kode_divisi =', $kodedivisi)
                    ->orderBy('tbl_salesinv.kode_salesman')
                    ->orderBy('tgl_invoice')
                    ->get()->getResultArray();
            } else {
                return $this->db->table('tbl_salesinv')
                    ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                    ->join('tbl_salesman', 'tbl_salesinv.kode_salesman = tbl_salesman.kode_salesman')
                    ->where('tgl_invoice >=', $dari)
                    ->where('tgl_invoice <=', $sampai)
                    ->where('tbl_salesinv.kode_salesman =', $kodesales)
                    ->where('tbl_salesinv.kode_divisi =', $kodedivisi)
                    ->orderBy('tbl_salesinv.kode_salesman')
                    ->orderBy('tgl_invoice')
                    ->get()->getResultArray();
            }
        } else {
            if ($kodesales != 'ALL') {
                return $this->db->table('tbl_detail_salesinv')
                    ->join('tbl_salesinv', 'tbl_detail_salesinv.no_invoice = tbl_salesinv.no_invoice')
                    ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                    ->join('tbl_salesman', 'tbl_salesinv.kode_salesman = tbl_salesman.kode_salesman')
                    ->join('tbl_barang', 'tbl_detail_salesinv.id_barang = tbl_barang.id_barang')
                    ->where('tgl_invoice >=', $dari)
                    ->where('tgl_invoice <=', $sampai)
                    ->where('tbl_salesinv.kode_salesman =', $kodesales)
                    ->where('tbl_salesinv.kode_divisi =', $kodedivisi)
                    ->orderBy('tbl_salesinv.kode_salesman')
                    ->orderBy('tgl_invoice')
                    ->orderBy('tbl_detail_salesinv.no_invoice')
                    ->get()->getResultArray();
            } else {
                return $this->db->table('tbl_detail_salesinv')
                    ->join('tbl_salesinv', 'tbl_detail_salesinv.no_invoice = tbl_salesinv.no_invoice')
                    ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                    ->join('tbl_salesman', 'tbl_salesinv.kode_salesman = tbl_salesman.kode_salesman')
                    ->join('tbl_barang', 'tbl_detail_salesinv.id_barang = tbl_barang.id_barang')
                    ->where('tgl_invoice >=', $dari)
                    ->where('tgl_invoice <=', $sampai)
                    ->where('tbl_salesinv.kode_divisi =', $kodedivisi)
                    ->orderBy('tbl_salesinv.kode_salesman')
                    ->orderBy('tgl_invoice')
                    ->orderBy('tbl_detail_salesinv.no_invoice')
                    ->get()->getResultArray();
            }
        }
    }
}
