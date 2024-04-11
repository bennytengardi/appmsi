<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model
{
    public function jml_user()
    {
        return $this->db->table('tbl_user')->countAll();
    }



    public function jualharini()
    {
        $tanggal = date('Y-m-d');
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_salesinv');
        return $builder->select('sum(total_invoice) as total')
            ->where('tgl_invoice', $tanggal)
            ->groupBy(['tgl_invoice'])
            ->get()->getRowArray();
    }

    public function jualblnini()
    {
        $bulan = date('Y-m');
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_salesinv');
        return $builder->select('sum(total_invoice) as totalbln')
            ->where('left(tgl_invoice,7)', $bulan)
            ->groupBy('left(tgl_invoice,7)')
            ->get()->getRowArray();
    }

    public function beliblnini()
    {
        $bulan = date('Y-m');
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_purchinv');
        return $builder->select('sum(total_invoice) as totalbln')
            ->where('left(tgl_invoice,7)', $bulan)
            ->groupBy('left(tgl_invoice,7)')
            ->get()->getRowArray();
    }

    public function biayablnini()
    {
        $bulan = date('Y-m');
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_detail_jurnal');
        return $builder->select('sum(debet-credit) as totalbln')
            ->where('left(tgl_voucher,7)', $bulan)
            ->where('left(kode_account,4)','7101')
            ->groupBy('left(tgl_voucher,7)')
            ->get()->getRowArray();
    }
}
