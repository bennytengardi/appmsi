<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSuratJln extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_suratjln')
            ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_suratjln.kode_customer', 'left')
            ->orderBy('tgl_suratjln', 'DESC')
            ->orderBy('no_suratjln', 'DESC')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_suratjln')->insert($data);
    }

    public function add_detail($data)
    {
        $this->db->table('tbl_detail_suratjln')->insert($data);
    }

    public function ambilDataSO($kode_customer)
    {
        return $this->db->table('tbl_salesord')
            ->where('kode_customer', $kode_customer)
            // ->where('no_so','')
            ->orderBy('no_so', 'desc')
            ->get()->getResultArray();
    }

    public function detail($id_sj)
    {
        return $this->db->table('tbl_suratjln')
            ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_suratjln.kode_customer')
            // ->join('tbl_salesord', 'tbl_salesord.no_so = tbl_suratjln.no_so')
            ->where('id_sj', $id_sj)
            ->get()->getRowArray();
    }

    public function detail3($id_sj)
    {
        return $this->db->table('tbl_suratjln')
            ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_suratjln.kode_customer')
            ->join('tbl_salesord', 'tbl_salesord.no_so = tbl_suratjln.no_so')
            ->where('id_sj', $id_sj)
            ->get()->getRowArray();
    }

    public function detail_sj($no_suratjln)
    {
        return $this->db->table('tbl_detail_suratjln')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_suratjln.kode_barang')
            ->where('no_suratjln', $no_suratjln)
            ->get()->getResultArray();
    }


    public function edit($data)
    {
        $this->db->table('tbl_suratjln')
            ->where('no_suratjln', $data['no_suratjln'])
            ->update($data);
    }

    public function delete_master($nosuratjln)
    {
        $this->db->table('tbl_suratjln')
            ->where('no_suratjln', $nosuratjln)
            ->delete();
    }

    public function delete_detail($no_suratjln)
    {
        $this->db->table('tbl_detail_suratjln')
            ->where('no_suratjln', $no_suratjln)
            ->delete();
    }

    public function clearCart($no_suratjln)
    {
        $this->db->table('keranjangsj')
            ->where('no_suratjln', $no_suratjln)
            ->delete();
    }

    public function getCart($no_suratjln)
    {
        return $this->db->table('keranjangsj')
            ->join('tbl_barang', 'tbl_barang.kode_barang = keranjangsj.kode_barang', 'left')
            ->where('no_suratjln', $no_suratjln)
            ->orderBy('id_suratjln', 'asc')
            ->get()->getResultArray();
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangsj')
            ->where('id_suratjln', $id)
            ->delete();
    }

    public function addCart($data)
    {
        $this->db->table('keranjangsj')->insert($data);
    }
    public function editCart($data)
    {
        $this->db->table('keranjangsj')
            ->where('id_suratjln', $data['id_suratjln'])
            ->update($data);
    }

    public function get_sobybrg($no_so)
    {
        return $this->db->table('tbl_detail_salesord')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_salesord.kode_barang', 'left')
            ->where('tbl_detail_salesord.no_so', $no_so)
            ->get()->getResultArray();
    }

    public function gantino($nolama,$data)
    {
        $query = $this->db->table('tbl_suratjln')
        ->where('no_suratjln', $nolama)
        ->update($data);

        $query2 = $this->db->table('tbl_detail_suratjln')
        ->where('no_suratjln', $nolama)
        ->update($data);

        $query3 = $this->db->table('tbl_salesinv')
        ->where('no_suratjln', $nolama)
        ->update($data);

    }
    

}
