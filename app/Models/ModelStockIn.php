<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelStockIn extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_stockin')
            ->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_stockin.kode_supplier', 'left')
            ->orderBy('tgl_bukti', 'DESC')
            ->orderBy('no_bukti', 'DESC')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_stockin')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tbl_stockin')
            ->where('no_bukti', $data['no_bukti'])
            ->update($data);
    }

    public function add_detail($data)
    {
        $this->db->table('tbl_detail_stockin')->insert($data);
    }

    public function detail($no_bukti)
    {
        return $this->db->table('tbl_stockin')
            ->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_stockin.kode_supplier', 'left')
            ->where('no_bukti', $no_bukti)
            ->get()->getRowArray();
    }

    public function detail_pi($no_bukti)
    {
        return $this->db->table('tbl_detail_stockin')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_stockin.kode_barang', 'left')
            ->where('no_bukti', $no_bukti)
            ->get()->getResultArray();
    }


    public function delete_master($nobukti)
    {
        $this->db->table('tbl_stockin')
            ->where('no_bukti', $nobukti)
            ->delete();
    }

    public function delete_detail($nobukti)
    {
        $this->db->table('tbl_detail_stockin')
            ->where('no_bukti', $nobukti)
            ->delete();
    }

    public function ambilDataPO($kode_supplier)
    {
        return $this->db->table('tbl_purchord')
            ->where('kode_supplier', $kode_supplier)
            // ->where('no_so','')
            ->orderBy('no_po', 'desc')
            ->get()->getResultArray();
    }

    

    public function ambilCart($no_bukti)
    {
        return  $this->db->table('keranjangstockin')
        ->where('no_bukti', $no_bukti)
        ->get()->getResultArray();
    }
   
    public function clearCart($no_bukti)
    {
        $this->db->table('keranjangstockin')
            ->where('no_bukti', $no_bukti)
            ->delete();
    }

    public function addCart($data)
    {
        $this->db->table('keranjangstockin')->insert($data);
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangstockin')
            ->where('id_stockin', $id)
            ->delete();
    }
    public function getCart($no_bukti)
    {
        return $this->db->table('keranjangstockin')
            ->join('tbl_barang', 'tbl_barang.kode_barang = keranjangstockin.kode_barang', 'left')
            ->where('no_bukti', $no_bukti)
            ->orderBy('id_stockin', 'asc')
            ->get()->getResultArray();
    }
    public function editCart($data)
    {
        $this->db->table('keranjangstockin')
            ->where('id_stockin', $data['id_stockin'])
            ->update($data);
    }

    public function get_pobybrg($no_po)
    {
        return $this->db->table('tbl_detail_purchord')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_purchord.kode_barang', 'left')
            ->where('tbl_detail_purchord.no_po', $no_po)
            ->get()->getResultArray();
    }    
}
