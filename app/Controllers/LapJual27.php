<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesInv;
use App\Models\ModelLapJual27;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual27 extends BaseController
{
    function __construct()
    {
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelLapJual27 = new ModelLapJual27();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan Invoice [Pajak]',
            'dari'   => date("Y-m-01"),
            'sampai' => date("Y-m-d"),
        ];
        return view('lapjual27/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $typelap   = $this->request->getPost('typelap');
        $title = "Laporan Invoice [Pajak]";
        $title1 = session()->get('nama_company');
        $laporan = $this->ModelLapJual27->lapjual27($dari, $sampai);


        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => $title1,
                'laporan' => $laporan,
            );
            return view('lapjual27/tampil', $data);
        }

        if (isset($tombolExport)) {
                $spreadsheet = new Spreadsheet;
                $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
                $spreadsheet->getActiveSheet()->mergeCells('A1:J1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:J2');
                $spreadsheet->getActiveSheet()->mergeCells('A3:J3');

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

                $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

                $spreadsheet->getActiveSheet()->getStyle('A5:J5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('A5:J5')->getFill()->getStartColor()->setARGB('FF4F81BD');
                $spreadsheet->getActiveSheet()->getStyle('A5:J5')
                    ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $spreadsheet->getActiveSheet()->getStyle('A5:J5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(18);
                $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(18);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NO INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'TGL INVOICE');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'NO DO');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'NAMA CUSTOMER');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'TOTAL AMOUNT');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'TOTAL DP');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H5', 'TOTAL DPP');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I5', 'TOTAL PPN');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J5', 'TOTAL INVOICE');

                $kolom = 6;
                $nomor = 1;
                $t01 = 0;
                $t02 = 0;
                $t03 = 0;
                $t04 = 0;
                $t05 = 0;
                $t06 = 0;
                $t07 = 0;

                // DETAIL

                foreach ($laporan as $sttb) {
                    $t01 += $sttb['total_amount'];
                    $t03 += $sttb['total_dp'];
                    $t04 += $sttb['total_dpp'];
                    $t05 += $sttb['total_ppn'];
                    $t07 += $sttb['total_invoice'];

                    $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                    $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $nomor);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $sttb['no_invoice']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, date('d-M-Y', strtotime($sttb['tgl_invoice'])));
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $sttb['no_suratjln']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $sttb['nama_customer']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $sttb['total_amount']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $sttb['total_dp']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $sttb['total_dpp']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $sttb['total_ppn']);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $sttb['total_invoice']);
                    $kolom++;
                    $nomor++;
                }

                // FOOTER TOTAL


                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('I' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('J' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $t01);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $t03);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $t04);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $kolom, $t05);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $kolom, $t07);

                $writer = new Xlsx($spreadsheet);
                $filename = 'lapjual27' .  '.xlsx';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename = ' . $filename . '');
                header('Cache-Control: max-age=0');
                ob_end_clean();
                $writer->save('php://output');
                exit;

        }
    }
}
