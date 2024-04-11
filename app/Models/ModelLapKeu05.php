<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapKeu05 extends Model
{
    public function Neraca($sampai)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->select('kode_account, sum(debet) as dbt, sum(credit) as crd')
            ->groupBy('kode_account')
            ->where('tgl_voucher <=', $sampai)
            ->where('kode_account <', '4000.000')
            ->get()->getResultArray();
    }

    public function Balance()
    {
        return $this->db->table('tbl_account')
            ->select('kode_account,sub_account,sum(saldo_awal) as sldawal, sum(dbt) as slddbt, sum(crd) as sldcrd')
            ->groupBy('kode_account')
            ->where('sub_account <', '4000')
            ->get()->getResultArray();
    }

    public function updateSaldo($raw1)
    {
        $this->db->table('tbl_account')
            ->where('kode_account', $raw1['kode_account'])
            ->update($raw1);
    }

    public function clearNeraca()
    {
        $this->db->table('neraca')->emptyTable();
    }

    public function insertNeraca($data)
    {
        $this->db->table('neraca')->insert($data);
    }


    public function saldoNeraca()
    {
        return $this->db->table('neraca')
            ->join('tbl_account', 'tbl_account.kode_account = neraca.kode_account', 'left')
            ->join('tbl_groupacc', 'tbl_groupacc.kode_group = tbl_account.kode_group', 'left')
            ->orderBy('neraca.rectype', 'ASC')
            ->orderBy('neraca.kode_account', 'ASC')
            ->get()->getResultArray();
    }

    public function rllalu($tgl3, $tgl4)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->select('sum(credit-debet) as rllalu')
            ->where('tgl_voucher >=', $tgl3)
            ->where('tgl_voucher <', $tgl4)
            ->where('kode_account >=', '4000.000')
            ->get()->getResultArray();
    }

    public function rlini($tgl4, $tgl2)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->select('sum(credit-debet) as rlini')
            // ->where('tgl_voucher >', $tgl4)
            ->where('tgl_voucher <=', $tgl2)
            ->where('kode_account >=', '4000.000')
            ->get()->getResultArray();
    }
}
