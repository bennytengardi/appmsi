<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelOthPay extends Model
{
    public function allData()
    {
        return $this->db->table('tbl_othpay')
            ->join('tbl_account', 'tbl_account.kode_account = tbl_othpay.kode_account', 'left')
            ->orderBy('tgl_bukti', 'DESC')
            ->orderBy('no_bukti', 'DESC')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_othpay')->insert($data);
    }

    public function add_detail($data1)
    {
        $this->db->table('tbl_detail_othpay')->insert($data1);
    }

    public function detail($id_bukti)
    {
        return $this->db->table('tbl_othpay')
            ->join('tbl_account', 'tbl_account.kode_account = tbl_othpay.kode_account', 'left')
            ->where('id_bukti', $id_bukti)
            ->get()->getRowArray();
    }

    public function detail_othpay($no_bukti)
    {
        return $this->db->table('tbl_detail_othpay')
            ->join('tbl_account', 'tbl_account.kode_account = tbl_detail_othpay.kode_account', 'left')
            ->where('no_bukti', $no_bukti)
            ->orderBy('row_id', 'ASC')
            ->get()->getResultArray();
    }

    public function edit($data)
    {
        $this->db->table('tbl_othpay')
            ->where('id_bukti', $data['id_bukti'])
            ->update($data);
    }

    public function edit_detail($data)
    {
        $this->db->table('tbl_detail_othpay')
            ->where('row_id', $data['row_id'])
            ->update($data);
    }

    public function delete_master($no_bukti)
    {
        $this->db->table('tbl_othpay')
            ->where('no_bukti', $no_bukti)
            ->delete();
    }

    public function delete_detail($no_bukti)
    {
        $this->db->table('tbl_detail_othpay')
            ->where('no_bukti', $no_bukti)
            ->delete();
    }

    public function ambilDataCart()
    {
        return  $this->db->table('keranjangothpay')->get()->getResultArray();
    }

    public function clearCart($no_random)
    {
        $this->db->table('keranjangothpay')
        ->where('no_bukti', $no_random)
        ->delete();
    }


    public function addCart($data)
    {
        $this->db->table('keranjangothpay')->insert($data);
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangothpay')
            ->where('row_id', $id)
            ->delete();
    }
    
    public function updateDetailOthPay($data)
    {
        $this->db->table('tbl_detail_othpay')
            ->where('row_id', $data['row_id'])
            ->update($data);
    }

    public function deleteDetailOthPay($id)
    {
        $this->db->table('tbl_detail_othpay')
            ->where('row_id', $id)
            ->delete();
    }

    public function getCart($no_bukti)
    {
        return $this->db->table('keranjangothpay')
            ->join('tbl_account', 'tbl_account.kode_account = keranjangothpay.kode_account', 'left')
            ->where('no_bukti', $no_bukti)
            ->where('stt !=','D')
            ->get()->getResultArray();
    }
    
    public function ambilCart($no_bukti)
    {
        return $this->db->table('keranjangothpay')
            ->where('no_bukti', $no_bukti)
            ->get()->getResultArray();
    }

    public function editCart($data)
    {
        $this->db->table('keranjangothpay')
            ->where('row_id', $data['row_id'])
            ->update($data);
    }
}
