<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLapJual24 extends Model
{
    public function trxDebet($sampai)
    {
        return $this->db->table('tbl_salesord')
            ->where('tgl_so <=', $sampai)
            ->where('awal','')
            ->get()->getResultArray();
    }

    public function trxCredit($sampai)
    {
        return $this->db->table('tbl_salesinv')
            ->select('no_so, sum(total_invoice) as totreal')
            ->join('tbl_suratjln', 'tbl_suratjln.no_suratjln = tbl_salesinv.no_suratjln')
            ->groupBy('no_so')
            ->where('tgl_invoice <=', $sampai)
            ->get()->getResultArray();
        
        
            // return $this->db->table('tbl_salesinv')
            //     ->join('tbl_suratjln', 'tbl_suratjln.no_suratjln = tbl_salesinv.no_suratjln')
            //     ->where('tgl_invoice <=', $sampai)
            //     ->get()->getResultArray();
    }
    

    public function clearOutstandingSo()
    {
        $this->db->table('outstandingso')->emptyTable();
    }

    public function insertOutstandingSo($raw2)
    {
        $this->db->table('outstandingso')->insert($raw2);
    }

    public function UpdateOutstandingSo($raw3)
    {
        $this->db->table('outstandingso')
            ->where('no_so', $raw3['no_so'])
            ->update($raw3);
    }

    public function getOutstandingSo($kodedivisi)
    {
        return $this->db->table('outstandingso')
            ->join('tbl_customer', 'outstandingso.kode_customer = tbl_customer.kode_customer')
            ->join('tbl_salesord','outstandingso.no_so = tbl_salesord.no_so')
            ->where('outstandingso.total_so  > outstandingso.realisasi')
            ->where('tbl_salesord.kode_divisi',$kodedivisi)
            ->orderBy('outstandingso.kode_customer', 'ASC')
            ->orderBy('outstandingso.tgl_so', 'ASC')
            ->get()->getResultArray();
    }
}
