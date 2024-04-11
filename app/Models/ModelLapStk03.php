<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapStk03 extends Model
{
    public function awalDebet($dari)
    {
        return $this->db->table('tbl_detail_stockin')
            ->select('kode_barang, sum(qty) as awl')
            ->join('tbl_stockin', 'tbl_detail_stockin.no_bukti = tbl_stockin.no_bukti')
            ->groupBy('kode_barang')
            ->where('tgl_bukti <', $dari)
            ->get()->getResultArray();
    }


    public function awalDebet3($dari)
    {
        return $this->db->table('tbl_adjustment')
            ->select('kode_barang, sum(qty) as awl')
            ->groupBy('kode_barang')
            ->where('tgl_adjustment <', $dari)
            ->where('qty >', 0)
            ->get()->getResultArray();
    }

    public function awalCredit($dari)
    {
        return $this->db->table('tbl_detail_suratjln')
            ->select('kode_barang, sum(qty) as awl')
            ->join('tbl_suratjln', 'tbl_detail_suratjln.no_suratjln = tbl_suratjln.no_suratjln')
            ->groupBy('kode_barang')
            ->where('tgl_suratjln <', $dari)
            ->get()->getResultArray();
    }

    public function awalCredit2($dari)
    {
        return $this->db->table('tbl_adjustment')
            ->select('kode_barang, sum(qty * -1) as awl')
            ->groupBy('kode_barang')
            ->where('tgl_adjustment <', $dari)
            ->where('qty <', 0)
            ->get()->getResultArray();
    }


    public function trxDebet($dari, $sampai)
    {
        return $this->db->table('tbl_detail_stockin')
            ->select('kode_barang, sum(qty) as awl')
            ->join('tbl_stockin', 'tbl_detail_stockin.no_bukti = tbl_stockin.no_bukti')
            ->groupBy('kode_barang')
            ->where('tgl_bukti >=', $dari)
            ->where('tgl_bukti <=', $sampai)
            ->get()->getResultArray();
    }



    public function trxDebet3($dari, $sampai)
    {
        return $this->db->table('tbl_adjustment')
            ->select('kode_barang, sum(qty) as awl')
            ->groupBy('kode_barang')
            ->where('tgl_adjustment >=', $dari)
            ->where('tgl_adjustment <=', $sampai)
            ->where('qty >', 0)
            ->get()->getResultArray();
    }


    public function trxCredit($dari, $sampai)
    {
        return $this->db->table('tbl_detail_suratjln')
            ->select('kode_barang, sum(qty) as awl')
            ->join('tbl_suratjln', 'tbl_detail_suratjln.no_suratjln = tbl_suratjln.no_suratjln')
            ->groupBy('kode_barang')
            ->where('tgl_suratjln >=', $dari)
            ->where('tgl_suratjln <=', $sampai)
            ->get()->getResultArray();
    }

    public function trxCredit2($dari, $sampai)
    {
        return $this->db->table('tbl_adjustment')
            ->select('kode_barang, sum(qty * -1) as awl')
            ->groupBy('kode_barang')
            ->where('tgl_adjustment >=', $dari)
            ->where('tgl_adjustment <=', $sampai)
            ->where('qty <', 0)
            ->get()->getResultArray();
    }


    public function updateSaldoAwal($raw1)
    {
        $this->db->table('tbl_barang')
            ->where('kode_barang', $raw1['kode_barang'])
            ->update($raw1);
    }

    public function getSaldo()
    {
        return $this->db->table('tbl_barang')
            ->join('tbl_merk', 'tbl_barang.kode_merk = tbl_merk.kode_merk')
            ->orderBy('tbl_barang.kode_merk', 'ASC')
            ->orderBy('nama_barang', 'ASC')
            ->get()->getResultArray();
    }
}
