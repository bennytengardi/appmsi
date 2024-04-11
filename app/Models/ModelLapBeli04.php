<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapBeli04 extends Model
{
    public function lapbeli04($dari, $sampai, $kodesupp)
    {
        if ($kodesupp == 'ALL') {
            return $this->db->table('tbl_detail_purchinv')
                ->select('tbl_purchinv.kode_supplier, nama_supplier,address1,tbl_detail_purchinv.kode_baku,nama_baku, sum(qty) as totqty,sum(qty*harga) as totrp')
                ->join('tbl_baku', 'tbl_detail_purchinv.kode_baku = tbl_baku.kode_baku')
                ->join('tbl_purchinv', 'tbl_detail_purchinv.no_invoice = tbl_purchinv.no_invoice')
                ->join('tbl_supplier', 'tbl_purchinv.kode_supplier = tbl_supplier.kode_supplier')
                ->groupBy('tbl_purchinv.kode_supplier')
                ->groupBy('tbl_detail_purchinv.kode_baku')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_purchinv')
                ->select('tbl_purchinv.kode_supplier,nama_supplier,tbl_detail_purchinv.kode_baku.nama_baku, sum(qty) as totqty,sum(qty*harga) as totrp')
                ->join('tbl_baku', 'tbl_detail_purchinv.kode_baku = tbl_baku.kode_baku')
                ->join('tbl_purchinv', 'tbl_detail_purchinv.no_invoice = tbl_purchinv.no_invoice')
                ->join('tbl_supplier', 'tbl_purchinv.kode_supplier = tbl_supplier.kode_supplier')
                ->groupBy('tbl_purchinv.kode_supplier')
                ->groupBy('tbl_detail_purchinv.kode_baku')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->where('tbl_purchinv.kode_supplier =', $kodesupp)
                ->get()->getResultArray();
        }
    }
}
