<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSupplier extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_supplier')
            ->orderBy('kode_supplier', 'DESC')
            ->get()->getResultArray();
    }

    public function allData2()
    {
        return $this->db->table('tbl_supplier')
            ->orderBy('nama_supplier', 'ASC')
            ->get()->getResultArray();
    }


    public function detail($kode_supplier)
    {
        return $this->db->table('tbl_supplier')
        ->join('tbl_currency', 'tbl_currency.currency = tbl_supplier.currency')
        ->where('kode_supplier', $kode_supplier)
        ->get()->getRowArray();
    }

    public function getSupp($kode_supplier)
    {
        return $this->db->table('tbl_supplier')
            ->where('kode_supplier', $kode_supplier)
            ->get()->getResultArray();
    }


    public function add($data)
    {
        $this->db->table('tbl_supplier')->insert($data);
    }

    public function addSaldo($data)
    {
        $this->db->table('tbl_purchinv')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tbl_supplier')
            ->where('kode_supplier', $data['kode_supplier'])
            ->update($data);
    }

    public function updateSales($raw1)
    {
        $this->db->table('tbl_supplier')
            ->where('kode_supplier', $raw1['kode_supplier'])
            ->update($raw1);
    }

    public function hapus($kode_supplier)
    {
        $this->db->table('tbl_supplier')
            ->where('kode_supplier', $kode_supplier)
            ->delete();
    }

    public function hapusRincianSaldoAwal($kode_supplier)
    {
        $this->db->table('tbl_purchinv')
            ->where('kode_supplier', $kode_supplier)
            ->where('awal >', 0)
            ->delete();
    }


    public function clearSaldo($data)
    {
        $this->db->table('tbl_supplier')
            ->where('kode_supplier', $data['kode_supplier'])
            ->update($data);
    }
    public function getSaldo()
    {
        return $this->db->table('tbl_supplier')
            ->orderBy('kode_supplier', 'ASC')
            ->get()->getResultArray();
    }



    public function detail_saldo($kode_supplier)
    {
        return $this->db->table('tbl_purchinv')
            ->where('kode_supplier', $kode_supplier)
            ->where('awal >', 0)
            ->get()->getResultArray();
    }

    public function clearCart()
    {
        $this->db->table('keranjangawal')->emptyTable();
    }

    public function addCart($data)
    {
        $this->db->table('keranjangawal')->insert($data);
    }

    public function getCart()
    {
        return  $this->db->table('keranjangawal')
            ->where('total_invoice >', 0)
            ->get()->getResultArray();
    }

    public function editCart($data)
    {
        $this->db->table('keranjangawal')
            ->where('no_invoice', $data['no_invoice'])
            ->update($data);
    }

    public function deleteCart($noinvoice)
    {
        $this->db->table('keranjangawal')
            ->where('no_invoice', $noinvoice)
            ->delete();
    }

    public function delete_purchinv($kode_supplier)
    {
        $this->db->table('tbl_purchinv')
            ->where('awal >', 0)
            ->where('kode_supplier', $kode_supplier)
            ->delete();
    }

    public function add_purchinv($data)
    {
        $this->db->table('tbl_purchinv')->insert($data);
    }

    public function ambilDataCart()
    {
        return  $this->db->table('keranjangawal')->get()->getResultArray();
    }
}
