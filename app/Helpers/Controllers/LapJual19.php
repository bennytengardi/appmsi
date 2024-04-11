<?php

namespace App\Controllers;

use App\Models\ModelSalesman;
use App\Models\ModelSalesInv;
use App\Models\ModelReceipt;
use App\Models\ModelLapJual19;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual19 extends BaseController
{
    function __construct()
    {
        $this->ModelReceipt  = new ModelReceipt();
        $this->ModelSalesman = new ModelSalesman();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelLapJual19 = new ModelLapJual19();
    }

    public function index()
    {
        $data = [
            'title'  => 'Invoice Paid by Period',
            'dari'   => date("Y-m-01"),
            'sampai' => date("Y-m-d"),
        ];
        return view('lapjual19/filter', $data);
    }



    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $title = "Invoice Paid by Period";
        $title1 = session()->get('nama_company');
        $laporan = $this->ModelLapJual19->lapjual19($dari, $sampai);

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('lapjual19/tampil', $data);
        }

        if (isset($tombolExport)) {

            // HEADER
            $spreadsheet = new Spreadsheet;
            $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
            $spreadsheet->getActiveSheet()->mergeCells('A1:G1');
            $spreadsheet->getActiveSheet()->mergeCells('A2:G2');
            $spreadsheet->getActiveSheet()->mergeCells('A3:G3');

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
            $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

            $spreadsheet->getActiveSheet()->getStyle('A5:G5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle('A5:G5')->getFill()->getStartColor()->setARGB('FF4F81BD');
            $spreadsheet->getActiveSheet()->getStyle('A5:G5')
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $spreadsheet->getActiveSheet()->getStyle('A5:G5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(14);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(18);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'Date');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'No Reff');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'Customer');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'Deposit To');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'No Cheque');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'Discount');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'Total Paid');

            $kolom = 6;
            $tpot = 0;
            $tbyr = 0;
            $tgl = '';
            // DETAIL

            foreach ($laporan as $lap) {
                $tpot += $lap['total_potongan'];
                $tbyr += $lap['total_bayar'];

                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                if ($tgl != $lap['tgl_receipt']) {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, date('d-M-Y', strtotime($lap['tgl_receipt'])));
                }
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $lap['no_receipt']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['nama_customer']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['nama_account']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $lap['no_giro']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $lap['total_potongan']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $lap['total_bayar']);
                $tgl = $lap['tgl_receipt'];
                $kolom++;
            }

            // FOOTER TOTAL

            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $tpot);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $tbyr);

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapjual19' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
