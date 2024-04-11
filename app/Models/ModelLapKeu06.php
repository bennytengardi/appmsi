<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapKeu06 extends Model
{
    public function lapkeu06($dari, $sampai,$kodedivisi, $typelap)
    {
        if ($typelap == "REKAP") {
             return $this->db->table('tbl_detail_othpay')
            ->select('tbl_detail_othpay.kode_account,nama_account,sum(jumlah) as totbiaya')
            ->join('tbl_account', 'tbl_detail_othpay.kode_account = tbl_account.kode_account')
            ->join('tbl_othpay', 'tbl_detail_othpay.no_bukti = tbl_othpay.no_bukti')
            ->groupBy('tbl_detail_othpay.kode_account')
            ->where('tgl_bukti >=', $dari)
            ->where('tgl_bukti <=', $sampai)
            ->where('kode_group','71')
            ->where('kode_divisi',$kodedivisi)
            ->get()->getResultArray();
        } else {
             return $this->db->table('tbl_detail_othpay')
            ->select('tbl_detail_othpay.no_bukti,tbl_othpay.tgl_bukti,tbl_detail_othpay.kode_account, nama_account, jumlah, tbl_detail_othpay.keterangan')
            ->join('tbl_account', 'tbl_detail_othpay.kode_account = tbl_account.kode_account')
            ->join('tbl_othpay', 'tbl_detail_othpay.no_bukti = tbl_othpay.no_bukti')
            ->where('tbl_othpay.tgl_bukti >=', $dari)
            ->where('tbl_othpay.tgl_bukti <=', $sampai)
            ->where('tbl_account.kode_group','71')
            ->where('tbl_othpay.kode_divisi',$kodedivisi)
            ->orderBy('tbl_detail_othpay.kode_account')
            ->orderBy('tbl_othpay.tgl_bukti')
            ->get()->getResultArray();

        }
    }
}
