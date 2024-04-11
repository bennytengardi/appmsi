<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual13 extends Model
{

    public function lapjual13($tahun)
    {
        return $this->db->table('tbl_salesinv')
            ->select('tbl_salesinv.kode_customer,month(tgl_invoice) as bulan,nama_customer,sum(total_invoice) as total')
            ->join('tbl_customer', 'tbl_salesinv.kode_customer = tbl_customer.kode_customer')
            ->where('year(tgl_invoice) =', $tahun)
            ->groupBy('tbl_salesinv.kode_customer')
            ->groupBy('bulan')
            ->get()->getResultArray();
    }

    public function clearYearlySales()
    {
        $this->db->table('yearlysales')->emptyTable();
    }
}
