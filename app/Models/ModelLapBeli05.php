<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapBeli05 extends Model
{
    public function lapbeli05($dari, $sampai, $kodesupp)
    {
        if ($kodesupp == 'ALL') {
            return $this->db->table('tbl_detail_payment')
                ->join('tbl_purchinv', 'tbl_detail_payment.no_invoice = tbl_purchinv.no_invoice')
                ->join('tbl_supplier', 'tbl_purchinv.kode_supplier = tbl_supplier.kode_supplier')
                ->join('tbl_payment', 'tbl_detail_payment.no_payment = tbl_payment.no_payment')
                ->where('tgl_payment >=', $dari)
                ->where('tgl_payment <=', $sampai)
                ->orderBy('tbl_payment.kode_supplier')
                ->orderBy('tgl_payment')
                ->orderBy('tbl_detail_payment.no_payment')
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_payment')
                ->join('tbl_purchinv', 'tbl_detail_payment.no_invoice = tbl_purchinv.no_invoice')
                ->join('tbl_supplier', 'tbl_purchinv.kode_supplier = tbl_supplier.kode_supplier')
                ->join('tbl_payment', 'tbl_detail_payment.no_payment = tbl_payment.no_payment')
                ->where('tgl_payment >=', $dari)
                ->where('tgl_payment <=', $sampai)
                ->where('tbl_payment.kode_supplier =', $kodesupp)
                ->orderBy('tbl_payment.kode_supplier')
                ->orderBy('tgl_payment')
                ->orderBy('tbl_detail_payment.no_payment')
                ->get()->getResultArray();
        }
    }
}
