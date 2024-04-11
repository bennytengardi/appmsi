<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual19 extends Model
{
    public function lapjual19($dari, $sampai)
    {
        return $this->db->table('tbl_receipt')
            ->join('tbl_customer', 'tbl_receipt.kode_customer = tbl_customer.kode_customer')            
            ->join('tbl_account', 'tbl_receipt.kode_account = tbl_account.kode_account')            
            ->where('tgl_receipt >=', $dari)
            ->where('tgl_receipt <=', $sampai)
            ->orderBy('tgl_receipt')
            ->orderBy('tbl_receipt.kode_customer')
            ->get()->getResultArray();
    }
}
