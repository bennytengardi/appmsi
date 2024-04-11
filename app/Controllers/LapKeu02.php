<?php

namespace App\Controllers;

use App\Models\ModelAccount;
use App\Models\ModelJurnal;
use App\Models\ModelLapKeu02;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapKeu02 extends BaseController
{
    function __construct()
    {
        $this->ModelAccount  = new ModelAccount();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelLapKeu02 = new ModelLapKeu02();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Neraca Saldo',
            'dari'   => date("Y-m-01"),
            'sampai' => date("Y-m-d"),
        ];
        return view('lapkeu02/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $title = "Trial Balance";
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

        $awl = $this->ModelLapKeu02->awalSaldo($dari);
        foreach ($awl as $aw1) {
            $acct  = $aw1['kode_account'];
            $debet  = $aw1['awaldbt'];
            $credit = $aw1['awalcrd'];
            $raw1 = [
                'kode_account' => $acct,
                'awldbt' => $debet,
                'awlcrd' => $credit,
            ];
            $this->ModelLapKeu02->updateSaldoAwal($raw1);
        }


        $trx = $this->ModelLapKeu02->trx($dari, $sampai);
        foreach ($trx as $raw) {
            $acct   = $raw['kode_account'];
            $debet  = $raw['trxdbt'];
            $credit = $raw['trxcrd'];
            $raw2 = [
                'kode_account' => $acct,
                'dbt' => $debet,
                'crd' => $credit,
            ];
            $this->ModelLapKeu02->updateSaldoAwal($raw2);
        }

        $tahun = substr($dari, 0, 4);
        $tg4 = strtotime("01/01/" . $tahun);
        $tg3 = strtotime("01/01/2000");
        $tgl4 = date('Y-m-d', $tg4);
        $tgl3 = date('Y-m-d', $tg3);
        $tgl2 = date('Y-m-d', strtotime('-1 days', strtotime($dari)));
        $rllalu = $this->ModelLapKeu02->rllalu($tgl3, $tgl4);
        $rlini  = $this->ModelLapKeu02->rlini($tgl4, $tgl2);
        $acct1 = '3201.001';
        $acct2 = '3301.001';

        $data = [
            'awlcrd' => $rllalu[0],
            'kode_account' => $acct1
        ];
        $this->ModelLapKeu02->updateSaldoAwal($data);

        $data1 = [
            'awlcrd' => $rlini[0],
            'kode_account' => $acct2
        ];
        $this->ModelLapKeu02->updateSaldoAwal($data1);
        $laporan = $this->ModelAccount->allDataDetail();

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('lapkeu02/tampil', $data);
        }

        if (isset($tombolExport)) {
            // HEADER
            $spreadsheet = new Spreadsheet;
            $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
            $spreadsheet->getActiveSheet()->mergeCells('A1:H1');
            $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
            $spreadsheet->getActiveSheet()->mergeCells('A3:H3');

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
            $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);

            $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

            $spreadsheet->getActiveSheet()->getStyle('A5:H6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle('A5:H6')->getFill()->getStartColor()->setARGB('FF4F81BD');
            $spreadsheet->getActiveSheet()->getStyle('A5:H6')
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $spreadsheet->getActiveSheet()->getStyle('A5:H6')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);

            $spreadsheet->getActiveSheet()->mergeCells('C5:D5');
            $spreadsheet->getActiveSheet()->mergeCells('E5:F5');
            $spreadsheet->getActiveSheet()->mergeCells('G5:H5');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'Beginning Balance');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'Mutasi');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'Ending Balance');

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A6', 'Acct No');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B6', 'Account Name');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C6', 'Debit');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D6', 'Credit');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E6', 'Debit');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F6', 'Credit');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G6', 'Debit');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H6', 'Credit');


            $kolom = 7;
            $nomor = 1;
            $totawldbt = 0;
            $totawlcrd = 0;
            $totdbt = 0;
            $totcrd = 0;
            $totakhdbt = 0;
            $totakhcrd = 0;

            // DETAIL

            foreach ($laporan as $lap) {
                $totdbt = $totdbt + $lap['dbt'];
                $totcrd = $totcrd + $lap['crd'];
                if ($lap['position'] == 'DB') {
                    if ($lap['kode_account'] < '410101') {
                        $totawldbt = $totawldbt + $lap['saldo_awal'] + $lap['awldbt'] - $lap['awlcrd'];
                    }
                    $totakhdbt = $totakhdbt + $lap['saldo_awal'] + $lap['awldbt'] + $lap['dbt'] - $lap['awlcrd'] - $lap['crd'];
                } else {
                    if ($lap['kode_account'] < '410101') {
                        $totawlcrd = $totawlcrd + $lap['saldo_awal'] + $lap['awlcrd'] - $lap['awldbt'];
                    }
                    $totakhcrd = $totakhcrd + $lap['saldo_awal'] + $lap['awlcrd'] + $lap['crd'] - $lap['awldbt'] - $lap['dbt'];
                }
                $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');

                $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['kode_account']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $lap['nama_account']);
                if ($lap['position'] == 'DB') {
                    if ($lap['kode_account'] < '410101') {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['saldo_awal'] + $lap['awldbt'] - $lap['awlcrd']);
                    } else {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, 0);
                    }
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, 0);
                } else {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, 0);
                    if ($lap['kode_account'] < '410101') {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['saldo_awal'] + $lap['awlcrd'] - $lap['awldbt']);
                    } else {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, 0);
                    }
                }
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['dbt']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $lap['crd']);
                if ($lap['position'] == 'DB') {
                    if ($lap['kode_account'] < '410101') {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $lap['saldo_awal'] + $lap['awldbt'] + $lap['dbt'] - $lap['awlcrd'] - $lap['crd']);
                    } else {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 0);
                    }
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, 0);
                } else {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, 0);
                    if ($lap['kode_account'] < '410101') {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $lap['saldo_awal'] + $lap['awlcrd'] + $lap['crd'] - $lap['awldbt'] - $lap['dbt']);
                    } else {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, 0);
                    }
                }
                $kolom++;
                $nomor++;
            }

            // FOOTER TOTAL

            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'B' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $totawldbt);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $totawlcrd);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $totdbt);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $totcrd);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $totakhdbt);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $totakhcrd);

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapkeu02' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
