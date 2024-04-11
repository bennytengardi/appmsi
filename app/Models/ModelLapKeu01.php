<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapKeu01 extends Model
{
    public function awalSaldo($dari, $kodeacct, $kodeacct2)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->select('kode_account, sum(debet) as awaldbt, sum(credit) as awalcrd')
            ->groupBy('kode_account')
            ->where('tgl_voucher <', $dari)
            ->where('kode_account >=', $kodeacct)
            ->where('kode_account <=', $kodeacct2)
            ->get()->getResultArray();
    }

    public function updateSaldoAwal($raw1)
    {
        $this->db->table('tbl_account')
            ->where('kode_account', $raw1['kode_account'])
            ->update($raw1);
    }

    public function clearBukuBesar()
    {
        $this->db->table('bukubesar')->emptyTable();
    }


    public function trx($dari, $sampai, $kodeacct, $kodeacct2)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->join('tbl_account', 'tbl_detail_jurnal.kode_account = tbl_account.kode_account')
            ->join('tbl_groupacc', 'tbl_account.kode_group = tbl_groupacc.kode_group')
            ->where('tgl_voucher >=', $dari)
            ->where('tgl_voucher <=', $sampai)
            ->where('tbl_detail_jurnal.kode_account >=', $kodeacct)
            ->where('tbl_detail_jurnal.kode_account <=', $kodeacct2)
            ->get()->getResultArray();
    }


    public function insertBukuBesar($raw1)
    {
        // dd($raw1);
        $this->db->table('bukubesar')->insert($raw1);
    }

    public function getBukuBesar()
    {
        return $this->db->table('bukubesar')
            ->join('tbl_account', 'bukubesar.kode_account = tbl_account.kode_account')
            ->join('tbl_groupacc', 'tbl_account.kode_group = tbl_groupacc.kode_group')
            ->orderBy('bukubesar.kode_account', 'ASC')
            ->orderBy('tgl_bukti', 'ASC')
            ->orderby('tbl_groupacc.rectype', 'ASC')
            ->get()->getResultArray();
    }
}
