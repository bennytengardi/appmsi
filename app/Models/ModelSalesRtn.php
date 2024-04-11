<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSalesRtn extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_salesrtn')
            ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesrtn.kode_customer', 'left')
            ->orderBy('tgl_retur', 'DESC')
            ->orderBy('no_retur', 'DESC')
            ->get()->getResultArray();
    }

    public function ambildatasi($kode_customer)
    {
        return $this->db->table('tbl_salesinv')
            ->where('kode_customer', $kode_customer)
            ->orderBy('no_invoice', 'DESC')
            ->get()->getResultArray();
    }

    public function ambildatasj($kode_customer)
    {
        return $this->db->table('tbl_suratjln')
            ->where('kode_customer', $kode_customer)
            ->orderBy('no_invoice', 'DESC')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_salesrtn')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tbl_salesrtn')
            ->where('no_retur', $data['no_retur'])
            ->update($data);
    }

    public function detail($no_retur)
    {
        return $this->db->table('tbl_salesrtn')
            ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesrtn.kode_customer', 'left')
            ->where('no_retur', $no_retur)
            ->get()->getRowArray();
    }

    public function detail_sr($no_retur)
    {
        return $this->db->table('tbl_detail_salesrtn')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_salesrtn.kode_barang', 'left')
            ->where('no_retur', $no_retur)
            ->get()->getResultArray();
    }

    public function delete_master($noretur)
    {
        $this->db->table('tbl_salesrtn')
            ->where('no_retur', $noretur)
            ->delete();
    }

    public function delete_detail($noretur)
    {
        $this->db->table('tbl_detail_salesrtn')
            ->where('no_retur', $noretur)
            ->delete();
    }

    public function add_detail($data)
    {
        $this->db->table('tbl_detail_salesrtn')->insert($data);
    }

    public function ambilDataCart()
    {
        return  $this->db->table('keranjangsr')->get()->getResultArray();
    }


    public function clearCart($no_retur)
    {
        $this->db->table('keranjangsr')
        ->where('no_retur', $no_retur)
        ->delete();
    }


    public function addCart($data)
    {
        $this->db->table('keranjangsr')->insert($data);
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangsr')
            ->where('id_salesrtn', $id)
            ->delete();
    }


    public function getCart($no_retur)
    {
        return $this->db->table('keranjangsr')
            ->join('tbl_barang', 'tbl_barang.kode_barang = keranjangsr.kode_barang', 'left')
            ->where('no_retur', $no_retur)
            ->orderBy('id_salesrtn', 'asc')
            ->get()->getResultArray();
    }
    public function editCart($data)
    {
        $this->db->table('keranjangsr')
            ->where('id_salesrtn', $data['id_salesrtn'])
            ->update($data);
    }

    public function get_invbybrg($no_invoice)
    {
        return $this->db->table('tbl_detail_salesinv')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_salesinv.kode_barang', 'left')
            ->where('tbl_detail_salesinv.no_invoice', $no_invoice)
            ->get()->getResultArray();
    }

}
