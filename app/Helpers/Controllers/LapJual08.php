<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesInv;
use App\Models\ModelReceipt;
use App\Models\ModelLapJual08;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual08 extends BaseController
{
    function __construct()
    {
        $this->ModelReceipt  = new ModelReceipt();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelLapJual08 = new ModelLapJual08();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Outstanding Piutang',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'customer' => $this->ModelCustomer->alldata2(),
        ];
        return view('lapjual08/filter', $data);
    }

    public function preview()
    {
        $sampai    = $this->request->getPost('sampai');
        $kodecust  = $this->request->getPost('kode_customer');
        $title = "LAPORAN OUTSTANDING PIUTANG";
        $this->ModelLapJual08->clearOutstandingPiutang();

        if ($kodecust == "ALL") {
            $dcust = $this->ModelCustomer->allData2();
        } else {
            $dcust = $this->ModelCustomer->getCust($kodecust);
        }
        $trxdbt = $this->ModelLapJual08->trxDebet($sampai, $kodecust);

        foreach ($trxdbt as $trx1) {
            $tglbukti  = $trx1['tgl_invoice'];
            $duedate   = $trx1['due_date'];
            $nobukti   = $trx1['no_invoice'];
            $cust      = $trx1['kode_customer'];
            $nilai     = $trx1['total_invoice'];
            $bayar     = 0;
            $raw2 = [
                'no_invoice'    => $nobukti,
                'tgl_invoice'   => $tglbukti,
                'due_date'      => $duedate,
                'kode_customer' => $cust,
                'total_invoice' => $nilai,
                'total_bayar'   => $bayar
            ];
            $this->ModelLapJual08->insertOutstandingPiutang($raw2);
        }

        $trxcrd = $this->ModelLapJual08->trxCredit($sampai, $kodecust);
        foreach ($trxcrd as $trx2) {
            $noinvoice = $trx2['no_invoice'];
            $bayar     = $trx2['totbyr'];
            // $potongan  = $trx2['potongan'];
            $raw3 = [
                'no_invoice'  => $noinvoice,
                'total_bayar' => $bayar
                // + $potongan
            ];
            // dd($raw3);
            $this->ModelLapJual08->updateOutstandingPiutang($raw3);
        }

        $laporan = $this->ModelLapJual08->getOutstandingPiutang();
        // dd($laporan);
        $data = array(
            'title' => $title,
            'title1' => session()->get('nama_company'),
            'laporan' => $laporan,
            'kd' => $kodecust
        );

        return view('lapjual08/tampil', $data);
    }
}
