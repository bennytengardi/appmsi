<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesInv;
use App\Models\ModelBarang;
use App\Models\ModelLapJual16;
use Config\Services;

class LapJual16 extends BaseController
{
    function __construct()
    {
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelLapJual16 = new ModelLapJual16();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Tnda Terima',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'customer' => $this->ModelCustomer->alldata2(),
        ];
        return view('lapjual16/filter', $data);
    }

    public function viewDataCustomer()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');
            $data = [
                'keyword' => $keyword,
            ];
            $msg = [
                'viewmodal' => view('lapjual16/v_caricustomer', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodecust  = $this->request->getPost('kode_customer');
        $title = "TANDA TERIMA";
        $title1 = session()->get('nama_company');

        if (isset($tombolCetak)) {
            $data = array(
                'laporan' => $this->ModelLapJual16->lapjual16($dari, $sampai, $kodecust),
                'customer' => $this->ModelCustomer->detail($kodecust),
                'title' => $title,
                'title1' => $title1,
            );
            return view('lapjual16/tampil', $data);
        }
    }
}
