<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBankBook extends Model
{
    public function awalSaldo($dari, $kodeacct)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->select('kode_account, sum(prime_debet) as awaldbt, sum(prime_credit) as awalcrd')
            ->groupBy('kode_account')
            ->where('tgl_voucher <', $dari)
            ->where('kode_account', $kodeacct)
            ->get()->getRowArray();
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

    public function trx($dari, $sampai, $kodeacct)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->join('tbl_account', 'tbl_detail_jurnal.kode_account = tbl_account.kode_account')
            ->join('tbl_groupacc', 'tbl_account.kode_group = tbl_groupacc.kode_group')
            ->where('tgl_voucher >=', $dari)
            ->where('tgl_voucher <=', $sampai)
            ->where('tbl_detail_jurnal.kode_account', $kodeacct)
            ->get()->getResultArray();
    }

    public function insertBukuBesar($raw1)
    {
         $this->db->table('bukubesar')->insert($raw1);
    }

    public function getBukuBesar()
    {
        return $this->db->table('bukubesar')
            ->join('tbl_account', 'bukubesar.kode_account = tbl_account.kode_account')
            ->join('tbl_groupacc', 'tbl_account.kode_group = tbl_groupacc.kode_group')
            ->orderBy('bukubesar.kode_account', 'ASC')
            ->orderBy('tgl_bukti', 'ASC')
            ->orderBy('tbl_groupacc.rectype', 'ASC')
            ->get()->getResultArray();
    }
}
