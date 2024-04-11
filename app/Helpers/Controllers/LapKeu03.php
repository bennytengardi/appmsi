<?php

namespace App\Controllers;

use App\Models\ModelAccount;
use App\Models\ModelJurnal;
use App\Models\ModelLapKeu03;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapKeu03 extends BaseController
{
    function __construct()
    {
        $this->ModelAccount  = new ModelAccount();
        $this->ModelJurnal   = new ModelJurnal();
        $this->ModelLapKeu03 = new ModelLapKeu03();
    }

    public function index()
    {
        $data = [
            'title'  => 'Profit & Loss',
            'dari'   => date("Y-m-01"),
            'sampai' => date("Y-m-d"),
        ];
        return view('lapkeu03/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $title = "Profit & Loss";
        $title1 = session()->get('nama_company');

        $account = $this->ModelAccount->allDataRl();

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

        $awl = $this->ModelLapKeu03->rugiLaba($dari, $sampai);

        foreach ($awl as $aw1) {
            $acct  = $aw1['kode_account'];
            $debet  = $aw1['dbt'];
            $credit = $aw1['crd'];
            $raw1 = [
                'kode_account' => $acct,
                'dbt' => $debet,
                'crd' => $credit,
            ];
            $this->ModelLapKeu03->updateSaldo($raw1);
        }

        $laporan = $this->ModelAccount->allDataRl();
        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('lapkeu03/tampil', $data);
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
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);

            $kolom = 6;
            $nomor = 1;
            $total = 0;
            $totalrl = 0;
            $sw = 0;
            $kdgrup = '';


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

                    if ($lap['kode_group'] == '710') {
                        $spreadsheet->getActiveSheet()->getStyle('B' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('B' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'LABA/RUGI KOTOR');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $totalrl);
                    }

                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_group']);
                    $kdgrup = $lap['kode_group'];
                    $total = 0;
                    $kolom = $kolom + 1;
                }

                if ($lap['position'] == 'DB') {
                    $saldo  = $lap['dbt'] - $lap['crd'];
                } else {
                    $saldo =  $lap['crd'] - $lap['dbt'];
                }
                $total  = $total + $saldo;
                $totalrl = $totalrl + $lap['crd'] - $lap['dbt'];
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
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL RUGI/LABA');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $totalrl);


            // FOOTER TOTAL

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapkeu03' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
