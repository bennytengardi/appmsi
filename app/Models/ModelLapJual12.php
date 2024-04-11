<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual12 extends Model
{
    public function lapjual12($dari, $sampai, $kodesales)
    {

        if ($kodesales == 'ALL') {
            return $this->db->table('tbl_detail_receipt')
                ->join('tbl_salesinv', 'tbl_detail_receipt.no_invoice = tbl_salesinv.no_invoice')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->join('tbl_salesman', 'tbl_customer.kode_salesman = tbl_salesman.kode_salesman')
                ->join('tbl_receipt', 'tbl_detail_receipt.no_receipt = tbl_receipt.no_receipt')
                ->where('tgl_receipt >=', $dari)
                ->where('tgl_receipt <=', $sampai)
                ->orderBy('tbl_customer.kode_salesman')
                ->orderBy('tbl_receipt.kode_customer')
                ->orderBy('tgl_receipt')
                ->orderBy('tbl_detail_receipt.no_receipt')
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_receipt')
                ->join('tbl_salesinv', 'tbl_detail_receipt.no_invoice = tbl_salesinv.no_invoice')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->join('tbl_salesman', 'tbl_customer.kode_salesman = tbl_salesman.kode_salesman')
                ->join('tbl_receipt', 'tbl_detail_receipt.no_receipt = tbl_receipt.no_receipt')
                ->where('tgl_receipt >=', $dari)
                ->where('tgl_receipt <=', $sampai)
                ->where('tbl_salesman.kode_salesman =', $kodesales)
                ->orderBy('tbl_customer.kode_salesman')
                ->orderBy('tbl_receipt.kode_customer')
                ->orderBy('tgl_receipt')
                ->orderBy('tbl_detail_receipt.no_receipt')
                ->get()->getResultArray();
        }
    }
}
