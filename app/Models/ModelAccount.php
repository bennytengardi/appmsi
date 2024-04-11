<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAccount extends Model
{
    public function allData()
    {
        return $this->db->table('tbl_account')
            ->orderBy('kode_account', 'ASC')
            ->get()->getResultArray();
    }

    public function allDataDetail()
    {
        return $this->db->table('tbl_account')
            ->join('tbl_groupacc', 'tbl_groupacc.kode_group = tbl_account.kode_group', 'left')
            ->where('type_account', 'DETAIL')
            ->orderBy('kode_account', 'ASC')
            ->get()->getResultArray();
    }

    public function allDataHeader()
    {
        return $this->db->table('tbl_account')
            ->join('tbl_groupacc', 'tbl_groupacc.kode_group = tbl_account.kode_group', 'left')
            ->where('type_account', 'HEADER')
            ->orderBy('kode_account', 'ASC')
            ->get()->getResultArray();
    }



    public function allDataGroup()
    {
        return $this->db->table('tbl_groupacc')
            ->orderBy('kode_group')
            ->get()->getResultArray();
    }

    public function allDataBank()
    {
        return $this->db->table('tbl_account')
            ->where('kode_account <=', '1102.999')
            ->where('type_account', 'DETAIL')
            ->orderBy('kode_account', 'ASC')
            ->get()->getResultArray();
    }

    public function allDataBiaya()
    {
        return $this->db->table('tbl_account')
            ->where('kode_account >=', '6100.000')
            ->where('type_account', 'DETAIL')
            ->orderBy('kode_account', 'ASC')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_account')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tbl_account')
            ->where('kode_account', $data['kode_account'])
            ->update($data);
    }

    public function delete_data($data)
    {
        $this->db->table('tbl_account')
            ->where('kode_account', $data['kode_account'])
            ->delete($data);
    }

    public function detail($kode_account)
    {
        return $this->db->table('tbl_account')
            ->join('tbl_currency', 'tbl_currency.currency = tbl_account.currency')
            ->where('kode_account', $kode_account)
            ->get()->getRowArray();
    }

    public function detail2($kode_account)
    {
        return $this->db->table('tbl_account')
            ->where('kode_account', $kode_account)
            ->get()->getRowArray();
    }

    public function getAcct($kodeacct)
    {
        return $this->db->table('tbl_account')
            ->join('tbl_groupacc', 'tbl_groupacc.kode_group = tbl_account.kode_group')
            ->where('kode_account', $kodeacct)
            ->get()->getResultArray();
    }

    public function clearSaldo($data)
    {
        $this->db->table('tbl_account')
            ->where('kode_account', $data['kode_account'])
            ->update($data);
    }
    public function getSaldo()
    {
        return $this->db->table('tbl_account')
            ->orderBy('kode_account', 'ASC')
            ->get()->getResultArray();
    }

    public function hapus($kode_account)
    {
        $this->db->table('tbl_account')
            ->where('kode_account', $kode_account)
            ->delete();
    }

    

    public function allDataRange($kodeacct, $kodeacct2)
    {
        return $this->db->table('tbl_account')
            ->join('tbl_groupacc', 'tbl_groupacc.kode_group = tbl_account.kode_group', 'left')
            ->where('type_account', 'DETAIL')
            ->where('kode_account >=', $kodeacct)
            ->where('kode_account <=', $kodeacct2)
            ->orderBy('kode_account', 'ASC')
            ->get()->getResultArray();
    }
    
    public function allDataRl()
    {
        return $this->db->table('tbl_account')
            ->join('tbl_groupacc', 'tbl_groupacc.kode_group = tbl_account.kode_group', 'left')
            ->where('type_account', 'DETAIL')
            ->where('kode_account >=', '4101.000')
            ->orderBy('tbl_account.kode_group')
            ->orderBy('kode_account', 'ASC')
            ->get()->getResultArray();
    }

    public function allDataNeraca()
    {
        return $this->db->table('tbl_account')
            ->join('tbl_groupacc', 'tbl_groupacc.kode_group = tbl_account.kode_group', 'left')
            ->where('type_account', 'DETAIL')
            ->where('kode_account <', '4101.000')
            ->orderBy('tbl_account.kode_group')
            ->orderBy('kode_account', 'ASC')
            ->get()->getResultArray();
    }



    public function allDataInv()
    {
        return $this->db->table('tbl_account')
            ->join('tbl_groupacc', 'tbl_groupacc.kode_group = tbl_account.kode_group', 'left')
            ->where('kode_account >=', '110501')
            ->where('kode_account <=', '110599')
            ->where('type_account', 'DETAIL')
            ->orderBy('kode_account', 'ASC')
            ->get()->getResultArray();
    }

    public function carigroup($search)
    {
        return $this->db->table('tbl_groupacc')
            ->like('nama_group', $search)
            ->get()->getResultArray();
    }

}
