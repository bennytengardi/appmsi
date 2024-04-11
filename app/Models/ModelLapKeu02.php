<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapKeu02 extends Model
{
    public function awalSaldo($dari)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->select('kode_account, sum(debet) as awaldbt, sum(credit) as awalcrd')
            ->groupBy('kode_account')
            ->where('tgl_voucher <', $dari)
            ->where('kode_account <', '4000.000')
            ->get()->getResultArray();
    }

    public function trx($dari, $sampai)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->select('kode_account, sum(debet) as trxdbt, sum(credit) as trxcrd')
            ->groupBy('kode_account')
            ->where('tgl_voucher >=', $dari)
            ->where('tgl_voucher <=', $sampai)
            ->get()->getResultArray();
    }

    public function updateSaldoAwal($raw1)
    {

        $this->db->table('tbl_account')
            ->where('kode_account', $raw1['kode_account'])
            ->update($raw1);
    }
    public function rllalu($tgl3, $tgl4)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->select('sum(credit-debet) as rllalu')
            ->where('tgl_voucher >=', $tgl3)
            ->where('tgl_voucher <=', $tgl4)
            ->where('kode_account >=', '4000.000')
            ->get()->getResultArray();
    }
    public function rlini($tgl4, $tgl2)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->select('sum(credit-debet) as rllalu')
            ->where('tgl_voucher >=', $tgl4)
            ->where('tgl_voucher <=', $tgl2)
            ->where('kode_account >=', '4000.000')
            ->get()->getResultArray();
    }
}
