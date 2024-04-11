<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSalesInv extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_salesinv')
            ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesinv.kode_customer', 'left')
            ->join('tbl_divisi','tbl_divisi.kode_divisi = tbl_salesinv.kode_divisi', '')
            ->orderBy('tgl_invoice', 'DESC')
            ->orderBy('no_invoice', 'DESC')
            ->get()->getResultArray();
    }

    public function allData3()
    {
        return $this->db->table('tbl_salesinv')
            ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesinv.kode_customer', 'left')
            ->join('tbl_divisi','tbl_divisi.kode_divisi = tbl_salesinv.kode_divisi', '')
            ->where('tbl_salesinv.awal',0)
            ->orderBy('tgl_invoice', 'DESC')
            ->orderBy('no_invoice', 'DESC')
            ->get()->getResultArray();
    }

    public function ambilDataSj($kode_customer)
    {
        return $this->db->table('tbl_suratjln')
            ->where('kode_customer', $kode_customer)
            ->where('no_invoice','')
            ->orderBy('no_suratjln', 'desc')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_salesinv')->insert($data);
    }

    public function add_detail($data)
    {
        $this->db->table('tbl_detail_salesinv')->insert($data);
    }

    public function detail($id_inv)
    {
        return $this->db->table('tbl_salesinv')
            ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesinv.kode_customer', 'left')
            ->join('tbl_divisi','tbl_divisi.kode_divisi = tbl_salesinv.kode_divisi', 'left')
            ->join('tbl_suratjln','tbl_suratjln.no_suratjln = tbl_salesinv.no_suratjln', 'left')
            ->where('id_inv', $id_inv)
            ->get()->getRowArray();
    }

    public function detail_si($no_invoice)
    {
        return $this->db->table('tbl_detail_salesinv')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_salesinv.kode_barang', 'left')
            ->where('no_invoice', $no_invoice)
            ->orderBy('id_salesinv')
            ->get()->getResultArray();
    }

    public function edit($data)
    {
        $this->db->table('tbl_salesinv')
            ->where('no_invoice', $data['no_invoice'])
            ->update($data);
    }

    public function delete_master($noinvoice)
    {
        $this->db->table('tbl_salesinv')
            ->where('no_invoice', $noinvoice)
            ->delete();
    }

    public function delete_detail($noinvoice)
    {
        $this->db->table('tbl_detail_salesinv')
            ->where('no_invoice', $noinvoice)
            ->delete();
    }

    public function get_sjbybrg($no_suratjln)
    {
        return $this->db->table('tbl_detail_suratjln')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_suratjln.kode_barang', 'left')
            // ->join('tbl_suratjln','tbl_suratjln.no_suratjln = tbl_detail_suratjln.no_suratjln')
            // ->join('tbl_detail_salesord','tbl_suratjln.no_so = tbl_detail_salesord.no_so')
            ->where('tbl_detail_suratjln.no_suratjln', $no_suratjln)
            ->orderBy('id_suratjln')
            ->get()->getResultArray();
    }

    public function ambilDataCart()
    {
        return  $this->db->table('keranjangjual')->get()->getResultArray();
    }

    public function clearCart($no_invoice)
    {
        $this->db->table('keranjangjual')
        ->where('no_invoice', $no_invoice)
        ->delete();
    }

    public function addCart($data)
    {
        $this->db->table('keranjangjual')->insert($data);
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangjual')
            ->where('id_salesinv', $id)
            ->delete();
    }
    
    public function getCart($no_invoice)
    {
        return $this->db->table('keranjangjual')
            ->join('tbl_barang', 'tbl_barang.kode_barang = keranjangjual.kode_barang', 'left')
            ->where('no_invoice', $no_invoice)
            ->orderBy('id_salesinv', 'asc')
            ->get()->getResultArray();
    }
    public function editCart($data)
    {
        $this->db->table('keranjangjual')
            ->where('id_salesinv', $data['id_salesinv'])
            ->update($data);
    }
    
    public function getDetail()
    {
        return $this->db->table('tbl_detail_salesinv')
            ->join('tbl_barang', 'tbl_barang.kode_barang = tbl_detail_salesinv.kode_barang', 'left')
            ->get()->getResultArray();
    }

    public function updateDetail($data)
    {
        $this->db->table('tbl_detail_salesinv')
            ->where('id_salesinv', $data['id_salesinv'])
            ->update($data);
    }

    public function gantino($nolama,$data,$data2)
    {
        $query = $this->db->table('tbl_salesinv')
        ->where('no_invoice', $nolama)
        ->update($data);

        $query2 = $this->db->table('tbl_detail_salesinv')
        ->where('no_invoice', $nolama)
        ->update($data);

        $query3 = $this->db->table('tbl_suratjln')
        ->where('no_invoice', $nolama)
        ->update($data);

        $query4 = $this->db->table('tbl_detail_receipt')
        ->where('no_invoice', $nolama)
        ->update($data);

        $query5 = $this->db->table('tbl_detail_jurnal')
        ->where('no_voucher', $nolama)
        ->update($data2);
    }
}
