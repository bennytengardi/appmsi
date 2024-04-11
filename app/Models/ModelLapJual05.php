<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual05 extends Model
{
    public function lapjual05($dari, $sampai, $kodecust)
    {
        if ($kodecust == 'ALL') {
            return $this->db->table('tbl_detail_receipt')
                ->join('tbl_salesinv', 'tbl_detail_receipt.no_invoice = tbl_salesinv.no_invoice')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->join('tbl_receipt', 'tbl_detail_receipt.no_receipt = tbl_receipt.no_receipt')
                ->where('tgl_receipt >=', $dari)
                ->where('tgl_receipt <=', $sampai)
                ->orderBy('tbl_receipt.kode_customer')
                ->orderBy('tgl_receipt')
                ->orderBy('tbl_detail_receipt.no_receipt')
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_receipt')
                ->join('tbl_salesinv', 'tbl_detail_receipt.no_invoice = tbl_salesinv.no_invoice')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->join('tbl_receipt', 'tbl_detail_receipt.no_receipt = tbl_receipt.no_receipt')
                ->where('tgl_receipt >=', $dari)
                ->where('tgl_receipt <=', $sampai)
                ->where('tbl_receipt.kode_customer =', $kodecust)
                ->orderBy('tbl_receipt.kode_customer')
                ->orderBy('tgl_receipt')
                ->orderBy('tbl_detail_receipt.no_receipt')
                ->get()->getResultArray();
        }
    }
}
