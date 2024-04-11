<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual27 extends Model
{
    public function lapjual27($dari, $sampai)
    {
            return $this->db->table('tbl_salesinv')
                ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)               
                ->orderBy('tgl_invoice')
                ->get()->getResultArray();
    }
}
