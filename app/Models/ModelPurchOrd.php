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
            ->where('id_po', $data['id_po'])
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

    public function detail_po($id_po)
    {
        return $this->db->table('tbl_detail_purchord')
            ->join('tbl_barang', 'tbl_detail_purchord.kode_barang = tbl_barang.kode_barang')
            ->where('id_po', $id_po)
            ->orderBy('nourut')
            ->get()->getResultArray();
    }

    public function detailPo($no_po)
    {
        return $this->db->table('tbl_purchord')
            ->where('no_po', $no_po)
            ->get()->getRowArray();
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

    public function clearCart($id_po)
    {
        $this->db->table('keranjangpo')
            ->where('id_po', $id_po)
            ->delete();
    }

    public function addCart($data)
    {
        $this->db->table('keranjangpo')->insert($data);
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangpo')
            ->where('row_id', $id)
            ->delete();
    }
    
    public function getCart($id_po)
    {
        return $this->db->table('keranjangpo')
            ->join('tbl_barang', 'tbl_barang.kode_barang = keranjangpo.kode_barang', 'left')
            ->where('id_po', $id_po)
            ->where('stt !=','D')
            ->orderBy('nourut')
            ->get()->getResultArray();
    }
    
    public function editCart($data)
    {
        $this->db->table('keranjangpo')
            ->where('row_id', $data['row_id'])
            ->update($data);
    }
    
    public function deleteDetailInv($id) 
    {
        $this->db->table('tbl_detail_purchord')
        ->where('row_id', $id)
        ->delete();    
    }

    public function updateDetailInv($data)
    {
        $this->db->table('tbl_detail_purchord')
        ->where('row_id', $data['row_id'])
        ->update($data);
    }

    public function updateDetailPo($data)
    {
        $this->db->table('tbl_detail_purchord')
        ->where('id_po', $data['id_po'])
        ->update($data);
    }
    
    public function ambilCart($id_po)
    {
        return  $this->db->table('keranjangpo')
        ->where('id_po', $id_po)
        ->get()->getResultArray();
    }
    
    public function gantiNo($nolama,$data)
    {
        $query = $this->db->table('tbl_purchord')
        ->where('no_po', $nolama)
        ->update($data);

        $query2 = $this->db->table('tbl_detail_purchord')
        ->where('no_po', $nolama)
        ->update($data);

        $query3 = $this->db->table('tbl_purchinv')
        ->where('no_po', $nolama)
        ->update($data);
    }
    
    
}
