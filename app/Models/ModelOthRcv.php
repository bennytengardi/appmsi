<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelOthRcv extends Model
{
    public function allData()
    {
        return $this->db->table('tbl_othrcv')
            ->join('tbl_account', 'tbl_account.kode_account = tbl_othrcv.kode_account', 'left')
            ->orderBy('tgl_bukti', 'DESC')
            ->orderBy('no_bukti', 'DESC')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_othrcv')->insert($data);
    }

    public function add_detail($data1)
    {
        $this->db->table('tbl_detail_othrcv')->insert($data1);
    }

    public function detail($id_bukti)
    {
        return $this->db->table('tbl_othrcv')
            ->join('tbl_account', 'tbl_account.kode_account = tbl_othrcv.kode_account', 'left')
            ->where('id_bukti', $id_bukti)
            ->get()->getRowArray();
    }

    public function detail_othrcv($no_bukti)
    {
        return $this->db->table('tbl_detail_othrcv')
            ->join('tbl_account', 'tbl_account.kode_account = tbl_detail_othrcv.kode_account', 'left')
            ->where('no_bukti', $no_bukti)
            ->get()->getResultArray();
    }

    public function edit($data)
    {
        $this->db->table('tbl_othrcv')
            ->where('id_bukti', $data['id_bukti'])
            ->update($data);
    }

    public function edit_detail($data)
    {
        $this->db->table('tbl_detail_othrcv')
            ->where('id_othrcv', $data['id_othrcv'])
            ->update($data);
    }

    public function delete_master($no_bukti)
    {
        $this->db->table('tbl_othrcv')
            ->where('no_bukti', $no_bukti)
            ->delete();
    }

    public function delete_detail($no_bukti)
    {
        $this->db->table('tbl_detail_othrcv')
            ->where('no_bukti', $no_bukti)
            ->delete();
    }

    public function updateDetailOthRcv($data)
    {
        $this->db->table('tbl_detail_othrcv')
            ->where('row_id', $data['row_id'])
            ->update($data);
    }

    public function deleteDetailOthRcv($id)
    {
        $this->db->table('tbl_detail_othrcv')
            ->where('row_id', $id)
            ->delete();
    }

    public function ambilDataCart()
    {
        return  $this->db->table('keranjangothrcv')->get()->getResultArray();
    }

    public function clearCart($no_random)
    {
        $this->db->table('keranjangothrcv')
        ->where('no_bukti',$no_random)
        ->delete();
    }

    public function addCart($data)
    {
        $this->db->table('keranjangothrcv')->insert($data);
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangothrcv')
            ->where('id_othrcv', $id)
            ->delete();
    }
    
    public function getCart($no_bukti)
    {
        return $this->db->table('keranjangothrcv')
            ->join('tbl_account', 'tbl_account.kode_account = keranjangothrcv.kode_account', 'left')
            ->where('no_bukti', $no_bukti)
            ->where('stt !=','D')
            ->get()->getResultArray();
    }
    
    public function ambilCart($no_bukti)
    {
        return $this->db->table('keranjangothrcv')
            ->where('no_bukti', $no_bukti)
            ->get()->getResultArray();
    }

    public function editCart($data)
    {
        $this->db->table('keranjangothrcv')
            ->where('row_id', $data['row_id'])
            ->update($data);
    }
}
