<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesInv;
use App\Models\ModelReceipt;
use App\Models\ModelLapJual07;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual07 extends BaseController
{
    function __construct()
    {
        $this->ModelReceipt  = new ModelReceipt();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelLapJual07 = new ModelLapJual07();
    }

    public function index()
    {
        $data = [
            'title'  => 'AR Subsidary Ledger Detail',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'customer' => $this->ModelCustomer->allData2(),
        ];
        return view('lapjual07/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodecust  = $this->request->getPost('kode_customer');
        $title1    = session()->get('nama_company');

        $title = "AR Subsidary Ledger Detail";
        $customer = $this->ModelCustomer->allData();
        foreach ($customer as $cus) {
            $data = [
                'kode_customer' => $cus['kode_customer'],
                'awldbt' => 0,
                'awlcrd' => 0,
                'crd' => 0,
                'dbt' => 0
            ];
            $this->ModelCustomer->clearSaldo($data);
        }

        $awldbt = $this->ModelLapJual07->awalDebet($dari, $kodecust);
        foreach ($awldbt as $aw1) {
            $cust = $aw1['kode_customer'];
            $nilai = $aw1['awldbt'];
            $raw1 = [
                'kode_customer' => $cust,
                'awldbt' => $nilai
            ];
            $this->ModelLapJual07->updateSaldoAwal($raw1);
        }
        $awlcrd = $this->ModelLapJual07->awalCredit($dari, $kodecust);
        foreach ($awlcrd as $aw1) {
            $cust = $aw1['kode_customer'];
            $nilai = $aw1['awlcrd'];
            $raw2 = [
                'kode_customer' => $cust,
                'awlcrd' => $nilai
            ];

            $this->ModelLapJual07->updateSaldoAwal($raw2);
        }

        $this->ModelLapJual07->clearKartuPiutang();


        if ($kodecust == "ALL") {
            $dcust = $this->ModelCustomer->allData();
        } else {
            $dcust = $this->ModelCustomer->getCust($kodecust);
        }
        // dd($dcust);

        foreach ($dcust as $aw3) {
            $tglbukti  = date('Y-m-d', strtotime('-1 days', strtotime($dari)));
            $nobukti   = '';
            $rectype   = '1';
            $cust      = $aw3['kode_customer'];
            $nilai     = $aw3['awal'] + $aw3['awldbt'] - $aw3['awlcrd'];
            $raw1 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => 'Saldo Awal',
                'kode_customer' => $cust,
                'saldo'         => $nilai,
                'rectype'       => $rectype
            ];

            $this->ModelLapJual07->insertKartuPiutang($raw1);
        }


        $trxdbt = $this->ModelLapJual07->trxDebet($dari, $sampai, $kodecust);
        foreach ($trxdbt as $trx1) {
            $tglbukti  = $trx1['tgl_invoice'];
            $nobukti   = $trx1['no_invoice'];
            $rectype   = '1';
            $keterangan = 'Penjualan';
            $cust      = $trx1['kode_customer'];
            $nilai     = $trx1['total_invoice'];
            $raw2 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_customer' => $cust,
                'masuk'         => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapJual07->insertKartuPiutang($raw2);
        }

        $trxcrd = $this->ModelLapJual07->trxCredit($dari, $sampai, $kodecust);
        foreach ($trxcrd as $trx2) {
            $tglbukti  = $trx2['tgl_receipt'];
            $nobukti   = $trx2['no_receipt'];
            $rectype   = '2';
            $keterangan = 'Pelunasan';
            $cust      = $trx2['kode_customer'];
            $nilai     = $trx2['total_bayar'] + $trx2['total_potongan'] + $trx2['total_pph23'] + $trx2['total_pph4'] + $trx2['total_admin'];
            $raw3 = [
                'tgl_bukti'     => $tglbukti,
                'no_bukti'      => $nobukti,
                'keterangan'    => $keterangan,
                'kode_customer' => $cust,
                'keluar'        => $nilai,
                'rectype'       => $rectype
            ];
            $this->ModelLapJual07->insertKartuPiutang($raw3);
        }

        $laporan = $this->ModelLapJual07->getKartuPiutang();

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('lapjual07/tampil', $data);
        }


        if (isset($tombolExport)) {
            $spreadsheet = new Spreadsheet;
            $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
            $spreadsheet->getActiveSheet()->mergeCells('A1:F1');
            $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
            $spreadsheet->getActiveSheet()->mergeCells('A3:F3');

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
            $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

            $spreadsheet->getActiveSheet()->getStyle('A5:F5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle('A5:F5')->getFill()->getStartColor()->setARGB('FF4F81BD');
            $spreadsheet->getActiveSheet()->getStyle('A5:F5')
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $spreadsheet->getActiveSheet()->getStyle('A5:F5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'Date');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'Source No');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'Description');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'Sales Invoice');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'Sales Receipt');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'Balance');


            $kolom = 6;
            $totdbt = 0;
            $totcrd = 0;
            $saldo = 0;
            $sw = 0;
            $kdcust = '';
            // DETAIL

            foreach ($laporan as $lap) {
                if ($kdcust <> $lap['kode_customer']) {
                    if ($sw == 1) {
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'C' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $totdbt);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totcrd);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);

                        $kolom = $kolom + 1;
                        $totdbt = 0;
                        $totcrd = 0;
                    }

                    $kolom = $kolom + 1;
                    $det = $lap['nama_customer'];
                    $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'F' . $kolom);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $det);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $kdcust = $lap['kode_customer'];
                    $saldo  = $lap['saldo'];
                    $kolom  = $kolom + 1;
                }

                $totdbt = $totdbt + $lap['masuk'];
                $totcrd = $totcrd + $lap['keluar'];
                $saldo  = $saldo + $lap['masuk'] - $lap['keluar'];
                $sw = 1;

                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, date('d-M-Y', strtotime($lap['tgl_bukti'])));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $lap['no_bukti']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['keterangan']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['masuk']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['keluar']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $saldo);
                $kolom++;
            }

            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'C' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $totdbt);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totcrd);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getFont()->setBold(true);

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapjual07' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
