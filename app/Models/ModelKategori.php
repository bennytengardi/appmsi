<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategori extends Model
{
    protected $table = "tbl_kategori";
    protected $primaryKey = 'kode_kategori';
    protected $allowedFields = ['kode_kategori', 'nama_kategori'];

    public function allData()
    {
        return $this->db->table('tbl_kategori')
            ->orderBy('nama_kategori', 'ASC')
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_kategori')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tbl_kategori')
            ->where('kode_kategori', $data['kode_kategori'])
            ->update($data);
    }

    public function hapus($kode_kategori)
    {
        $this->db->table('tbl_kategori')
            ->where('kode_kategori', $kode_kategori)
            ->delete();
    }

    public function detail($kode_kategori)
    {
        return $this->db->table('tbl_kategori')
            ->where('kode_kategori', $kode_kategori)
            ->get()->getRowArray();
    }
}
