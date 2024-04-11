<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesman;
use App\Models\ModelSalesInv;
use App\Models\ModelReceipt;
use App\Models\ModelLapJual11;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual11 extends BaseController
{
    function __construct()
    {
        $this->ModelReceipt  = new ModelReceipt();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelSalesman = new ModelSalesman();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelLapJual11 = new ModelLapJual11();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Outstanding Piutang',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'salesman' => $this->ModelSalesman->alldata(),
        ];
        return view('lapjual11/filter', $data);
    }

    public function preview()
    {
        $sampai    = $this->request->getPost('sampai');
        $kodesales = $this->request->getPost('kode_salesman');

        $title = "LAPORAN OUTSTANDING PIUTANG";
        $this->ModelLapJual11->clearOutstandingPiutang();
        $dsls = $this->ModelSalesman->getSls($kodesales);
        $trxdbt = $this->ModelLapJual11->trxDebet($sampai, $kodesales);

        foreach ($trxdbt as $trx1) {
            $tglbukti  = $trx1['tgl_invoice'];
            $duedate   = $trx1['due_date'];
            $nobukti   = $trx1['no_invoice'];
            $sales     = $trx1['kode_salesman'];
            $cust      = $trx1['kode_customer'];
            $nilai     = $trx1['total_invoice'];
            $bayar     = 0;
            $raw2 = [
                'no_invoice'    => $nobukti,
                'tgl_invoice'   => $tglbukti,
                'due_date'      => $duedate,
                'kode_customer' => $cust,
                'kode_salesman' => $sales,
                'total_invoice' => $nilai,
                'total_bayar'   => $bayar
            ];

            $this->ModelLapJual11->insertOutstandingPiutang($raw2);
        }

        $trxcrd = $this->ModelLapJual11->trxCredit($sampai, $kodesales);
        foreach ($trxcrd as $trx2) {
            $noinvoice = $trx2['no_invoice'];
            $bayar     = $trx2['totbyr'];
            $raw3 = [
                'no_invoice'  => $noinvoice,
                'total_bayar' => $bayar
            ];
            $this->ModelLapJual11->updateOutstandingPiutang($raw3);
        }

        $laporan = $this->ModelLapJual11->getOutstandingPiutang();
        // dd($laporan);
        $data = array(
            'title' => $title,
            'title1' => session()->get('nama_company'),
            'salesman' => $this->ModelSalesman->detail($kodesales),
            'laporan' => $laporan,
        );
        // dd($laporan);
        return view('lapjual11/tampil', $data);
    }
}
