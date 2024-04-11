<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapBeli07 extends Model
{
    public function awalDebet($dari, $suppno)
    {
        if ($suppno == 'ALL') {
            return $this->db->table('tbl_purchinv')
                ->select('kode_supplier, sum(total_invoice) as awldbt')
                ->groupBy('kode_supplier')
                ->where('tgl_invoice <', $dari)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_purchinv')
                ->select('kode_supplier, sum(total_invoice) as awldbt')
                ->groupBy('kode_supplier')
                ->where('tgl_invoice <', $dari)
                ->where('kode_supplier =', $suppno)
                ->get()->getResultArray();
        }
    }

    public function awalCredit($dari, $suppno)
    {
        if ($suppno == 'ALL') {
            return $this->db->table('tbl_payment')
                ->select('kode_supplier, sum(total_bayar+total_potongan) as awlcrd')
                ->groupBy('kode_supplier')
                ->where('tgl_payment <', $dari)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_payment')
                ->select('kode_supplier, sum(total_bayar+total_potongan) as awlcrd')
                ->groupBy('kode_supplier')
                ->where('tgl_payment <', $dari)
                ->where('kode_supplier =', $suppno)
                ->get()->getResultArray();
        }
    }

    public function updateSaldoAwal($raw1)
    {
        $this->db->table('tbl_supplier')
            ->where('kode_supplier', $raw1['kode_supplier'])
            ->update($raw1);
    }

    public function trxDebet($dari, $sampai, $suppno)
    {
        if ($suppno == 'ALL') {
            return $this->db->table('tbl_purchinv')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_purchinv')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->where('kode_supplier =', $suppno)
                ->get()->getResultArray();
        }
    }

    public function trxCredit($dari, $sampai, $suppno)
    {
        if ($suppno == 'ALL') {
            return $this->db->table('tbl_payment')
                ->where('tgl_payment >=', $dari)
                ->where('tgl_payment <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_payment')
                ->where('tgl_payment >=', $dari)
                ->where('tgl_payment <=', $sampai)
                ->where('kode_supplier =', $suppno)
                ->get()->getResultArray();
        }
    }

    public function clearKartuHutang()
    {
        $this->db->table('kartuhutang')->emptyTable();
    }

    public function insertKartuHutang($raw1)
    {
        $this->db->table('kartuhutang')->insert($raw1);
    }

    public function getKartuHutang()
    {
        return $this->db->table('kartuhutang')
            ->join('tbl_supplier', 'kartuhutang.kode_supplier = tbl_supplier.kode_supplier')
            ->orderBy('kartuhutang.kode_supplier', 'ASC')
            ->orderBy('tgl_bukti', 'ASC')
            ->orderBy('rectype', 'ASC')
            ->get()->getResultArray();
    }
}
