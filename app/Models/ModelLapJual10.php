<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual10 extends Model
{
    public function lapjual10($dari, $sampai, $kodecust)
    {
        if ($kodecust == 'ALL') {
            return $this->db->table('tbl_detail_salesinv')
                ->select('tbl_salesinv.kode_salesman, nama_salesman,tbl_detail_salesinv.kode_barang,nama_barang, sum(qty) as totqty,sum(qty*harga) as totrp')
                ->select('tbl_salesinv.kode_salesman, nama_salesman,tbl_detail_salesinv.kode_barang,nama_barang, sum(qty) as totqty,sum(qty*harga) as totrp')
                ->select('tbl_customer.kode_salesman, nama_salesman,nama_barang, sum(qty) as totqty,sum(qty*harga) as totrp')
                ->join('tbl_barang', 'tbl_detail_salesinv.kode_barang = tbl_barang.kode_barang')
                ->join('tbl_salesinv', 'tbl_detail_salesinv.no_invoice = tbl_salesinv.no_invoice')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->join('tbl_salesman', 'tbl_customer.kode_salesman = tbl_salesman.kode_salesman')
                ->groupBy('tbl_customer.kode_salesman')
                ->groupBy('tbl_detail_salesinv.kode_barang')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_salesinv')
                ->select('tbl_customer.kode_salesman,nama_salesman,nama_barang, sum(qty) as totqty,sum(qty*harga) as totrp')
                ->join('tbl_barang', 'tbl_detail_salesinv.kode_barang = tbl_barang.kode_barang')
                ->join('tbl_salesinv', 'tbl_detail_salesinv.no_invoice = tbl_salesinv.no_invoice')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->join('tbl_salesman', 'tbl_customer.kode_salesman = tbl_salesman.kode_salesman')
                ->groupBy('tbl_customer.kode_salesman')
                ->groupBy('tbl_detail_salesinv.kode_barang')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->where('tbl_customer.kode_salesman =', $kodecust)
                ->get()->getResultArray();
        }
    }
}
