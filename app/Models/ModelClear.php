<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelClear extends Model
{
    public function clearCart()
    {
        $this->db->table('keranjangjual')->emptyTable();
        $this->db->table('keranjangbeli')->emptyTable();
        $this->db->table('keranjangothrcv')->emptyTable();
        $this->db->table('keranjangothpay')->emptyTable();
        $this->db->table('keranjangsj')->emptyTable();
        $this->db->table('keranjangpo')->emptyTable();
        $this->db->table('keranjangpr')->emptyTable();
        $this->db->table('keranjangsr')->emptyTable();
        $this->db->table('keranjangso')->emptyTable();
    }

}
