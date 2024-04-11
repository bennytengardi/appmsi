<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPurchOrd extends Model
{
    public function allData()
    {
        return $this->db->table('tbl_purchord')
            ->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_purchord.kode_supplier', 'left')
            ->orderBy('tgl_po', 'DESC')
            ->orderBy('no_po', 'DESC')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_purchord')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tbl_purchord')
            ->where('no_po', $data['no_po'])
            ->update($data);
    }

    public function add_detail($data)
    {
        $this->db->table('tbl_detail_purchord')->insert($data);
    }

    public function detail($id_po)
    {
        return $this->db->table('tbl_purchord')
            ->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_purchord.kode_supplier', 'left')
            ->where('id_po', $id_po)
            ->get()->getRowArray();
    }

    public function detail_po($no_po)
    {
        return $this->db->table('tbl_detail_purchord')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_purchord.kode_barang', 'left')
            ->where('no_po', $no_po)
            ->orderBy('id_purchord')
            ->get()->getResultArray();
    }


    public function delete_master($nopo)
    {
        $this->db->table('tbl_purchord')
            ->where('no_po', $nopo)
            ->delete();
    }

    public function delete_detail($nopo)
    {
        $this->db->table('tbl_detail_purchord')
            ->where('no_po', $nopo)
            ->delete();
    }

    public function ambilDataCart()
    {
        return  $this->db->table('keranjangpo')->get()->getResultArray();
    }

    public function clearCart()
    {
        $this->db->table('keranjangpo')->emptyTable();
    }

    public function addCart($data)
    {
        $this->db->table('keranjangpo')->insert($data);
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangpo')
            ->where('id_purchord', $id)
            ->delete();
    }
    public function getCart($no_po)
    {
        return $this->db->table('keranjangpo')
            ->join('tbl_barang', 'tbl_barang.kode_barang = keranjangpo.kode_barang', 'left')
            ->where('no_po', $no_po)
            ->orderBy('id_purchord', 'asc')
            ->get()->getResultArray();
    }
    public function editCart($data)
    {
        $this->db->table('keranjangpo')
            ->where('id_purchord', $data['id_purchord'])
            ->update($data);
    }
}
