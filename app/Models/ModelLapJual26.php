<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual26 extends Model
{
    public function lapjual26($dari, $sampai)
    {
            return $this->db->table('tbl_salesinv')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)               
                ->where('tbl_salesinv.kodejual =', 'DP')
                ->orderBy('tgl_invoice')
                ->get()->getResultArray();
    }
}
