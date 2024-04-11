<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJurnal extends Model
{
    public function allData()
    {
        return $this->db->table('tbl_jurnal')
            ->orderBy('tgl_voucher', 'DESC')
            ->get()->getResultArray();
    }

    public function allDetail()
    {
        return $this->db->table('tbl_detail_jurnal')
            ->join('tbl_account', 'tbl_account.kode_account = tbl_detail_jurnal.kode_account', 'left')
            ->orderBy('tgl_voucher', 'DESC')
            ->get()->getResultArray();
    }

    public function get_jurnal($no_voucher)
    {
        return $this->db->table('tbl_jurnal')
            ->where('no_voucher', $no_voucher)
            ->get()->getRowArray();
    }

    public function get_djurnal($no_voucher)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->join('tbl_account', 'tbl_account.kode_account = tbl_detail_jurnal.kode_account', 'left')
            ->where('no_voucher', $no_voucher)
            ->get()->getResultArray();
    }


    public function add_header($data)
    {
        $this->db->table('tbl_jurnal')->insert($data);
    }

    public function add_detail($data)
    {
        $this->db->table('tbl_detail_jurnal')->insert($data);
    }

    public function delete_master($no_voucher)
    {
        $this->db->table('tbl_jurnal')
            ->where('no_voucher', $no_voucher)
            ->delete();
    }

    public function delete_detail($no_voucher)
    {
        $this->db->table('tbl_detail_jurnal')
            ->where('no_voucher', $no_voucher)
            ->delete();
    }

    public function get_by_voucher($no_voucher)
    {
        return $this->db->table('tb_jurnal')
            ->where('no_voucher', $no_voucher)
            ->get()->getRowArray();
    }

    public function edit($data)
    {
        $this->db->table('tbl_jurnal')
            ->where('no_voucher', $data['no_voucher'])
            ->update($data);
    }

    public function edit_detail($data)
    {
        $this->db->table('tbl_detail_jurnal')
            ->where('id_jurnal', $data['id_jurnal'])
            ->update($data);
    }

    public function ambilDataCart()
    {
        return  $this->db->table('keranjangjurnal')->get()->getResultArray();
    }

    public function clearCart()
    {
        $this->db->table('keranjangjurnal')->emptyTable();
    }

    public function addCart($data)
    {
        $this->db->table('keranjangjurnal')->insert($data);
    }

    public function deleteCart($id)
    {
        $this->db->table('keranjangjurnal')
            ->where('id_jurnal', $id)
            ->delete();
    }
    public function getCart($no_voucher)
    {
        return $this->db->table('keranjangjurnal')
            ->join('tbl_account', 'tbl_account.kode_account = keranjangjurnal.kode_account', 'left')
            ->where('no_voucher', $no_voucher)
            ->orderBy('id_jurnal', 'asc')
            ->get()->getResultArray();
    }
    public function editCart($data)
    {
        $this->db->table('keranjangjurnal')
            ->where('id_jurnal', $data['id_jurnal'])
            ->update($data);
    }
    
    public function get_alljurnal($dari,$sampai)
    {
        return $this->db->table('tbl_detail_jurnal')
            ->select('no_voucher, sum(debet) as dbt, sum(credit) as crd, sum(debet-credit) as bal')
            ->groupBy('no_voucher')
            ->where('tgl_voucher >=', $dari)
            ->where('tgl_voucher <=', $sampai)
            ->get()->getResultArray();
    }
    
}
