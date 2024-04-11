<?php

namespace App\Controllers;

use App\Models\ModelSalesman;
use App\Models\ModelSalesInv;
use App\Models\ModelReceipt;
use App\Models\ModelLapJual12;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual12 extends BaseController
{
    function __construct()
    {
        $this->ModelReceipt  = new ModelReceipt();
        $this->ModelSalesman = new ModelSalesman();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelLapJual12 = new ModelLapJual12();
    }

    public function index()
    {
        $data = [
            'title'  => 'Laporan Pelunasan',
            'dari'   => date("Y-m-d"),
            'sampai' => date("Y-m-d"),
            'salesman' => $this->ModelSalesman->alldata(),
        ];
        return view('lapjual12/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodesales = $this->request->getPost('kode_salesman');
        $namasales = $this->ModelSalesman->detail($kodesales);

        $title = "LAPORAN PELUNASAN CUSTOMER";
        $title1 = session()->get('nama_company');

        $laporan = $this->ModelLapJual12->lapjual12($dari, $sampai, $kodesales);
        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('lapjual12/tampil', $data);
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
            $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));
            $spreadsheet->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A4')->getFont()->setSize(12);

            $spreadsheet->getActiveSheet()->getStyle('A5:H5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle('A5:H5')->getFill()->getStartColor()->setARGB('FF4F81BD');
            $spreadsheet->getActiveSheet()->getStyle('A5:H5')
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $spreadsheet->getActiveSheet()->getStyle('A5:H5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(16);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(16);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(16);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(16);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(16);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'NAMA CUSTOMER');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'TGL BUKTI');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'NO BUKTI');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'NO INVOICE');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'TGL INVOICE');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'TOTAL INVOICE');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'POTONGAN');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H5', 'JUMLAH BAYAR');

            $totpot = 0;
            $totbyr = 0;
            $totpot2 = 0;
            $totbyr2 = 0;
            $gtotpot = 0;
            $gtotbyr = 0;
            $kolom = 6;
            $sw = 0;
            $sw2 = 0;
            $kdcust = '';
            $kdsales = '';
            // DETAIL

            foreach ($laporan as $lap) {
                if ($kdcust <> $lap['kode_customer']) {
                    if ($sw2 == 1) {
                        $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, 'SUB TOTAL');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $totpot2);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $totbyr2);
                        $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);
                        $kolom = $kolom + 2;
                        $totpot2 = 0;
                        $totbyr2 = 0;
                    }
                }

                if ($kdsales <> $lap['kode_salesman']) {
                    if ($sw == 1) {
                        $kolom = $kolom + 1;
                        $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'F' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL SALESMAN');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $totpot);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $totbyr);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);
                        $totpot = 0;
                        $totbyr = 0;
                        $kolom = $kolom + 2;
                    }
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setSize(16);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_salesman']);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $kolom = $kolom + 2;
                }

                $totpot = $totpot + $lap['potongan'];
                $totbyr = $totbyr + $lap['jumlah_bayar'];
                $totpot2 = $totpot2 + $lap['potongan'];
                $totbyr2 = $totbyr2 + $lap['jumlah_bayar'];
                $gtotpot = $gtotpot + $lap['potongan'];
                $gtotbyr = $gtotbyr + $lap['jumlah_bayar'];
                $sw  = 1;
                $sw2 = 1;

                if ($lap['kode_customer'] != $kdcust) {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['nama_customer']);
                }

                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, date('d-M-Y', strtotime($lap['tgl_receipt'])));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['no_receipt']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['no_invoice']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, date('d-M-Y', strtotime($lap['tgl_invoice'])));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $lap['total_invoice']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $lap['potongan']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $lap['jumlah_bayar']);
                $kdsales = $lap['kode_salesman'];
                $kdcust  = $lap['kode_customer'];
                $kolom = $kolom + 1;
            }


            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, 'SUB TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $totpot2);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $totbyr2);
            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);
            $kolom = $kolom + 2;

            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'F' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL SALESMAN');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $totpot);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $totbyr);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);
            $kolom = $kolom + 2;


            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'F' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL SEMUA SALESMAN');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $gtotpot);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $kolom, $gtotbyr);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('H' . $kolom)->getFont()->setBold(true);

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapjual12' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
