<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual16 extends Model
{
    public function lapjual16($dari, $sampai, $kodecust)
    {
        return $this->db->table('tbl_salesinv')
            ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
            ->where('tgl_invoice >=', $dari)
            ->where('tgl_invoice <=', $sampai)
            ->where('tbl_salesinv.kode_customer =', $kodecust)
            ->orderBy('tgl_invoice')
            ->get()->getResultArray();
    }
}
