<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarang extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_barang')
            ->orderBy('kode_merk', 'ASC')
            ->get()->getResultArray();
    }

    public function getAllData($kode_merk)
    {
        return $this->db->table('tbl_barang')
            ->orderBy('nama_barang', 'ASC')
            ->where('kode_merk', $kode_merk)
            ->get()->getResultArray();
    }

    public function detail($id_barang)
    {
        return $this->db->table('tbl_barang')
            ->where('id_barang', $id_barang)
            ->get()->getRowArray();
    }
    public function detail2($kode_barang)
    {
        return $this->db->table('tbl_barang')
            ->where('kode_barang', $kode_barang)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_barang')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tbl_barang')
            ->where('id_barang', $data['id_barang'])
            ->update($data);
    }

    public function hapus($id_barang)
    {
        $this->db->table('tbl_barang')
            ->where('id_barang', $id_barang)
            ->delete();
    }

    public function clearSaldo($data)
    {
        $this->db->table('tbl_barang')
            ->where('id_barang', $data['id_barang'])
            ->update($data);
    }

    public function getSaldo()
    {
        return $this->db->table('tbl_barang')
            ->orderBy('kode_barang', 'ASC')
            ->get()->getResultArray();
    }

    public function detail_saldo($kode_barang)
    {
        return $this->db->table('tbl_detail_masukbb')
            ->where('kode_barang', $kode_barang)
            ->where('awal >', 0)
            ->get()->getResultArray();
    }

    public function getBarang($kode_barang)
    {
        return $this->db->table('tbl_barang')
            ->where('kode_barang', $kode_barang)
            ->get()->getResultArray();
    }

    public function getDataAutoComplete($autocomplete)
    {
        return $this->db->table('tbl_barang')
            ->like('nama_barang', $autocomplete)
            ->limit(10)
            ->get()->getResultArray();
    }

    public function material($kode_barang)
    {
        return $this->db->table('tbl_material')
            ->join('tbl_baku', 'tbl_baku.kode_baku = tbl_material.kode_baku', 'left')
            ->where('kode_barang', $kode_barang)
            ->get()->getResultArray();
    }

    public function allDataDetail($kode_barang)
    {
        return $this->db->table('tbl_material')
            ->join('tbl_baku', 'tbl_baku.kode_baku = tbl_material.kode_baku', 'left')
            ->where('tbl_material.kode_barang', $kode_barang)
            ->orderBy('id_material', 'ASC')
            ->get()->getResultArray();
    }

    public function hapus_id($id_material)
    {
        $this->db->table('tbl_material')
            ->where('id_material', $id_material)
            ->delete();
    }

    public function caribarang($search)
    {
        return $this->db->table('tbl_barang')
            ->like('nama_barang', $search)
            ->orlike('kode_barang', $search)
            ->get()->getResultArray();
    }


    public function gantiKode($kodelama,$data)
    {
        $query = $this->db->table('tbl_detail_salesord')
        ->where('kode_barang', $kodelama)
        ->update($data);

        $query1 = $this->db->table('tbl_detail_suratjln')
        ->where('kode_barang', $kodelama)
        ->update($data);

        $query2 = $this->db->table('tbl_detail_salesinv')
        ->where('kode_barang', $kodelama)
        ->update($data);

        $query3 = $this->db->table('tbl_detail_purchord')
        ->where('kode_barang', $kodelama)
        ->update($data);
        
        $query4 = $this->db->table('tbl_detail_stockin')
        ->where('kode_barang', $kodelama)
        ->update($data);

        $query5 = $this->db->table('tbl_detail_purchinv')
        ->where('kode_barang', $kodelama)
        ->update($data);
        
        $query6 = $this->db->table('tbl_adjustment')
        ->where('kode_barang', $kodelama)
        ->update($data);

        $query7 = $this->db->table('tbl_barang')
        ->where('kode_barang', $kodelama)
        ->update($data);
        
        
    }

}
