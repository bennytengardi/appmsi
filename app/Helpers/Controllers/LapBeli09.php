<?php

namespace App\Controllers;

use App\Models\ModelSupplier;
use App\Models\ModelPurchInv;
use App\Models\ModelLapBeli09;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapBeli09 extends BaseController
{
    function __construct()
    {
        $this->ModelPurchInv = new ModelPurchInv();
        $this->ModelSupplier = new ModelSupplier();
        $this->ModelLapBeli09 = new ModelLapBeli09();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan Pembelian',
            'tahun'  => date("Y"),
        ];
        return view('lapbeli09/filter', $data);
    }

    public function preview()
    {
        $tahun  = $this->request->getPost('tahun');
        $title = "LAPORAN PEMBELIAN TAHUNAN";

        $supplier = $this->ModelSupplier->allData();
        foreach ($supplier as $sup) {
            $data = [
                'kode_supplier' => $sup['kode_supplier'],
                'beli1' => 0,
                'beli2' => 0,
                'beli3' => 0,
                'beli4' => 0,
                'beli5' => 0,
                'beli6' => 0,
                'beli7' => 0,
                'beli8' => 0,
                'beli9' => 0,
                'beli10' => 0,
                'beli11' => 0,
                'beli12' => 0,
            ];
            $this->ModelSupplier->clearSaldo($data);
        }
        $databeli = $this->ModelLapBeli09->lapbeli09($tahun);

        foreach ($databeli as $djl) {
            $supp = $djl['kode_supplier'];
            $nilai = $djl['total'];
            $bulan = $djl['bulan'];
            $raw1 = [
                'kode_supplier' => $supp,
                'beli' . $bulan => $nilai
            ];
            $this->ModelSupplier->updateSales($raw1);
        }
        $lap = $this->ModelSupplier->allData();

        // dd($laporan);
        $data = array(
            'title' => $title,
            'tahun' => $tahun,
            'title1' => session()->get('nama_company'),
            'laporan' => $lap
        );

        return view('lapbeli09/tampil', $data);
    }
}
