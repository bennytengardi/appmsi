<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapStk02 extends Model
{
    public function awalDebet($dari, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_detail_stockin')
                ->select('kode_barang, sum(qty) as awldbt')
                ->join('tbl_stockin', 'tbl_detail_stockin.no_bukti = tbl_stockin.no_bukti')
                ->groupBy('kode_barang')
                ->where('tgl_bukti <', $dari)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_stockin')
                ->select('kode_barang, sum(qty) as awldbt')
                ->join('tbl_stockin', 'tbl_detail_stockin.no_bukti = tbl_stockin.no_bukti')
                ->groupBy('kode_barang')
                ->where('tgl_bukti <', $dari)
                ->where('kode_barang =', $kode)
                ->get()->getResultArray();
        }
    }

    public function awalDebet3($dari, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_adjustment')
                ->select('kode_barang, sum(qty) as awldbt3')
                ->groupBy('kode_barang')
                ->where('tgl_adjustment <', $dari)
                ->where('qty >', 0)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_adjustment')
                ->select('kode_barang, sum(qty) as awldbt3')
                ->groupBy('kode_barang')
                ->where('tgl_adjustment <', $dari)
                ->where('kode_barang =', $kode)
                ->where('qty >', 0)
                ->get()->getResultArray();
        }
    }

    public function awalCredit($dari, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_suratjln')
                ->select('kode_barang, sum(qty) as awlcrd')
                ->join('tbl_detail_suratjln', 'tbl_suratjln.no_suratjln = tbl_detail_suratjln.no_suratjln')
                ->groupBy('kode_barang')
                ->where('tgl_suratjln <', $dari)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_suratjln')
                ->select('kode_barang, sum(qty) as awlcrd')
                ->join('tbl_suratjln', 'tbl_detail_suratjln.no_suratjln = tbl_suratjln.no_suratjln')
                ->groupBy('kode_barang')
                ->where('tgl_suratjln <', $dari)
                ->where('kode_barang =', $kode)
                ->get()->getResultArray();
        }
    }

    public function awalCredit2($dari, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_adjustment')
                ->select('kode_barang, sum(qty) as awlcrd2')
                ->groupBy('kode_barang')
                ->where('tgl_adjustment <', $dari)
                ->where('qty <', 0)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_adjustment')
                ->select('kode_barang, sum(qty) as awlcrd2')
                ->groupBy('kode_barang')
                ->where('tgl_adjustment <', $dari)
                ->where('kode_barang =', $kode)
                ->where('qty <', 0)
                ->get()->getResultArray();
        }
    }


    public function updateSaldoAwal($raw1)
    {
        $this->db->table('tbl_barang')
            ->where('kode_barang', $raw1['kode_barang'])
            ->update($raw1);
    }

    public function trxDebet($dari, $sampai, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_detail_stockin')
                ->join('tbl_stockin', 'tbl_detail_stockin.no_bukti = tbl_stockin.no_bukti')
                ->where('tgl_bukti >=', $dari)
                ->where('tgl_bukti <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_stockin')
                ->join('tbl_stockin', 'tbl_detail_stockin.no_bukti = tbl_stockin.no_bukti')
                ->where('tgl_bukti >=', $dari)
                ->where('tgl_bukti <=', $sampai)
                ->where('kode_barang =', $kode)
                ->get()->getResultArray();
        }
    }



    public function trxDebet3($dari, $sampai, $kode)
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
                ->where('tgl_adjustment<=', $sampai)
                ->where('kode_barang =', $kode)
                ->where('qty >', 0)
                ->get()->getResultArray();
        }
    }

    public function trxCredit($dari, $sampai, $kode)
    {
        if ($kode == 'ALL') {
            return $this->db->table('tbl_detail_suratjln')
                ->join('tbl_suratjln', 'tbl_detail_suratjln.no_suratjln = tbl_suratjln.no_suratjln')
                ->join('tbl_customer', 'tbl_suratjln.kode_customer = tbl_customer.kode_customer')
                ->where('tgl_suratjln >=', $dari)
                ->where('tgl_suratjln <=', $sampai)
                ->get()->getResultArray();
        } else {
            return $this->db->table('tbl_detail_suratjln')
                ->join('tbl_suratjln', 'tbl_detail_suratjln.no_suratjln = tbl_suratjln.no_suratjln')
                ->join('tbl_customer', 'tbl_suratjln.kode_customer = tbl_customer.kode_customer')
                ->where('tgl_suratjln >=', $dari)
                ->where('tgl_suratjln <=', $sampai)
                ->where('kode_barang =', $kode)
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
                ->where('kode_barang =', $kode)
                ->where('qty <', 0)
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

    public function getKartuStock($kode_merk)
    {
        return $this->db->table('kartustock')
            ->join('tbl_barang', 'kartustock.kode_barang = tbl_barang.kode_barang')
            ->where('kode_merk',$kode_merk)
            ->orderBy('kartustock.kode_barang', 'ASC')
            ->orderBy('tgl_bukti', 'ASC')
            ->orderBy('rectype', 'ASC')
            ->get()->getResultArray();
    }
}
