<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPurchRtn extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_purchrtn')
            ->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_purchrtn.kode_supplier', 'left')
            ->orderBy('tgl_retur', 'DESC')
            ->orderBy('no_retur', 'DESC')
            ->get()->getResultArray();
    }

    public function ambildatapi($kode_supplier)
    {
        return $this->db->table('tbl_purchinv')
            ->where('kode_supplier', $kode_supplier)
            ->orderBy('no_invoice', 'DESC')
            ->get()->getResultArray();
    }


    public function add($data)
    {
        $this->db->table('tbl_purchrtn')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tbl_purchrtn')
            ->where('no_retur', $data['no_retur'])
            ->update($data);
    }

    public function detail($no_retur)
    {
        return $this->db->table('tbl_purchrtn')
            ->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_purchrtn.kode_supplier', 'left')
            ->where('no_retur', $no_retur)
            ->get()->getRowArray();
    }

    public function detail_pr($no_retur)
    {
        return $this->db->table('tbl_detail_purchrtn')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_purchrtn.kode_barang', 'left')
            ->where('no_retur', $no_retur)
            ->get()->getResultArray();
    }

    public function delete_master($noretur)
    {
        $this->db->table('tbl_purchrtn')
            ->where('no_retur', $noretur)
            ->delete();
    }

    public function delete_detail($noretur)
    {
        $this->db->table('tbl_detail_purchrtn')
            ->where('no_retur', $noretur)
            ->delete();
    }

    public function add_detail($data)
    {
        $this->db->table('tbl_detail_purchrtn')->insert($data);
    }

    public function ambilDataCart()
    {
        return  $this->db->table('keranjangpr')->get()->getResultArray();
    }


    public function clearCart($no_retur)
    {
        $this->db->table('keranjangpr')
        ->where('no_retur', $no_retur)
        ->delete();
    }


    public function addCart($data)
    {
        $this->db->table('keranjangpr')->insert($data);
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangpr')
            ->where('id_purchrtn', $id)
            ->delete();
    }


    public function getCart($no_retur)
    {
        return $this->db->table('keranjangpr')
            ->join('tbl_barang', 'tbl_barang.kode_barang = keranjangpr.kode_barang', 'left')
            ->where('no_retur', $no_retur)
            ->orderBy('id_purchrtn', 'asc')
            ->get()->getResultArray();
    }
    public function editCart($data)
    {
        $this->db->table('keranjangpr')
            ->where('id_purchrtn', $data['id_purchrtn'])
            ->update($data);
    }

    public function get_invbybrg($no_invoice)
    {
        return $this->db->table('tbl_detail_purchinv')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_purchinv.kode_barang', 'left')
            ->where('tbl_detail_purchinv.no_invoice', $no_invoice)
            ->get()->getResultArray();
    }

}
