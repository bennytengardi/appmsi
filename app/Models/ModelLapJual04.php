<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual04 extends Model
{
    public function lapjual04($dari, $sampai, $kodecust)
    {
        if ($kodecust == 'ALL') {
            return $this->db->table('tbl_detail_salesinv')
                ->select('tbl_salesinv.kode_customer, nama_customer,address1,tbl_detail_salesinv.kode_barang,nama_barang, sum(qty) as totqty,sum(qty*harga) as totrp')
                ->join('tbl_barang', 'tbl_detail_salesinv.kode_barang = tbl_barang.kode_barang')
                ->join('tbl_salesinv', 'tbl_detail_salesinv.no_invoice = tbl_salesinv.no_invoice')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->groupBy('tbl_salesinv.kode_customer')
                ->groupBy('tbl_detail_salesinv.kode_barang')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_salesinv')
                ->select('tbl_salesinv.kode_customer,nama_customer,tbl_detail_salesinv.kode_barang,nama_barang, sum(qty) as totqty,sum(qty*harga) as totrp')
                ->join('tbl_barang', 'tbl_detail_salesinv.id_barang = tbl_barang.id_barang')
                ->join('tbl_salesinv', 'tbl_detail_salesinv.no_invoice = tbl_salesinv.no_invoice')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->groupBy('tbl_salesinv.kode_customer')
                ->groupBy('tbl_detail_salesinv.kode_barang')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->where('tbl_salesinv.kode_customer =', $kodecust)
                ->get()->getResultArray();
        }
    }
}
