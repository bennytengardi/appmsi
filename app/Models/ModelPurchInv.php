<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPurchInv extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_purchinv')
            ->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_purchinv.kode_supplier', 'left')
            ->orderBy('tgl_invoice', 'DESC')
            ->orderBy('no_invoice', 'DESC')
            ->get()->getResultArray();
    }

    public function allData3()
    {
        return $this->db->table('tbl_purchinv')
            ->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_purchinv.kode_supplier')
            ->join('tbl_divisi','tbl_divisi.kode_divisi = tbl_purchinv.kode_divisi', 'left')
            ->where('tbl_purchinv.awal',0)
            ->orderBy('tgl_invoice', 'DESC')
            ->orderBy('no_invoice', 'DESC')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_purchinv')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tbl_purchinv')
            ->where('no_invoice', $data['no_invoice'])
            ->update($data);
    }

    public function add_detail($data)
    {
        $this->db->table('tbl_detail_purchinv')->insert($data);
    }

    public function detail($no_invoice)
    {
        return $this->db->table('tbl_purchinv')
            ->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_purchinv.kode_supplier', 'left')
            ->join('tbl_divisi','tbl_divisi.kode_divisi = tbl_purchinv.kode_divisi', 'left')
            ->where('no_invoice', $no_invoice)
            ->get()->getRowArray();
    }

    public function detail2($no_invoice)
    {
        return $this->db->table('tbl_purchinv')
            ->join('tbl_account','tbl_account.kode_account = tbl_purchinv.kode_account', 'left')
            ->where('no_invoice', $no_invoice)
            ->get()->getRowArray();
    }

    public function detail_pi($no_invoice)
    {
        return $this->db->table('tbl_detail_purchinv')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_purchinv.kode_barang', 'left')
            ->where('no_invoice', $no_invoice)
            ->get()->getResultArray();
    }


    public function delete_master($noinvoice)
    {
        $this->db->table('tbl_purchinv')
            ->where('no_invoice', $noinvoice)
            ->delete();
    }

    public function delete_detail($noinvoice)
    {
        $this->db->table('tbl_detail_purchinv')
            ->where('no_invoice', $noinvoice)
            ->delete();
    }

    public function ambilDataPO($kode_supplier)
    {
        return $this->db->table('tbl_purchord')
            ->where('kode_supplier', $kode_supplier)
            ->orderBy('no_po', 'desc')
            ->get()->getResultArray();
    }

    public function ambilCart($no_invoice)
    {
        return  $this->db->table('keranjangbeli')
        ->where('no_invoice', $no_invoice)
        ->get()->getResultArray();
    }

    public function clearCart($no_invoice)
    {
        $this->db->table('keranjangbeli')
            ->where('no_invoice', $no_invoice)
            ->delete();
    }

    public function addCart($data)
    {
        $this->db->table('keranjangbeli')->insert($data);
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangbeli')
            ->where('id_purchinv', $id)
            ->delete();
    }
    public function getCart($no_invoice)
    {
        return $this->db->table('keranjangbeli')
            ->join('tbl_barang', 'tbl_barang.kode_barang = keranjangbeli.kode_barang', 'left')
            ->where('no_invoice', $no_invoice)
            ->orderBy('id_purchinv', 'asc')
            ->get()->getResultArray();
    }
    public function editCart($data)
    {
        $this->db->table('keranjangbeli')
            ->where('id_purchinv', $data['id_purchinv'])
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
