<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapKeu03 extends Model
{
    public function rugiLaba($dari, $sampai)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->select('kode_account, sum(debet) as dbt, sum(credit) as crd')
            ->groupBy('kode_account')
            ->where('tgl_voucher >=', $dari)
            ->where('tgl_voucher <=', $sampai)
            ->where('kode_account >=', '4000.000')
            ->get()->getResultArray();
    }

    public function updateSaldo($raw1)
    {
        $this->db->table('tbl_account')
            ->where('kode_account', $raw1['kode_account'])
            ->update($raw1);
    }
}
