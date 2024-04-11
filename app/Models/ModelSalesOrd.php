<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSalesOrd extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_salesord')
            ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesord.kode_customer', 'left')
            ->orderBy('tgl_so', 'DESC')
            ->orderBy('no_so', 'DESC')
            ->get()->getResultArray();
    }


    public function add($data)
    {
        $this->db->table('tbl_salesord')->insert($data);
    }

    public function add_detail($data)
    {
        $this->db->table('tbl_detail_salesord')->insert($data);
    }

    public function detail($id_so)
    {
        return $this->db->table('tbl_salesord')
            ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesord.kode_customer', 'left')
            ->where('id_so', $id_so)
            ->get()->getRowArray();
    }

    public function detailSo($no_so)
    {
        return $this->db->table('tbl_salesord')
            ->where('no_so', $no_so)
            ->get()->getRowArray();
    }

    public function ambilDataSO($kode_customer)
    {
        return $this->db->table('tbl_salesord')
            ->where('kode_customer', $kode_customer)
            ->where('no_so','')
            ->orderBy('no_so', 'desc')
            ->get()->getResultArray();
    }

    public function detail_so($no_so)
    {
        return $this->db->table('tbl_detail_salesord')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_salesord.kode_barang', 'left')
            ->where('no_so', $no_so)
            ->orderBy('id_salesord')
            ->get()->getResultArray();
    }

    public function edit($data)
    {
        $this->db->table('tbl_salesord')
            ->where('no_so', $data['no_so'])
            ->update($data);
    }

    public function delete_master($noso)
    {
        $this->db->table('tbl_salesord')
            ->where('no_so', $noso)
            ->delete();
    }

    public function delete_detail($noso)
    {
        $this->db->table('tbl_detail_salesord')
            ->where('no_so', $noso)
            ->delete();
    }

 
    public function ambilDataCart()
    {
        return  $this->db->table('keranjangso')->get()->getResultArray();
    }

    public function clearCart($no_so)
    {
        $this->db->table('keranjangso')
        ->where('no_so', $no_so)
        ->delete();
    }

    public function addCart($data)
    {
        $this->db->table('keranjangso')->insert($data);
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangso')
            ->where('id_salesord', $id)
            ->delete();
    }
    
    public function getCart($no_so)
    {
        return $this->db->table('keranjangso')
            ->join('tbl_barang', 'tbl_barang.kode_barang = keranjangso.kode_barang', 'left')
            ->where('no_so', $no_so)
            ->orderBy('id_salesord', 'asc')
            ->get()->getResultArray();
    }
    public function editCart($data)
    {
        $this->db->table('keranjangso')
            ->where('id_salesord', $data['id_salesord'])
            ->update($data);
    }
    
    public function getDetail()
    {
        return $this->db->table('tbl_detail_salesord')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_salesord.kode_barang', 'left')
            ->get()->getResultArray();
    }

    public function updateDetail($data)
    {
        $this->db->table('tbl_detail_salesord')
            ->where('id_salesord', $data['id_salesord'])
            ->update($data);
    }

    public function gantiNo($nolama,$data)
    {
        $query = $this->db->table('tbl_salesord')
        ->where('no_so', $nolama)
        ->update($data);

        $query2 = $this->db->table('tbl_detail_salesord')
        ->where('no_so', $nolama)
        ->update($data);

        $query3 = $this->db->table('tbl_suratjln')
        ->where('no_so', $nolama)
        ->update($data);
    }

}
