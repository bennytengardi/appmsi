<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCurrency extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_currency')
            ->orderBy('currency', 'ASC')
            ->get()->getResultArray();
    }

    public function detail($currency)
    {
        return $this->db->table('tbl_currency')
            ->where('currency', $currency)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_currency')->insert($data);
    }


    public function edit($data)
    {
        $this->db->table('tbl_currency')
            ->where('currency', $data['currency'])
            ->update($data);
    }


    public function hapus($currency)
    {
        $this->db->table('tbl_currency')
            ->where('currency', $currency)
            ->delete();
    }

}
