<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapStk04 extends Model
{
    public function awalDebet($dari, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_detail_purchinv')
                ->select('kode_baku, sum(qty) as awldbt')
                ->join('tbl_purchinv', 'tbl_detail_purchinv.no_invoice = tbl_purchinv.no_invoice')
                ->groupBy('kode_baku')
                ->where('tgl_invoice <', $dari)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_purchinv')
                ->select('kode_baku, sum(qty) as awldbt')
                ->join('tbl_purchinv', 'tbl_detail_purchinv.no_invoice = tbl_purchinv.no_invoice')
                ->groupBy('kode_baku')
                ->where('tgl_invoice <', $dari)
                ->where('kode_baku =', $kode)
                ->get()->getResultArray();
        }
    }


    public function awalDebet2($dari, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_adjustment')
                ->select('kode_baku, sum(qty) as awldbt2')
                ->groupBy('kode_baku')
                ->where('tgl_adjustment <', $dari)
                ->where('qty >', 0)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_adjustment')
                ->select('kode_baku, sum(qty) as awldbt2')
                ->groupBy('kode_baku')
                ->where('tgl_adjustment <', $dari)
                ->where('kode_baku =', $kode)
                ->where('qty >', 0)
                ->get()->getResultArray();
        }
    }

    public function awalCredit($dari, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_pakai')
                ->select('kode_baku, sum(qty) as awlcrd')
                ->join('tbl_hasil', 'tbl_pakai.no_bukti = tbl_hasil.no_bukti')
                ->groupBy('kode_baku')
                ->where('tgl_bukti <', $dari)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_pakai')
                ->select('kode_baku, sum(qty) as awlcrd')
                ->join('tbl_hasil', 'tbl_pakai.no_bukti = tbl_hasil.no_bukti')
                ->groupBy('kode_baku')
                ->where('tgl_bukti <', $dari)
                ->where('kode_baku =', $kode)
                ->get()->getResultArray();
        }
    }

    public function awalCredit2($dari, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_adjustment')
                ->select('kode_baku, sum(qty) as awlcrd2')
                ->groupBy('kode_baku')
                ->where('tgl_adjustment <', $dari)
                ->where('qty <', 0)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_adjustment')
                ->select('kode_baku, sum(qty) as awlcrd2')
                ->groupBy('kode_baku')
                ->where('tgl_adjustment <', $dari)
                ->where('kode_baku =', $kode)
                ->where('qty <', 0)
                ->get()->getResultArray();
        }
    }

    public function awalCredit3($dari, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_detail_purchrtn')
                ->select('kode_baku, sum(qty) as awlcrd3')
                ->join('tbl_purchrtn', 'tbl_detail_purchrtn.no_retur = tbl_purchrtn.no_retur')
                ->groupBy('kode_baku')
                ->where('tgl_retur <', $dari)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_purchrtn')
                ->select('kode_baku, sum(qty) as awlcrd3')
                ->join('tbl_purchrtn', 'tbl_detail_purchrtn.no_retur = tbl_purchrtn.no_retur')
                ->groupBy('kode_baku')
                ->where('tgl_retur <', $dari)
                ->where('kode_baku =', $kode)
                ->get()->getResultArray();
        }
    }

    public function awalCredit4($dari, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_detail_pakaibaku')
                ->select('kode_baku, sum(qty) as awlcrd4')
                ->join('tbl_pakaibaku', 'tbl_detail_pakaibaku.no_bukti = tbl_pakaibaku.no_bukti')
                ->groupBy('kode_baku')
                ->where('tgl_bukti <', $dari)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_pakaibaku')
                ->select('kode_baku, sum(qty) as awlcrd4')
                ->join('tbl_pakaibaku', 'tbl_detail_pakaibaku.no_bukti = tbl_pakaibaku.no_bukti')
                ->groupBy('kode_baku')
                ->where('tgl_bukti <', $dari)
                ->where('kode_baku =', $kode)
                ->get()->getResultArray();
        }
    }


    public function updateSaldoAwal($raw1)
    {
        $this->db->table('tbl_baku')
            ->where('kode_baku', $raw1['kode_baku'])
            ->update($raw1);
    }

    public function trxDebet($dari, $sampai, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_detail_purchinv')
                ->join('tbl_purchinv', 'tbl_detail_purchinv.no_invoice = tbl_purchinv.no_invoice')
                ->join('tbl_supplier', 'tbl_purchinv.kode_supplier = tbl_supplier.kode_supplier')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_purchinv')
                ->join('tbl_purchinv', 'tbl_detail_purchinv.no_invoice = tbl_purchinv.no_invoice')
                ->join('tbl_supplier', 'tbl_purchinv.kode_supplier = tbl_supplier.kode_supplier')
                ->where('tgl_invoice >=', $dari)
                ->where('tgl_invoice <=', $sampai)
                ->where('kode_baku =', $kode)
                ->get()->getResultArray();
        }
    }


    public function trxDebet2($dari, $sampai, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_adjustment')
                ->where('tgl_adjustment >=', $dari)
                ->where('tgl_adjustment <=', $sampai)
                ->where('qty >', 0)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_adjustment')
                ->where('tgl_adjustment >=', $dari)
                ->where('tgl_adjustment <=', $sampai)
                ->where('kode_baku =', $kode)
                ->where('qty >', 0)
                ->get()->getResultArray();
        }
    }

    public function trxCredit($dari, $sampai, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_pakai')
                ->join('tbl_hasil', 'tbl_pakai.no_bukti = tbl_hasil.no_bukti')
                ->where('tgl_bukti >=', $dari)
                ->where('tgl_bukti <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_pakai')
                ->join('tbl_hasil', 'tbl_pakai.no_bukti = tbl_hasil.no_bukti')
                ->where('tgl_bukti >=', $dari)
                ->where('tgl_bukti <=', $sampai)
                ->where('kode_baku =', $kode)
                ->get()->getResultArray();
        }
    }

    public function trxCredit2($dari, $sampai, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_adjustment')
                ->where('tgl_adjustment >=', $dari)
                ->where('tgl_adjustment <=', $sampai)
                ->where('qty <', 0)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_adjustment')
                ->where('tgl_adjustment >=', $dari)
                ->where('tgl_adjustment <=', $sampai)
                ->where('kode_baku =', $kode)
                ->where('qty <', 0)
                ->get()->getResultArray();
        }
    }

    public function trxCredit3($dari, $sampai, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_detail_purchrtn')
                ->join('tbl_purchrtn', 'tbl_detail_purchrtn.no_retur = tbl_purchrtn.no_retur')
                ->where('tgl_retur >=', $dari)
                ->where('tgl_retur <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_purchrtn')
                ->join('tbl_purchrtn', 'tbl_detail_purchrtn.no_retur = tbl_purchrtn.no_retur')
                ->where('tgl_retur >=', $dari)
                ->where('tgl_retur <=', $sampai)
                ->where('kode_baku =', $kode)
                ->get()->getResultArray();
        }
    }

    public function trxCredit4($dari, $sampai, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_detail_pakaibaku')
                ->join('tbl_pakaibaku', 'tbl_detail_pakaibaku.no_bukti = tbl_pakaibaku.no_bukti')
                ->where('tgl_bukti >=', $dari)
                ->where('tgl_bukti <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_pakaibaku')
                ->join('tbl_pakaibaku', 'tbl_detail_pakaibaku.no_bukti = tbl_pakaibaku.no_bukti')
                ->where('tgl_bukti >=', $dari)
                ->where('tgl_bukti <=', $sampai)
                ->where('kode_baku =', $kode)
                ->get()->getResultArray();
        }
    }


    public function clearKartuStock()
    {
        $this->db->table('kartustock')->emptyTable();
    }

    public function insertKartuStock($raw1)
    {
        $this->db->table('kartustock')->insert($raw1);
    }

    public function getKartuStock()
    {
        return $this->db->table('kartustock')
            ->join('tbl_baku', 'kartustock.kode_baku = tbl_baku.kode_baku')
            ->orderBy('kartustock.kode_baku', 'ASC')
            ->orderBy('tgl_bukti', 'ASC')
            ->orderBy('rectype', 'ASC')
            ->get()->getResultArray();
    }
}
