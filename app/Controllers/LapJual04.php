<?php

namespace App\Controllers;

use App\Models\ModelCustomer;
use App\Models\ModelSalesInv;
use App\Models\ModelBarang;
use App\Models\ModelLapJual04;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LapJual04 extends BaseController
{
    function __construct()
    {
        $this->ModelSalesInv = new ModelSalesInv();
        $this->ModelCustomer = new ModelCustomer();
        $this->ModelBarang   = new ModelBarang();
        $this->ModelLapJual04 = new ModelLapJual04();
    }

    public function index()
    {
        $data = [
            'title'  => 'Sales Item by Customer',
            'dari'   => date("Y-m-01"),
            'sampai' => date("Y-m-d"),
            'customer' => $this->ModelCustomer->alldata2(),
        ];
        return view('lapjual04/filter', $data);
    }

    public function preview()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $dari      = $this->request->getPost('dari');
        $sampai    = $this->request->getPost('sampai');
        $kodecust  = $this->request->getPost('kode_customer');

        $title = "Sales Item by Customer";
        $title1 = session()->get('nama_company');
        $laporan = $this->ModelLapJual04->lapjual04($dari, $sampai, $kodecust);

        if (isset($tombolCetak)) {
            $data = array(
                'title' => $title,
                'title1' => session()->get('nama_company'),
                'laporan' => $laporan,
            );
            return view('lapjual04/tampil', $data);
        }

        if (isset($tombolExport)) {
            $spreadsheet = new Spreadsheet;
            $spreadsheet->getDefaultStyle()->getFont()->setName('Lucida Fax');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(9);
            $spreadsheet->getActiveSheet()->mergeCells('A1:D1');
            $spreadsheet->getActiveSheet()->mergeCells('A2:D2');
            $spreadsheet->getActiveSheet()->mergeCells('A3:D3');

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', $title1);
            $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $title);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', date('d-M-Y', strtotime($dari)) . " S/D " . date('d-M-Y', strtotime($sampai)));

            $spreadsheet->getActiveSheet()->getStyle('A5:D5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $spreadsheet->getActiveSheet()->getStyle('A5:D5')->getFill()->getStartColor()->setARGB('FF4F81BD');
            $spreadsheet->getActiveSheet()->getStyle('A5:D5')
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
            $spreadsheet->getActiveSheet()->getStyle('A5:D5')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(14);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'KODE BARANG');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'NAMA BARANG');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', 'TOTAL QTY');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'TOTAL RP');

            $kolom = 6;
            $tqty = 0;
            $tamt = 0;
            $gtqty = 0;
            $gtamt = 0;
            $kdcust = '';
            $sw = 0;
            foreach ($laporan as $lap) {
                if ($kdcust <> $lap['kode_customer']) {
                    if ($sw == 1) {
                        // $kolom = $kolom + 1;
                        $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                        $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'B' . $kolom);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $tqty);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $tamt);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);

                        $kolom = $kolom + 1;
                        $nomor = 1;
                        $tqty = 0;
                        $tamt = 0;
                    }
                    $kolom = $kolom + 1;
                    $customer = $this->ModelCustomer->detail($lap['kode_customer']);
                    $det = $customer['nama_customer'];
                    $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'D' . $kolom);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $det);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
                    $kdcust = $lap['kode_customer'];
                    $kolom = $kolom + 1;
                    $sw = 1;
                }

                $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $tqty += $lap['totqty'];
                $tamt += $lap['totrp'];
                $gtqty += $lap['totqty'];
                $gtamt += $lap['totrp'];

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $lap['kode_barang']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $lap['nama_barang']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $lap['totqty']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $lap['totrp']);
                $kolom++;
            }

            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'B' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'SUB TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $tqty);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $tamt);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);


            $kolom = $kolom + 2;
            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
            $spreadsheet->getActiveSheet()->mergeCells('A' . $kolom . ':' . 'B' . $kolom);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, 'TOTAL');
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, $gtqty);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $gtamt);
            $spreadsheet->getActiveSheet()->getStyle('A' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('C' . $kolom)->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('D' . $kolom)->getFont()->setBold(true);

            $writer = new Xlsx($spreadsheet);
            $filename = 'lapjual04' .  '.xlsx';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename = ' . $filename . '');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit;
        }
    }
}
