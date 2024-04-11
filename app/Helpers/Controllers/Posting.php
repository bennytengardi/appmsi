<?php

namespace App\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelPosting;
use Config\Services;


class Posting extends BaseController
{
    function __construct()
    {
        $this->ModelBarang = new ModelBarang();
        $this->ModelPosting = new ModelPosting();
    }

    public function index()
    {
        $data = [
            'title'  => 'Posting',
        ];
        return view('posting/filter', $data);
    }

    public function proses()
    {

        $title = "Proses Posting";
        $barang = $this->ModelBarang->allData();
        foreach ($barang as $bak) {
            $data = [
                'kode_barang' => $bak['kode_barang'],
                'masuk' => 0,
                'keluar' => 0,
                'adjust' => 0
            ];
            $this->ModelPosting->clearSaldo($data);
        }

        $penjualan = $this->ModelPosting->penjualan();
        foreach ($penjualan as $jual) {
            $barang = $jual['kode_barang'];
            $qty    = $jual['totjual'];
            $raw1 = [
                'kode_barang' => $barang,
                'keluar' => $qty
            ];
            $this->ModelPosting->updateSaldo($raw1);
        }

        $produksi = $this->ModelPosting->produksi();
        foreach ($produksi as $prod) {
            $barang = $prod['kode_barang'];
            $qty    = $prod['tothasil'];
            $raw1 = [
                'kode_barang' => $barang,
                'masuk' => $qty
            ];
            $this->ModelPosting->updateSaldo($raw1);
        }


        $adjustment = $this->ModelPosting->adjustment();
        foreach ($adjustment as $adj) {
            $barang = $adj['kode_barang'];
            $qty    = $adj['totadjust'];
            $raw1 = [
                'kode_barang' => $barang,
                'adjust' => $qty
            ];
            $this->ModelPosting->updateSaldo($raw1);
        }

        return redirect()->to(base_url('admin'));
    }
}
