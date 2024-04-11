<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesInv;
use App\Models\ModelLapJual13;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual13 extends BaseController
{
    function __construct()
    {
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelLapJual13 = new ModelLapJual13();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan Penjualan',
            'tahun'  => date("Y"),
        ];
        return view('lapjual13/filter', $data);
    }

    public function preview()
    {
        $tahun  = $this->request->getPost('tahun');
        $title = "LAPORAN PENJUALAN TAHUNAN";
        $customer = $this->ModelCustomer->allData();
        foreach ($customer as $cus) {
            $data = [
                'kode_customer' => $cus['kode_customer'],
                'sales1' => 0,
                'sales2' => 0,
                'sales3' => 0,
                'sales4' => 0,
                'sales5' => 0,
                'sales6' => 0,
                'sales7' => 0,
                'sales8' => 0,
                'sales9' => 0,
                'sales10' => 0,
                'sales11' => 0,
                'sales12' => 0,
            ];
            $this->ModelCustomer->clearSaldo($data);
        }
        $datajual = $this->ModelLapJual13->lapjual13($tahun);

        foreach ($datajual as $djl) {
            $cust = $djl['kode_customer'];
            $nilai = $djl['total'];
            $bulan = $djl['bulan'];
            $raw1 = [
                'kode_customer' => $cust,
                'sales' . $bulan => $nilai
            ];
            $this->ModelCustomer->updateSales($raw1);
        }

        $lap = $this->ModelCustomer->allData2();

        // dd($laporan);
        $data = array(
            'title' => $title,
            'tahun' => $tahun,
            'title1' => session()->get('nama_company'),
            'laporan' => $lap
        );

        return view('lapjual13/tampil', $data);
    }
}
