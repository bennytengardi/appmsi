<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSatuan extends Model
{
    protected $table = "tbl_satuan";
    protected $primaryKey = 'kode_satuan';
    protected $allowedFields = ['kode_satuan', 'nama_satuan'];

    public function allData()
    {
        return $this->db->table('tbl_satuan')
            ->orderBy('kode_satuan', 'ASC')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_satuan')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tbl_satuan')
            ->where('kode_satuan', $data['kode_satuan'])
            ->update($data);
    }

    public function hapus($kode_satuan)
    {
        $this->db->table('tbl_satuan')
            ->where('kode_satuan', $kode_satuan)
            ->delete();
    }
}
