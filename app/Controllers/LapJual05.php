<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesInv;
use App\Models\ModelReceipt;
use App\Models\ModelLapJual05;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual05 extends BaseController
{
    function __construct()
    {
        $this->ModelReceipt  = new ModelReceipt();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelLapJual05 = new ModelLapJual05();
    }

    public function index()
    {
        $data = [
            'title'  => 'Invoice Paid by Customer',
            'dari'   => date("Y-m-01"),
            'sampai' => date("Y-m-d"),
            'customer' => $this->ModelCustomer->alldata2(),
        ];
        return view('lapjual05/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodecust  = $this->request->getPost('kode_customer');
        $title = "Invoice Paid by Customer";
        $title1 = session()->get('nama_company');
        $laporan = $this->ModelLapJual05->lapjual05($dari, $sampai, $kodecust);

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
                'kd'    => $kodecust
            );
            return view('lapjual05/tampil', $data);
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


            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(18);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'Date');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'No Reff');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'Invoice#');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'Invoice Date');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'Total Invoice');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'Discount');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'Total Paid');


            $kolom = 6;
            $nomor = 1;
            $tpot = 0;
            $tbyr = 0;
            $gtpot = 0;
            $gtbyr = 0;
            $sw = 0;
            $kdcust = '';
            // DETAIL

            foreach ($laporan as $sttb) {
                if ($kdcust <> $sttb['kode_customer']) {
                    if ($sw == 1) {
                        $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $tpot);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $tbyr);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);
                        $kolom = $kolom + 1;
                        $tbyr = 0;
                        $tpot = 0;
                    }
                    $kolom = $kolom + 1;
                    $customer = $this->ModelCustomer->detail($sttb['kode_customer']);
                    $det = $customer['nama_customer'];
                    $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $det);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $kdcust = $sttb['kode_customer'];
                    $kolom = $kolom + 1;
                }

                $sw = 1;
                $tpot += $sttb['potongan'];
                $tbyr += $sttb['jumlah_bayar'];
                $gtpot += $sttb['potongan'];
                $gtbyr += $sttb['jumlah_bayar'];

                $spreadsheet->getActiveSheet()->getStyle('E' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, date('d-M-Y', strtotime($sttb['tgl_receipt'])));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $sttb['no_receipt']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $sttb['no_invoice']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, date('d-M-Y', strtotime($sttb['tgl_invoice'])));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $sttb['total_invoice']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $sttb['potongan']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $sttb['jumlah_bayar']);
                $kolom++;
                $nomor++;
            }

            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $tpot);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $tbyr);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);

            $kolom = $kolom + 2;

            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'E' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $kolom, $gtpot);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $kolom, $gtbyr);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('F' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('G' . $kolom)->getFont()->setBold(true);

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapjual05' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
