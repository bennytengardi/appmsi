<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMerk extends Model
{
    protected $table = "tbl_merk";
    protected $primaryKey = 'kode_merk';
    protected $allowedFields = ['kode_merk', 'nama_merk'];

    public function allData()
    {
        return $this->db->table('tbl_merk')
            ->orderBy('kode_merk', 'ASC')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_merk')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tbl_merk')
            ->where('kode_merk', $data['kode_merk'])
            ->update($data);
    }

    public function hapus($kode_merk)
    {
        $this->db->table('tbl_merk')
            ->where('kode_merk', $kode_merk)
            ->delete();
    }
}
