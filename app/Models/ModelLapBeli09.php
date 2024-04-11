<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapBeli09 extends Model
{

    public function lapbeli09($tahun)
    {
        return $this->db->table('tbl_purchinv')
            ->select('tbl_purchinv.kode_supplier,month(tgl_invoice) as bulan,nama_supplier,sum(total_invoice) as total')
            ->join('tbl_supplier', 'tbl_purchinv.kode_supplier = tbl_supplier.kode_supplier')
            ->where('year(tgl_invoice) =', $tahun)
            ->groupBy('tbl_purchinv.kode_supplier')
            ->groupBy('bulan')
            ->get()->getResultArray();
    }

    public function clearYearlySales()
    {
        $this->db->table('yearlysales')->emptyTable();
    }
}
