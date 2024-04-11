<?php

namespace App\Controllers;

use App\Models\ModelAccount;
use App\Models\ModelJurnal;
use App\Models\ModelLapKeu04;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapKeu04 extends BaseController
{
    function __construct()
    {
        $this->ModelAccount  = new ModelAccount();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelLapKeu04 = new ModelLapKeu04();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Neraca',
            'sampai' => date("Y-m-d"),
        ];
        return view('lapkeu04/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $sampai = $this->request->getPost('sampai');
        $title  = "Balance Sheet";
        $title1 = session()->get('nama_company');
        $account = $this->ModelAccount->allDataDetail();

        foreach ($account as $acc) {
            $data = [
                'kode_account' => $acc['kode_account'],
                'awldbt' => 0,
                'awlcrd' => 0,
                'crd' => 0,
                'dbt' => 0
            ];
            $this->ModelAccount->clearSaldo($data);
        }
        $awl = $this->ModelLapKeu04->Neraca($sampai);
        
    

        foreach ($awl as $aw1) {
            $acct   = $aw1['kode_account'];
            $debet  = $aw1['dbt'];
            $credit = $aw1['crd'];
            $raw1 = [
                'kode_account' => $acct,
                'dbt' => $debet,
                'crd' => $credit,
            ];
            $this->ModelLapKeu04->updateSaldo($raw1);
        }


        // Hitung Rugi Laba Tahun Lalu & Laba Tahun ini

        $tahun = substr($sampai, 0, 4);
        $tg4 = strtotime("01/01/" . $tahun);
        $tg3 = strtotime("01/01/2000");
        $tgl4 = date('Y-m-d', $tg4);
        $tgl3 = date('Y-m-d', $tg3);
        $rllalu = $this->ModelLapKeu04->rllalu($tgl3, $tgl4);
        $rlini  = $this->ModelLapKeu04->rlini($tgl4, $sampai);
        $acct1 = '3201.001';
        $acct2 = '3301.001';

        $data = [
            'crd' => $rllalu[0],
            'kode_account' => $acct1
        ];
        $this->ModelLapKeu04->updateSaldo($data);

        $data1 = [
            'crd' => $rlini[0],
            'kode_account' => $acct2
        ];
        $this->ModelLapKeu04->updateSaldo($data1);


        $data1 = $this->ModelLapKeu04->Balance();
        $this->ModelLapKeu04->clearNeraca();


        foreach ($data1 as $dt1) {
            if ($dt1['sub_account'] != null) {
                if ($dt1['sub_account'] > '2000') {
                    $rec = '2';
                } else {
                    $rec = '1';
                }
                $data = [
                    'kode_account' => $dt1['sub_account'],
                    'saldoawal'    => $dt1['sldawal'],
                    'trxdebet'     => $dt1['slddbt'],
                    'trxcredit'    => $dt1['sldcrd'],
                    'rectype'      => $rec
                ];
                $this->ModelLapKeu04->insertNeraca($data);
            }
        }

        $laporan = $this->ModelLapKeu04->saldoNeraca();
        dd($laporan);

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('lapkeu04/tampil', $data);
        }

        if (isset($tombolExport)) {
            // HEADER
            $spreadsheet = new Spreadsheet;
            $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
            $spreadsheet->getActiveSheet()->mergeCells('A1:B1');
            $spreadsheet->getActiveSheet()->mergeCells('A2:B2');
            $spreadsheet->getActiveSheet()->mergeCells('A3:B3');

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
            $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);

            $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($sampai)));

            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);

            $total = 0;
            $taktiva = 0;
            $tpassiva = 0;
            $sw = 0;
            $kdgrup = '';
            $nmgrup = '';
            $rec = '';
            $kolom = 6;


            // DETAIL

            foreach ($laporan as $lap) {
                if ($kdgrup != $lap['kode_group']) {
                    if ($sw == 1) {
                        $spreadsheet->getActiveSheet()->getStyle('B' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('B' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL ' . $nmgrup);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $total);
                        $total = 0;
                        $kolom = $kolom + 2;
                    }

                    if ($lap['kode_group'] == '13') {
                        $spreadsheet->getActiveSheet()->getStyle('B' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('B' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL AKTIVA');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $taktiva);
                        $kolom = $kolom + 2;
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'PASSIVA');
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    }

                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_group']);
                    $kdgrup = $lap['kode_group'];
                    $total = 0;
                    $kolom = $kolom + 1;
                }

                if ($lap['position'] == 'DB') {
                    $saldo  = $lap['saldoawal'] + $lap['trxdebet'] - $lap['trxcredit'];
                } else {
                    $saldo =  $lap['saldoawal'] + $lap['trxcredit'] - $lap['trxdebet'];
                }

                if ($lap['rectype'] == '1') {
                    $taktiva  = $taktiva + $saldo;
                } else {
                    $tpassiva = $tpassiva + $saldo;
                }
                $total = $total + $saldo;

                $nmgrup = $lap['nama_group'];
                $sw = 1;
                if ($saldo != 0) {
                    $spreadsheet->getActiveSheet()->getStyle('B' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_account']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $saldo);
                    $kolom++;
                }
            }

            $spreadsheet->getActiveSheet()->getStyle('B' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL ' . $nmgrup);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $total);

            $kolom = $kolom + 2;

            $spreadsheet->getActiveSheet()->getStyle('B' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL PASSIVA');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $tpassiva);


            // FOOTER TOTAL

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapkeu04' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
