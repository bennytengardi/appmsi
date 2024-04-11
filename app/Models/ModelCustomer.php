<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCustomer extends Model
{

    public function allData()
    {
        return $this->db->table('tbl_customer')
            // ->join('tbl_salesman', 'tbl_salesman.kode_salesman = tbl_customer.kode_salesman', 'left')
            ->orderBy('kode_customer', 'DESC')
            ->get()->getResultArray();
    }

    public function allData1()
    {
        return $this->db->table('tbl_customer')
            ->join('tbl_salesman', 'tbl_salesman.kode_salesman = tbl_customer.kode_salesman', 'left')
            ->orderBy('kode_customer', 'DESC')
            ->get()->getResultArray();
    }

    public function allData2()
    {
        return $this->db->table('tbl_customer')
            // ->join('tbl_salesman', 'tbl_salesman.kode_salesman = tbl_customer.kode_salesman', 'left')
            ->orderBy('nama_customer', 'ASC')
            ->get()->getResultArray();
    }

    public function allBank()
    {
        return $this->db->table('tbl_bank')
            ->orderBy('no_account', 'ASC')
            ->get()->getResultArray();
    }

    public function allDataPkp()
    {
        return $this->db->table('tbl_customer')
            // ->join('tbl_salesman', 'tbl_salesman.kode_salesman = tbl_customer.kode_salesman', 'left')
            ->orderBy('kode_customer', 'DESC')
            ->where('status', 'PKP')
            ->get()->getResultArray();
    }
    public function allDataNon()
    {
        return $this->db->table('tbl_customer')
            // ->join('tbl_salesman', 'tbl_salesman.kode_salesman = tbl_customer.kode_salesman', 'left')
            ->orderBy('kode_customer', 'DESC')
            ->where('status', 'NON PKP')
            ->get()->getResultArray();
    }

    public function detail($kode_customer)
    {
        return $this->db->table('tbl_customer')
            // ->join('tbl_salesman', 'tbl_salesman.kode_salesman = tbl_customer.kode_salesman', 'left')
            ->where('kode_customer', $kode_customer)
            ->get()->getRowArray();
    }

    public function getCust($kode_customer)
    {
        return $this->db->table('tbl_customer')
            // ->join('tbl_salesman', 'tbl_salesman.kode_salesman = tbl_customer.kode_salesman', 'left')
            ->where('kode_customer', $kode_customer)
            ->get()->getResultArray();
    }

    public function add($data)
    {
        $this->db->table('tbl_customer')->insert($data);
    }


    public function edit($data)
    {
        $this->db->table('tbl_customer')
            // ->join('tbl_salesman', 'tbl_salesman.kode_salesman = tbl_customer.kode_salesman', 'left')
            ->where('kode_customer', $data['kode_customer'])
            ->update($data);
    }

    public function updateSales($raw1)
    {
        $this->db->table('tbl_customer')
            ->where('kode_customer', $raw1['kode_customer'])
            ->update($raw1);
    }

    public function hapus($kode_customer)
    {
        $this->db->table('tbl_customer')
            ->where('kode_customer', $kode_customer)
            ->delete();
    }

    public function clearSaldo($data)
    {
        $this->db->table('tbl_customer')
            ->where('kode_customer', $data['kode_customer'])
            ->update($data);
    }

    public function getSaldo()
    {
        return $this->db->table('tbl_customer')
            ->orderBy('nama_customer', 'ASC')
            ->get()->getResultArray();
    }



    public function detail_saldo($kode_customer)
    {
        return $this->db->table('tbl_salesinv')
            // ->join('tbl_customer', 'tbl_customer.kode_customer = tbl_salesinv.kode_customer', 'left')
            ->where('tbl_salesinv.kode_customer', $kode_customer)
            ->where('tbl_salesinv.awal >', 0)
            ->get()->getResultArray();
    }

    public function clearCart()
    {
        $this->db->table('keranjangawalpiu')->emptyTable();
    }

    public function addCart($data)
    {
        $this->db->table('keranjangawalpiu')->insert($data);
    }

    public function getCart()
    {
        return  $this->db->table('keranjangawalpiu')
            ->where('total_invoice >', 0)
            ->get()->getResultArray();
    }

    public function editCart($data)
    {
        $this->db->table('keranjangawalpiu')
            ->where('no_invoice', $data['no_invoice'])
            ->update($data);
    }

    public function deleteCart($noinvoice)
    {
        $this->db->table('keranjangawalpiu')
            ->where('no_invoice', $noinvoice)
            ->delete();
    }

    public function delete_salesinv($kode_customer)
    {
        $this->db->table('tbl_salesinv')
            ->where('awal >', 0)
            ->where('kode_customer', $kode_customer)
            ->delete();
    }

    public function add_salesinv($data)
    {
        $this->db->table('tbl_salesinv')->insert($data);
    }

    public function ambilDataCart()
    {
        return  $this->db->table('keranjangawalpiu')->get()->getResultArray();
    }

    public function caricustomer($search)
    {
        return $this->db->table('tbl_customer')
            ->like('nama_customer', $search)
            ->get()->getResultArray();
    }


}
