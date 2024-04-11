<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPosting extends Model
{
    
    public function clearSaldo($data)
    {
        $this->db->table('tbl_barang')
            ->where('kode_barang', $data['kode_barang'])
            ->update($data);
    }
    
    public function penjualan()
    {
        return $this->db->table('tbl_detail_salesinv')
            ->select('kode_barang, sum(qty) as totjual')
            ->groupBy('kode_barang')
            ->get()->getResultArray();
    }
    
    public function produksi()
    {
        return $this->db->table('tbl_detail_hasil')
            ->select('kode_barang, sum(qty) as tothasil')
            ->groupBy('kode_barang')
            ->get()->getResultArray();
    }
    
     public function adjustment()
    {
        return $this->db->table('tbl_adjustment')
            ->select('kode_barang, sum(qty) as totadjust')
            ->groupBy('kode_barang')
            ->get()->getResultArray();
    }
    
    public function updateSaldo($raw1)
    {
        $this->db->table('tbl_barang')
            ->where('kode_barang', $raw1['kode_barang'])
            ->update($raw1);
    }
    
}
