<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_user')
            ->orderBy('username', 'ASC')
            ->get()->getResultArray();
    }

    public function allLevel()
    {
        return $this->db->table('tbl_level')
            ->orderBy('level', 'ASC')
            ->get()->getResultArray();
    }

    public function detail($username)
    {
        return $this->db->table('tbl_user')
            ->where('username', $username)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_user')->insert($data);
    }


    public function edit($data)
    {
        $this->db->table('tbl_user')
            ->where('username', $data['username'])
            ->update($data);
    }

    public function resetpsw($data)
    {
        $this->db->table('tbl_user')
            ->where('username', $data['username'])
            ->update($data);
    }

    public function hapus($username)
    {
        $this->db->table('tbl_user')
            ->where('username', $username)
            ->delete();
    }
}
